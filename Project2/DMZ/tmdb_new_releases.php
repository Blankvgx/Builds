<?php

require_once __DIR__ . '/vendor/autoload.php';

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

function getMovieTitlesReleasedToday($apiKey) {
    // Get today's date in YYYY-MM-DD format
    $today = date('Y-m-d');
    
    // TMDB API URL to fetch movies released today
    $url = "https://api.themoviedb.org/3/discover/movie?api_key=$apiKey&primary_release_date.gte=$today&primary_release_date.lte=$today";
    echo ' [x] Fetching New Released: ', "\n";

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return [];
    }

    // Close cURL
    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if movies are found
    if (isset($data['results'])) {
        // Create an array to store movie titles
        $movieTitles = [];

        foreach ($data['results'] as $movie) {
            // Append the movie title to the array
            $movieTitles[] = $movie['title'];
            echo ' [x] Appending movie title: ', $movie['title'], "\n";
        }
        return $movieTitles;  // Return the array of movie titles
        
    }

    return [];  // Return an empty array if no movies found
}


//For the love of god stop making your own rabbit Connections
function sendMovieTitlesToRabbitMQ($NewReleaseTitles) {
    // Define RabbitMQ connection settings
    $host = '172.24.138.28';
    $port = 5672;
    $username = 'test';
    $password = 'test';
    $vhost = 'testHost';
    $queue = 'DMZDatabase';

    // Create a connection to RabbitMQ
    $connection = new AMQPStreamConnection($host, $port, $username, $password, $vhost);
    $channel = $connection->channel();

    // Declare the queue (ensure the queue exists)
    $channel->queue_declare($queue, false, true, false, false);

    // Convert the movie titles array to JSON
    $messageBody = json_encode($NewReleaseTitles);

    // Create a message and publish it to the queue
    $message = new AMQPMessage($messageBody, ['delivery_mode' => 2]);  // Delivery mode 2 makes the message persistent
    $channel->basic_publish($message, '', $queue);

    echo " [x] Sent movie titles to RabbitMQ\n";

    // Close the channel and connection
    $channel->close();
    $connection->close();
}

$apiKey = '8ff7e10f47b5a38149694f4798d9176d';
$NewReleaseTitles = getMovieTitlesReleasedToday($apiKey);
//echo '<pre>'; print_r($NewReleaseTitles); echo '<pre>';
//Sending it to rabbitmq
$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
$request = array();
$request['type'] = 'NewMovies';
$request['moviesReleased'] = $NewReleaseTitles;
//echo '<pre>'; print_r($array); echo '<pre>';
//could just publish this but eh
$client->send_request($request);
?>
