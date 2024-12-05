#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('tmdb_new_releases.php');

$server = new rabbitMQServer("testRabbitMQ2.ini","testServer2");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;

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
	case "movie_title":
		echo ' [x] Sending Back Array: ', "\n";
  		return handleSearch($request['movie1']);
  	case "get_reccomendations":
  		echo "Attempting Reccomendations:", "\n";
  		return handleRecommendations($request['movie_name']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}
// TODO Movie Search:
function handleSearch($title) {
	echo ' [x] Handle is working: ', "\n";
	$apiKey = '13db636387987b24f85de0b1b7b2f8e2'; // Replace with your actual TMDB API key
	$baseUrl = 'https://api.themoviedb.org/3/search/movie';

	// Prepare the API request URL
	$query = urlencode($title); // Encode the movie title for URL compatibility
	$url = "{$baseUrl}?api_key={$apiKey}&query={$query}";

	// Initialize a cURL session
	$ch = curl_init();

	// Set the cURL options
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string

	// Execute the cURL session and get the response
	$response = curl_exec($ch);

	// Check for cURL errors
	if (curl_errno($ch)) {
    	echo ' [x] cURL error: ' . curl_error($ch), "\n";
    	return array("status" => false, "message" => "Error connecting to the movie database.");
	}

	// Close the cURL session
	curl_close($ch);

	// Decode the JSON response
	$result = json_decode($response, true);

	// Check if the API returned any results
	if (isset($result['results']) && count($result['results']) > 0) {
    	// Return the first movie in the search results
    	$movie = $result['results'][0];
    	echo ' [x] Movie found: ', $movie['title'], "\n";

    	// Construct and return movie details
    	return array(
        	"status" => true,
        	"name" => $movie['title'],
        	"overview" => $movie['overview'],
        	"poster_path" => $movie['poster_path'],
        	"tagline" => $movie['tagline'] ?? 'Tagline Not Available' // Handle optional tagline
    	);
	} else {
    	echo ' [x] Movie not found: ', $title, "\n";
    	return array("status" => false, "message" => "Movie not found.");
	}
}

function handleRecommendations($title) {

    echo ' [x] Handle is working: ', "\n";
    
    echo ' [x] Received title: ', print_r($title, true), "\n";
    if (!is_array($title) || count($title) === 0) {
        return array("status" => false, "message" => "Invalid title input. Expected a non-empty array.");
    }
    
    // Retrieve the movie title using the 'Movies' key
    $movieTitle = $title['Movies'];
    
    $apiKey = '13db636387987b24f85de0b1b7b2f8e2'; // Replace with your actual TMDB API key
    $baseUrl = 'https://api.themoviedb.org/3/search/movie';

    // Prepare the API request URL
    $query = urlencode($movieTitle); // Encode the movie title for URL compatibility
    $url = "{$baseUrl}?api_key={$apiKey}&query={$query}";

    // Initialize a cURL session
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return the response as a string

    // Execute the cURL session and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo ' [x] cURL error: ' . curl_error($ch), "\n";
        return array("status" => false, "message" => "Error connecting to the movie database.");
    }

    // Close the cURL session
    curl_close($ch);

    // Decode the JSON response
    $result = json_decode($response, true);

    // Check if the API returned any results
    if (isset($result['results']) && count($result['results']) > 0) {
        // Return the first movie in the search results
        $movie = $result['results'][0];
        echo ' [x] Movie found: ', $movie['title'], ' (ID: ', $movie['id'], ")\n";

        //Remake our URL to send an ID to grab back a similar movie
        $similarUrl = "https://api.themoviedb.org/3/movie/{$movie['id']}/similar?api_key={$apiKey}";

        // TURN THE CURL SESSION BACK ON
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $similarUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Execute curl
        $similarResponse = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo ' [x] cURL error: ' . curl_error($ch), "\n";
            return array("status" => false, "message" => "Couldnt get to TMDB, error in cURL.");
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the JSON response
        $similarResult = json_decode($similarResponse, true);
        //echo ' [x] Similiar Results: ', print_r($similarResult, true), ")\n";

        // Check if the similar movies API returned any results
        if (isset($similarResult['results']) && count($similarResult['results']) > 0) {
            //Get the first result and throw it back towards the DB
            $firstSimilarMovie = $similarResult['results'][0];
            echo ' [x] First Movie Results: ', print_r($firstSimilarMovie, true), ")\n";
            
            return $firstSimilarMovie['title'];
            
            
        } else {
            return array("status" => false, "message" => "No movies returned from the SIMILAR call");
        }
    } else {
        return array("status" => false, "message" => "No movies returned from the SEARCH call");
    }
}

?>

