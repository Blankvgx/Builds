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
    	case "login":
    	    return handleLogin($request['username'],$request['password']);
	case "validate":
            return doValidate($request['sessionId']);
        case "register":
            return handlereg($request['username'],$request['password']);
    }
    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$sessionId = null;
echo ' [x] Session ID is set to null: ', $sessionId, "\n";

function handlereg($username, $password) {
    // Create a new MySQL connection
    $mysqli = new mysqli("localhost", "IT490", "IT490", "imdb_database");

    // Check for connection errors
    if ($mysqli->connect_error) {
    	echo ' [x] Connection failed for login',"\n";
        die("Connection failed: " . $mysqli->connect_error);
    }
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result2 = $mysqli->query($query);
    
    if ($result2->num_rows > 0) {
        echo ' [x] User Failed, user already in system: ', $username, "\n";
        return false;
        echo ' FALSE';
    } else {
    $query = "INSERT INTO users (username, password) VALUES ('$username' , '$password')";
    $result = $mysqli->query($query);
        echo ' [x] User created with username: ', $username, "\n";
        return true;
        echo ' TRUE';
    }
    $result2->free();
    $result->free();
    $mysqli->close();
}

function handleLogin($username, $password) {
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

function doValidate($sessionId) {
    // Create a new MySQL connection
    $mysqli = new mysqli("localhost", "IT490", "IT490", "imdb_database");

    // Check for connection errors
    if ($mysqli->connect_error) {
    	echo ' [x] Connection failed for validation',"\n";
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Query to get the time for the given sessionId
    $query = "SELECT time FROM users WHERE sessionId = '$sessionId'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbTime = $row['time'];  // Time stored in the database (Unix timestamp)
        $currentTime = time();   // Current Unix timestamp

        echo ' [x] Validation TimeStamp: ', $currentTime , "\n";

        // Check if the difference is more than 30 seconds
        if (($currentTime - $dbTime) < 30) {
            echo ' [x] Session expired (more than 30 seconds since last validation)', "\n";
            return false;
        }

        // Update the time if validation is successful
        $updateQuery = "UPDATE users SET time = UNIX_TIMESTAMP() WHERE sessionId = '$sessionId'";
        $mysqli->query($updateQuery);

        echo ' [x] Processing Validation', "\n";
        echo ' [x] Validation Worked: ', $sessionId, "\n";
        return true;
    } else {
        echo ' [x] Validation failed: Invalid sessionId', "\n";
        return false;
    }

    // Close the result set and database connection
    $result->free();
    $mysqli->close();
}

// Create server object and start processing requests
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN", "\n";
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END";
?>

