#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
//require_once('testRabbitMQ2.ini');

$client = new rabbitMQClient("testRabbitMQ2.ini","testServer2");

$request = array();
$request['type'] = 'get_reccomendations';
$request['movie_name'] = $movie;

echo "client received response: ".PHP_EOL;
echo "\n\n";

try{
$response = $client->send_request($request);
print_r($response);
}finally{
unset($rabbitMQClient);
}
