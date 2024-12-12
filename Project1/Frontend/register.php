<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone']; // Capture the phone number input

    if (strlen($phone) != 10) {
        echo "<h1>Error: Phone number must be exactly 10-digits.</h1>";
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

    // Prepare the registration request
    $request = array();
    $request['type'] = "register";
    $request['username'] = $username;
    $request['password'] = $password;
    $request['userEmail'] = $email;
    $request['number'] = "+1" . $phone; // Include the phone number in the request
    $request['rating_table'] = $username . "_rating";
    $request['watchlist_table'] = $username . "_watchlist";

    // Send the registration request and receive a response
    $response = $client->send_request($request);

    if ($response === true) {
        header("Location: login.html");
        exit();
    } else if ($response === false) {
        echo "<h1>Registration failed. USER ALREADY REGISTERED.</h1>";
    } else {
        echo "An unexpected error occurred: " . print_r($response, true) . PHP_EOL;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            z-index: 1;
        }
        
        /* Content styling */
        .content {
            position: relative;
            z-index: 2;
            color: white;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: white;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input[type="text"], input[type="password"], input[type="email"], input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #218838;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }

            input[type="text"], input[type="password"], input[type="email"], input[type="number"] {
                font-size: 0.9rem;
            }

            button {
                font-size: 0.9rem;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2rem;
            }

            input[type="text"], input[type="password"], input[type="email"], input[type="number"] {
                font-size: 0.8rem;
                padding: 10px;
            }

            button {
                font-size: 0.8rem;
                padding: 8px;
            }
        }
    </style>
    <script>
        function validatePhone(input) {
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10); // Restrict to 10 digits
            }
        }
    </script>
</head>
<body>

<div class="content">
    <h1>Create a MoviCritics Account</h1>
    <form method="post" action="register.php">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <input type="number" name="phone" placeholder="Enter 10-Digit Phone Number" required 
               oninput="validatePhone(this)" min="1000000000" max="9999999999">
        
        <button type="submit">Register</button>
    </form>
    <br>
    <!-- Login button -->
    <button onclick="window.location.href='login.html';">Login</button>
</div>

</body>
</html>

