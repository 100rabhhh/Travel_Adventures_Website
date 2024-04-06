<?php
// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traveldb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch price based on selected destination
$destination = $_POST['destination'];

// Prepare and execute the SQL query
$sql = "SELECT amount FROM destinations WHERE destination = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $destination);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Output data of the first row (assuming destination names are unique)
    $row = $result->fetch_assoc();
    $amount = $row["amount"];

    // Send amount back to the client-side JavaScript
    echo '₹' . $amount;
} else {
    echo "0.00"; // If destination not found, return default price
}

$stmt->close();
$conn->close();
?>
