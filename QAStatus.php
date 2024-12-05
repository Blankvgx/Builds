#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

if (isset($argv[1])) {
    $msg = $argv[1];
} else {
    $msg = "";
}

// Ask the user for the build number
echo "Enter the Project number: ";
$buildNumber = trim(fgets(STDIN));

// Validate the input
if (!ctype_digit($buildNumber)) {
    die("Error: Build number must be a valid number.\n");
}

// Dynamically generate the build name
$build = "Project" . $buildNumber;

echo "What is the build status (good/bad)? \n";
$status = trim(fgets(STDIN));

// Prepare the request array
$request = array();
$request['type'] = "status";
$request['status'] = $status;
$request['build'] = $build;

// Send the request to the RabbitMQ server
$response = $client->send_request($request);

// Display the response
echo "Client received response: " . PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0] . " END" . PHP_EOL;

