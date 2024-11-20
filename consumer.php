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
			return handleStatus($request['status'],$request['build']);
	}
	return array("returnCode" => '0', 'message' => "Server received request and processed");
}

function handleStatus($status, $build) {
    $mysqli = new mysqli("localhost", "IT490", "IT490", "builds");

    if ($mysqli->connect_error) {
        echo ' [x] Connection failed for Handling Status:', "\n";
        die("Connection failed: " . $mysqli->connect_error);
    }

    $query = "UPDATE builds SET status = ? WHERE build = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $status, $build);
        if ($stmt->execute()) {
            echo '[✓] Build Status Updated: ', $status, "\n";
            $stmt->close();
            $mysqli->close();
            return true;
        } else {
            echo '[x] Query Execution Error: ', $stmt->error, "\n";
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
    $query = "INSERT INTO builds (build, created) VALUES ('$build_name', NOW())";
    $result = $mysqli->query($query);

    if ($result) {
        echo '[x] File added to table', "\n";
        return true;
    } else {
        echo "Query error: " . $mysqli->error;
        return false;
    }
}


$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN", "\n";
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END";
?>
