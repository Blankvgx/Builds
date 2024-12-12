<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin-top: 100px;
        }
        h1 {
            color: red;
        }
        p {
            color: gray;
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

<h1>Error Connecting to RabbitMQ</h1>
<p>We are unable to connect to the RabbitMQ server at this time. Please try again later.</p>

<!-- Back to Login Button -->
<button class="back-button" onclick="window.location.href='login.html';">Back to Login</button>

</body>
</html>
