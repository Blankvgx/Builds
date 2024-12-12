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

// Ask the user for the build name
echo "Enter the build name: ";
$buildName = trim(fgets(STDIN));

// Ask the user for the version number
echo "Enter the version number: ";
$versionNumber = trim(fgets(STDIN));

// Ask the user for the status (passed/failed)
echo "Enter the status (passed/failed): ";
$status = trim(fgets(STDIN));

// Validate the version number (ensure it's a positive integer)
if (!ctype_digit($versionNumber) || $versionNumber <= 0) {
    die("Error: Version number must be a valid positive integer.\n");
}

// Prepare the request array
$request = array();
$request['type'] = "status";
$request['status'] = $status; 
$request['build'] = $buildName;
$request['version'] = $versionNumber;

// Send the request to the RabbitMQ server
$response = $client->send_request($request);

// Display the response
echo "Client received response: " . PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0] . " END" . PHP_EOL;
?>

