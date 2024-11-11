<?php
require_once __DIR__ . '/vendor/autoload.php';  // Include RabbitMQ library
require_once 'testRabbitMQ.ini';  // Include the RabbitMQ host info file
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
        // Create connection to RabbitMQ
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

        // Declare an exchange
        $channel->exchange_declare($exchange, 'topic', false, true, false);

        // Declare a queue
        $channel->queue_declare($queue, false, true, false, false);

        // Bind the queue to the exchange
        $channel->queue_bind($queue, $exchange);

        // Start consuming messages from the queue
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
    	    return handleBuild($request['username'],$request['password']);
    }
    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

function handleBuild($username, $password) {
    // Create a new MySQL connection
    $mysqli = new mysqli("localhost", "IT490", "IT490", "imdb_database");

    // Check for connection errors
    if ($mysqli->connect_error) {
    	echo ' [x] Connection failed for login',"\n";
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $mysqli->query($query);
    
    $updateQuery = "UPDATE users SET time = UNIX_TIMESTAMP() WHERE username = '$username'";
    echo ' [x] Updating TimeStamp: ', time() , "\n";
    
    if ($result->num_rows > 0) {
        echo ' [x] Processing login for ', $username, "\n";

        //$sessionId = "IT490"; // Generate a secure session ID
	$sessionId = bin2hex(random_bytes(16));  // Generate a secure session ID
        $updateQuery = "UPDATE users SET sessionId = '$sessionId' WHERE username = '$username'";
        echo ' [x] Updated session table ', "\n";
        $mysqli->query($updateQuery);
        
        $request = array();
        $request['status'] = true;
    	$request['sessionId'] = $sessionId;

        echo ' [x] Session created for ', $username, "\n";
        echo ' [x] Session ID is set to ', $sessionId, "\n";
        return $request;
    } else {
        
        echo ' [x] Login failed for ', $username, "\n";
        return false;
    }
    
    $result->free();
    $mysqli->close();
}

// Create server object and start processing requests
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN", "\n";
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END";
?>

