<?php
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
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Insert data into database
    $sql = "INSERT INTO users_registration (username, password, name, age, gender, city, contact, email) 
            VALUES ('$username', '$password', '$name', '$age', '$gender', '$city', '$contact', '$email')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login.html
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close(); // Close the database connection
?>
