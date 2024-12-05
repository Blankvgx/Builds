<?php
// Recommendations.php Page
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

setcookie("sessionId", $_COOKIE['sessionId'], time() + 3600, "/"); 
setcookie("username", $_COOKIE['username'], time() + 3600, "/");

// Check if sessionID and username are set in the cookies
if (!isset($_COOKIE['sessionId']) || !isset($_COOKIE['username'])) {
    echo "<h1>No session found. Please log in.</h1>";
    echo "<a href='login.html'><button class='back-button'>Log in again</button></a>";
    exit();
}

$username = $_COOKIE['username'];

// Create a RabbitMQ client
try {
    if(!$client){
        $client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
    }
} catch (Exception $e) {
    echo "Error connecting to RabbitMQ: " . $e->getMessage();
    exit();
}

$data = [];
$request = array();
$request['type'] = "get_recommendations";
$request['rating_table'] = $username . "_rating";
$response = $client->send_request($request);
$data = $response ?: [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Recommendations</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Background styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
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
        }

        .header a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }

        /* Content container */
        .content-container {
            width: 90%;
            max-width: 1000px;
            margin-top: 80px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        /* Recommendations section */
        .recommendations-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .recommendations-section h3 {
            text-align: center;
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .movie-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .movie-card:last-child {
            border-bottom: none;
        }

        .movie-details {
            flex-grow: 1;
            text-align: left;
        }

        .movie-title {
            font-weight: bold;
            color: #333;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .content-container {
                width: 95%;
            }

            h1 {
                font-size: 1.5rem;
            }

            .movie-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .movie-title {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2rem;
            }

            .movie-title {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<!-- Header with Navigation Links -->
<div class="header">
    <img src="logo.png" alt="Logo">
    <div>
        <a href="login.html">Logout</a>
        <a href="profile.php">Profile</a>
        <a href="Search.php">Back to Search</a>
    </div>
</div>

<div class="content-container">
    <h1>Movie Recommendations for <?php echo htmlspecialchars($username); ?></h1>

    <!-- Recommendations Section -->
    <div class="recommendations-section">
        <h3>Recommended Movies</h3>
        <?php if (!empty($data)): ?>
            <?php foreach ($data as $movie): ?>
                <div class="movie-card">
                    <div class="movie-details">
                        <div class="movie-title"><?php echo htmlspecialchars($movie); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No movie recommendations available.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

