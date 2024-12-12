<?php
//Search.php Page

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Reset the cookie timer to 1 hour (3600 seconds) every time user visits the search page
setcookie("sessionId", $_COOKIE['sessionId'], time() + 3600, "/"); // Fixed timer to 3600 seconds (1 hour)
setcookie("username", $_COOKIE['username'], time() + 3600, "/");

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
    }
} catch (Exception $e) {
    echo "Error connecting to RabbitMQ: " . $e->getMessage();
    exit();
}

// If the form is submitted (user searches for a movie)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_name = trim($_POST['movie_name']); // Trim whitespace

    // Prepare the search request
    $request = array();
    $request['type'] = "search_movie";
    $request['title'] = $movie_name;

    try {
        // Send the search request and receive a response
        $response = $client->send_request($request);

        if ($response['name'] === $movie_name) {
            // Redirect to movie_profile.php with movie details
            $name = urlencode($response['name']); 
            $overview = urlencode($response['overview']);
            $poster_path = urlencode($response['poster_path']);
            $tagline = urlencode($response['tagline']);
            
            header("Location: movie_profile.php?name=$name&overview=$overview&poster_path=$poster_path&tagline=$tagline");
            exit();
        } else {
            // Movie not found in the database
            echo "<h1>Movie not found.</h1>";
        }

    } catch (Exception $e) {
        echo "Error sending search request to RabbitMQ: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Movies</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Background styles */
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        /* Black blur overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(2px);
            z-index: 0;
        }

        /* Header styling */
        .header {
            background-color: #50C878;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 2;
        }

        .header img {
            height: 40px;
            margin-right: 10px;
        }

        .header a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }

        /* Container styling */
        .container {
            display: grid;
            place-items: center;
            z-index: 3;
            width: 90%;
            max-width: 400px;
            margin-top: 80px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        form {
            display: grid;
            gap: 15px;
            width: 100%;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button, .back-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            color: white;
        }

        button {
            background-color: #28a745;
        }

        button:hover {
            background-color: #218838;
        }

        .back-button {
            background-color: #007bff;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }
            .container {
                width: 90%;
                margin-top: 100px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2rem;
            }
            button, .back-button, input[type="text"] {
                font-size: 0.9rem;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>

<!-- Header with Logout and Profile links -->
<div class="header">
    <img src="logo.png" alt="Logo"> <!-- Logo on the left -->
    <div>
        <a href="login.html">Logout</a>
        <a href="profile.php">Profile</a>
        <a href="recommendations.php">Recommendations</a>
    </div>
</div>

<div class="container">
    <h1>Search for a Movie</h1>
    <!-- Search bar and button -->
    <form method="post" action="Search.php">
        <input type="text" name="movie_name" placeholder="Enter movie name" required>
        <button type="submit">Search</button>
    </form>
</div>

</body>
</html>

