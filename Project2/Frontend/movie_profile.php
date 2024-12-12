<?php
// Movie_profile.php Page
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Reset the cookie timer to 1 hour (3600 seconds) every time user visits the search page
setcookie("sessionId", $_COOKIE['sessionId'], time() + 3600, "/");
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
    echo "Connected to RabbitMQ successfully!<br>";
    }
} catch (Exception $e) {
    echo "Error connecting to RabbitMQ: " . $e->getMessage();
    exit();
}

// Decode the URL-encoded parameters
$name = urldecode($_GET['name']);
$overview = urldecode($_GET['overview']);
$poster_path = urldecode($_GET['poster_path']);
$tagline = urldecode($_GET['tagline']);

$username1 = $_COOKIE['username'];

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        // Prepare the comment array
        $request = array();
        $request['type'] = "comment";
        $request['username'] = $username1;
        $request['movie_name'] = $name;
        $request['comment'] = $comment;
        $response = $client->send_request($request);

        if ($response['status']) {
            echo "Comment successfully submitted.";
        } else {
            echo "Failed to submit comment.";
        }
    } else {
        echo "Comment cannot be empty.";
    }
}

// Handle rating submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['movie_rating'])) {
    $movie_rating = $_POST['movie_rating'];
    // Prepare the rating request
    $request = array();
    $request['type'] = "rating";
    $request['rating_table'] = $username1 . "_rating";
    $request['movie_name'] = $name;
    $request['movie_rating'] = $movie_rating;
    $response = $client->send_request($request);

    if ($response === false) {
        header("Location: rating_done.php");
        exit();
    }
}

// Handle watchlist addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_watchlist'])) {
    $request = array();
    $request['type'] = "watchlist";
    $request['watchlist_table'] = $username1 . "_watchlist";
    $request['movie_name'] = $name;
    $response = $client->send_request($request);

    if ($response === false) {
        header("Location: watchlist_done.php");
        exit();
    }
}

// Fetch comments
$request = array();
$request['type'] = "fetch_comments";
$request['movie_name'] = $name;
$response = $client->send_request($request);
$comments_data = $response ?: [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?> - Movie Profile</title>
    <style>
        /* Reset */
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
            text-align: center;
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

        /* Movie container styling */
        .movie-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 80px;
            max-width: 600px;
            width: 90%;
        }

        .movie-poster img {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .movie-details {
            text-align: center;
        }

        h1 {
            color: green;
            font-size: 1.8rem;
        }

        .tagline {
            font-style: italic;
            color: #555;
            margin-top: 10px;
        }

        p {
            line-height: 1.6;
        }

        /* Form styles */
        form {
            margin-top: 20px;
            width: 100%;
        }

        input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            max-width: 300px;
            margin: auto;
            display: block;
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

        .comments-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 100%;
        }

        .comment-card {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .comment-time {
            color: #999;
            font-size: 0.9em;
            margin-left: auto;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
            }

            .movie-container {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 1.5rem;
            }

            button {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2rem;
            }

            input[type="number"], textarea, button {
                font-size: 0.8rem;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <img src="logo.png" alt="Logo">
    <div>
        <a href="login.html">Logout</a>
        <a href="profile.php">Profile</a>
        <a href="recommendations.php">Recommendations</a>
    </div>
</div>

<div class="movie-container">
    <div class="movie-poster">
        <img src="https://image.tmdb.org/t/p/w500/<?php echo htmlspecialchars($poster_path); ?>" alt="Poster for <?php echo htmlspecialchars($name); ?>">
    </div>
    <div class="movie-details">
        <h1><?php echo htmlspecialchars($name); ?></h1>
        <p class="tagline"><?php echo htmlspecialchars($tagline); ?></p>
        <p><?php echo htmlspecialchars($overview); ?></p>
    </div>
</div>

<!-- Rating Form -->
<div class="rating-form">
    <form method="post">
        <input type="number" step="0.1" max="5" min="0" name="movie_rating" placeholder="Rate (0-5)" required>
        <button type="submit">Rate This Movie</button>
    </form>
</div>

<!-- Watchlist Button -->
<form method="post">
    <input type="hidden" name="add_to_watchlist" value="1">
    <button class="back-button" type="submit">Add to Watchlist</button>
</form>

<!-- Comments Section -->
<div class="comments-section">
    <h3>Comments</h3>
    <?php if (!empty($comments_data)): ?>
        <?php foreach ($comments_data as $comment): ?>
            <div class="comment-card">
                <span><?php echo htmlspecialchars($comment['username']); ?></span>
                <span class="comment-time"><?php echo htmlspecialchars($comment['created_at']); ?></span>
                <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No comments available for this movie.</p>
    <?php endif; ?>
</div>

<!-- Comment Form -->
<form method="post">
    <textarea name="comment" placeholder="Write your comment here..." required></textarea>
    <button class="submit-comment" type="submit">Submit Comment</button>
</form>

<!-- Back button to return to the search page -->
<form action="Search.php" method="get">
    <button class="back-button" type="submit">Back to Search</button>
</form>

</body>
</html>

