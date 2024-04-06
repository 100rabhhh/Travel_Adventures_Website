<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "traveldb"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Admin credentials
    $adminUsername = "admin";
    $adminPassword = "admin123";

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if entered credentials match admin credentials
    if ($username === $adminUsername && $password === $adminPassword) {
        // Admin login successful, redirect to admin page
        header("Location: admin.html");
        exit;
    } else {
        // Admin login failed, redirect to admin registration page
        header("Location: admin_registration.html");
        exit;
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Travel Adventures</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        section {
            padding: 20px;
            background-color: #ddd;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Styling for the registration form */
        .registration-container {
            max-width: 400px;
            margin: 0 auto;
        }

        .registration-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .registration-form h2 {
            color: #333;
            text-align: center;
        }

        .registration-form label {
            display: block;
            margin: 10px 0;
            color: #333;
        }

        .registration-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .registration-form button {
            background-color: #FFC60B;
            color: #333;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .registration-form button:hover {
            background-color: #ddd;
        }

        .back-to-login {
            text-align: center;
            margin-top: 15px;
        }

        .back-to-login a {
            color: blue;
            text-decoration: none;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }

        .get-in-touch {
            position: fixed;
            bottom: 10px;
            left: 10px;
            background-color: #ff0000;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .get-in-touch:hover {
            transform: scale(1.1);
        }

        .get-in-touch a {
            margin-right: 10px;
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .get-in-touch i {
            font-size: 24px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Registration</h1>
    </header>

    <section class="registration-container">
        <div class="registration-form">
            <h2>Register as Admin</h2>
            <form action="register_admin.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Register</button>
            </form>
        </div>
    </section>

    <footer>
        &copy; 2024 Travel Adventures. All rights reserved.
    </footer>
</body>
</html>
