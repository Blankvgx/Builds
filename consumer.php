<?php
//Consumer.php Page
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

function requestProcessor($request)
{
	echo "received request".PHP_EOL;

	var_dump($request);
 
	if(!isset($request['type']))
	{
    	   	return "ERROR: unsupported message type";
	}
	switch ($request['type'])
	{
	    	case "build":
			return handleBuilds($request['build_name']);
		case "status":
			return handleStatus($request['status'],$request['build'],$request['version']);
	}
	return array("returnCode" => '0', 'message' => "Server received request and processed");
}

function handleStatus($status, $build, $version) {
    $mysqli = new mysqli("localhost", "IT490", "IT490", "builds");

    if ($mysqli->connect_error) {
        echo ' [x] Connection failed for Handling Status:', "\n";
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Check if the specific version for the build exists
    $query = "SELECT * FROM builds WHERE build = ? AND version = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $build, $version);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // If the version exists, update the status
            $query = "UPDATE builds SET status = ? WHERE build = ? AND version = ?";
            $stmt = $mysqli->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ssi", $status, $build, $version);
                if ($stmt->execute()) {
                    echo '[✓] Build Status Updated for ' . $build . ' version ' . $version . ': ' . $status, "\n";
                } else {
                    echo '[x] Query Execution Error: ', $stmt->error, "\n";
                }
            }
        } else {
            // If version doesn't exist, alert that version is not found
            echo "[x] Error: Version " . $version . " for build " . $build . " does not exist.\n";
        }

        $stmt->close();
    } else {
        echo '[x] Query Preparation Error: ', $mysqli->error, "\n";
    }

    $mysqli->close();
    return false;
}

function handleBuilds($build_name) {
    $mysqli = new mysqli("localhost", "IT490", "IT490", "builds");

    if ($mysqli->connect_error) {
        echo ' [x] Connection failed for Handling Builds:', "\n";
        die("Connection failed: " . $mysqli->connect_error);
    }

    echo ' [x] Receiving File: ' . $build_name, "\n";

    // Initialize version variable
    $version = null;

    // Get the max version for the build
    $query = "SELECT MAX(version) AS max_version FROM builds WHERE build = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $build_name);
        $stmt->execute();
        $stmt->bind_result($max_version);
        $stmt->fetch();

        if ($max_version === null) {
            $version = 1.0;
        } else {
            $version = $max_version + 1.0; // Increment version number
        }
        $stmt->close();
    } else {
        echo '[x] Query Preparation Error: ', $mysqli->error, "\n";
        return false;
    }

    // Insert the new build version into the database
    $query = "INSERT INTO builds (build, version, created) VALUES (?, ?, UNIX_TIMESTAMP())";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sd", $build_name, $version); // "s" -> string, "d" -> double
        if ($stmt->execute()) {
            echo '[✓] Build ' . $build_name . ' version ' . $version . ' added to the table', "\n";
        } else {
            echo "[x] Query Execution Error: " . $stmt->error, "\n";
            $version = null; // Ensure no version is returned on failure
        }
        $stmt->close();
    } else {
        echo '[x] Query Preparation Error: ', $mysqli->error, "\n";
        $version = null; // Ensure no version is returned on failure
    }

    $mysqli->close();

    // Check if version was successfully updated/created
    if ($version !== null) {
        // Return the new version information
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
