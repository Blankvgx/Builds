<?php
// Profile.php Page

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

setcookie("sessionId", $_COOKIE['sessionId'], time() + 3600, "/"); 
setcookie("username", $_COOKIE['username'], time() + 3600, "/");
// Check if sessionID and username are set in the cookies
if (!isset($_COOKIE['sessionId'])) {
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

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_movie'])) {
    $movie_to_delete = $_POST['delete_movie'];
    
    $request = array();
    $request['type'] = "delete_watchlist";
    $request['watchlist_table'] = $username . "_watchlist";
    $request['movie_name'] = $movie_to_delete;
    
    $response = $client->send_request($request);
}

// Request for the watchlist table
$request = array();
$request['type'] = "get_watchlist";
$request['watchlist_table'] = $username . "_watchlist";
$response1 = $client->send_request($request);
$watchlist_data = $response1;

$request = array();
$request['type'] = "get_ratings";
$request['rating_table'] = $username . "_rating";
$response2 = $client->send_request($request);
$rating_data = $response2;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?>'s Profile</title>
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
            margin: 0;
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
            display: grid;
            gap: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 1.8rem;
        }

        /* Table section styling */
        .table-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .table-section h3 {
            text-align: center;
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        /* Button styling */
        .delete-button {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 15px;
                text-align: center;
            }

            .content-container {
                width: 95%;
            }

            h1 {
                font-size: 1.5rem;
            }

            th, td {
                padding: 10px;
                font-size: 0.9rem;
            }

            .delete-button {
                padding: 5px 8px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2rem;
            }

            th, td {
                padding: 8px;
                font-size: 0.8rem;
            }

            .delete-button {
                padding: 5px 6px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <img src="logo.png" alt="Logo">
    <div>
        <a href="login.html">Logout</a>
        <a href="Search.php">Back to Search</a>
        <a href="recommendations.php">Recommendation</a>
    </div>
</div>

<div class="content-container">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

    <!-- Watchlist Section -->
    <div class="table-section">
        <h3>Your Watchlist</h3>
        <?php if (!empty($watchlist_data)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Movie Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($watchlist_data as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['Movies']); ?></td>
                            <td>
                                <form method="post" action="profile.php" style="display:inline;">
                                    <input type="hidden" name="delete_movie" value="<?php echo htmlspecialchars($item['Movies']); ?>">
                                    <button type="submit" class="delete-button">Remove From Watchlist</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No movies in your watchlist.</p>
        <?php endif; ?>
    </div>

    <!-- Ratings Section -->
    <div class="table-section">
        <h3>Your Ratings</h3>
        <?php if (!empty($rating_data)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Movie Name</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rating_data as $rating): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($rating['Movies']); ?></td>
                            <td><?php echo htmlspecialchars($rating['Rating']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No ratings available.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

