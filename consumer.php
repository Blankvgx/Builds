<?php
// Consumer.php Page
require_once __DIR__ . '/vendor/autoload.php';
require_once 'testRabbitMQ.ini';
require_once 'rabbitMQLib.inc';
require_once 'path.inc';
require_once 'get_host_info.inc';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class testRabbitMQServer {
    private $host;
    private $port;
    private $username;
    private $password;
    private $vhost;
    private $server_name;

    public function __construct($config_file, $server_name) {
        $config = parse_ini_file($config_file, true);
        $this->host = $config[$server_name]['BROKER_HOST'];
        $this->port = $config[$server_name]['BROKER_PORT'];
        $this->username = $config[$server_name]['USER'];
        $this->password = $config[$server_name]['PASSWORD'];
        $this->vhost = $config[$server_name]['VHOST'];
        $this->server_name = $server_name;
    }

    public function process_requests($callback) {
        $connection = new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->username,
            $this->password,
            $this->vhost
        );

        $channel = $connection->channel();

        $exchange = 'testExchange';
        $queue = 'testQueue';

        $channel->exchange_declare($exchange, 'topic', false, true, false);
        $channel->queue_declare($queue, false, true, false, false);
        $channel->queue_bind($queue, $exchange);

        $channel->basic_consume($queue, '', false, false, false, false, function($msg) use ($callback, $channel) {
            $response = call_user_func($callback, $msg);
            $channel->basic_ack($msg->delivery_info['delivery_tag']);	 
            $channel->wait();
        });
       
        $channel->close();
        $connection->close();
    }
}

function requestProcessor($request) {
    echo "received request" . PHP_EOL;

    var_dump($request);

    if (!isset($request['type'])) {
        return "ERROR: unsupported message type";
    }
    switch ($request['type']) {
        case "build":
            return handleBuilds($request['build_name']);
        case "status":
            return handleStatus($request['status'], $request['build'], $request['version'], $request['devIP']);
    }
    return array("returnCode" => '0', 'message' => "Server received request and processed");
}

function handleStatus($status, $build, $version, $ipDest) {
    $mysqli = new mysqli("localhost", "IT490", "IT490", "builds");

    if ($mysqli->connect_error) {
        echo ' [x] Connection failed for Handling Status:', "\n";
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Ensure the version number is treated as a string
    $query = "SELECT * FROM builds WHERE build = ? AND version = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $build, $version); // Ensure both are treated as strings
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Update the current build version's status
            $query = "UPDATE builds SET status = ? WHERE build = ? AND version = ?";
            $stmt = $mysqli->prepare($query);
            if ($stmt) {
                $stmt->bind_param("sss", $status, $build, $version); // Ensure both are treated as strings
                if ($stmt->execute()) {
                    echo '[✓] Build Status Updated for ' . $build . ' version ' . $version . ': ' . $status, "\n";

                    if ($status === 'failed') {
                        // Fetch the latest working version (a version that passed)
                        $query = "SELECT version FROM builds WHERE build = ? AND status = 'passed' ORDER BY version DESC LIMIT 1";
                        $stmt = $mysqli->prepare($query);
                        if ($stmt) {
                            $stmt->bind_param("s", $build);
                            $stmt->execute();
                            $stmt->bind_result($latestWorkingVersion);
                            if ($stmt->fetch()) {
                                echo "[!] Latest working version: $latestWorkingVersion. Initiating rsync...\n";

                                // Use the devIP from the request to sync to the right machine
                                if (isset($ipDest)) {
                                    performRsync($build, $latestWorkingVersion, $ipDest);
                                } else {
                                    echo "[x] Error: No destination IP provided.\n";
                                }

                                return array("latestWorkingVersion" => $latestWorkingVersion);
                            } else {
                                return array("latestWorkingVersion" => null, "message" => "No working version found.");
                            }
                        }
                    }
                } else {
                    echo '[x] Error: ', $stmt->error, "\n";
                }
            }
        } else {
            echo "[x] Error: Version " . $version . " for build " . $build . " does not exist.\n";
        }

        $stmt->close();
    } else {
        echo '[x] Query Preparation Error: ', $mysqli->error, "\n";
    }

    $mysqli->close();
    return false;
}

function performRsync($buildName, $projectNumber, $ipDest) {
    $remoteUser = "brianfriday";
    $remotePath = "/home/brianfriday/git";
    $password = "04202003";

    $localDirectories = [
        "/home/markcgv/git/Builds/{$buildName}v{$projectNumber}/"
    ];

    foreach ($localDirectories as $index => $localDirectory) {
        if (!is_dir($localDirectory)) {
            echo "Warning: Local directory does not exist: $localDirectory. Skipping...\n";
            continue;
        }

        // Use the provided destination IP
        $rsyncCommand = "rsync -az $localDirectory $remoteUser@$ipDest:$remotePath";

        $expectScript = <<<EOD
#!/usr/bin/expect -f
log_file /tmp/expect_log.txt
set timeout 60
set password "$password"
spawn bash -c "$rsyncCommand"
expect {
    "password:" {
        send "\$password\r"
        exp_continue
    }
    eof
}
EOD;

        $expectScriptPath = "/tmp/rsync_with_password.exp";
        file_put_contents($expectScriptPath, $expectScript);
        chmod($expectScriptPath, 0700);

        echo "Syncing $localDirectory to $$ipDest...\n";
        $output = shell_exec("expect $expectScriptPath 2>&1");
        echo "Output:\n$output\n";

        unlink($expectScriptPath);
    }

    echo "Rsync completed for build: {$buildName}v{$projectNumber}.\n";
}

function handleBuilds($build_name) {
    $mysqli = new mysqli("localhost", "IT490", "IT490", "builds");

    if ($mysqli->connect_error) {
        echo ' [x] Connection failed for Handling Builds:', "\n";
        die("Connection failed: " . $mysqli->connect_error);
    }

    echo ' [x] Receiving File: ' . $build_name, "\n";

    $version = null;

    $query = "SELECT MAX(version) AS max_version FROM builds WHERE build = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $build_name);
        $stmt->execute();
        $stmt->bind_result($max_version);
        $stmt->fetch();

        if ($max_version === null) {
            $version = 1; // Start with version 1
        } else {
            // Convert version to integer (e.g., "1.1" => 11)
            $version_int = (int)(floatval($max_version) * 10);
            $version_int += 1; // Increment version
            $version = $version_int / 10; // Convert back to float (e.g., 12 => "1.2")
        }
        $stmt->close();
    } else {
        echo '[x] Query Preparation Error: ', $mysqli->error, "\n";
        return false;
    }

    $query = "INSERT INTO builds (build, version, created) VALUES (?, ?, UNIX_TIMESTAMP())";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sd", $build_name, $version); // "d" for float
        if ($stmt->execute()) {
            echo '[✓] Build ' . $build_name . ' version ' . $version . ' added to the table', "\n";
        } else {
            echo "[x] Query Execution Error: " . $stmt->error, "\n";
            $version = null;
        }
        $stmt->close();
    } else {
        echo '[x] Query Preparation Error: ', $mysqli->error, "\n";
        $version = null;
    }

    $mysqli->close();

    if ($version !== null) {
        $request = array();
        $request['type'] = "buildVersion";
        $request['version'] = "v" . $version;
        return $request;
    } else {
        echo "[x] Build version creation failed. No version returned.\n";
        return false;
    }
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN", "\n";
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END";
?>
