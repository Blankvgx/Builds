#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

try {
    // Create a RabbitMQ client
    if(!$client){
    	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
    echo "Connected to RabbitMQ successfully!<br>";
    }
    else{
    	echo "already have client instance";
    	}
    	

} catch (Exception $e) {
    // Catch and display any connection error
    echo "Error connecting to RabbitMQ: " . $e->getMessage();
    header("Location: rabbitmq_error.php");
    exit();  // Stop execution if there's an error
}

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    }
$request = array();
$request['type'] = "login";
$request['username'] = $username;
$request['password'] = $password;
//$request['message'] = $msg;
$response = $client->send_request($request);
//echo "client received response: ".PHP_EOL;
//Testing if Response is true or false

if($response['status'] === true){
	echo "Response was true!".PHP_EOL;
	print_r($response);
	$sessionId = $response['sessionId'];
	setcookie("sessionId", $sessionId, time() + 3600, "/");
	setcookie("username", $username, time() + 3600, "/");
	header("Location: success.php");
        exit();
} else if ($response === false){
	echo "Response was false!".PHP_EOL;
	header("Location: failure.php");
        exit();
}
else {
	echo "Response is not true and false!" .PHP_EOL;
	header("Location: nothing.html");
        exit();
        }

echo "\n\n";

echo $argv[0]." END".PHP_EOL;
