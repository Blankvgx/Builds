<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Check if sessionID is set in the cookie
if (!isset($_COOKIE['sessionId'])) {
    echo "<h1>No sessionID found. Please log in.</h1>";
    echo "<a href='login.html'><button class='back-button'>Log in again</button></a>";
    exit();
}

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
    exit();
}

// Prepare the session validation request
$sessionId = $_COOKIE['sessionId'];
$request = array();
$request['type'] = "validate";
$request['sessionId'] = $sessionId;

try {
    // Send the session validation request and receive the response
    $response = $client->send_request($request);

    if ($response === true) {
        // Session is valid, continue to the page
        //echo "<h1>Yahooo! You have successfully logged in</h1>";
        header("Location: Search.php");
    } else {
        // Session is not valid or has expired
        echo "<h1>Your session has expired or is invalid. Please log in again.</h1>";
        echo "<a href='login.html'><button class='back-button'>Log in again</button></a>";
        exit();
    }

} catch (Exception $e) {
    echo "Error sending request to RabbitMQ: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin-top: 100px;
        }
        h1 {
            color: green;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Back to Login Button -->
<button class="back-button" onclick="window.location.href='login.html';">Back to Login</button>

</body>
</html>

