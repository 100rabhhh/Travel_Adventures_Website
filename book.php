<?php
// Start session
session_start();

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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $destination = $_POST['destination'];
    $departureDate = $_POST['departureDate'];
    $numTravelers = $_POST['numTravelers'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $amount = $_POST['amount'];

    // Insert booking data into the database
    $sql = "INSERT INTO bookings (full_name, email, phone, destination, departure_date, num_travelers, card_number, expiry_date, cvv, amount) VALUES ('$fullName', '$email', '$phone', '$destination', '$departureDate', $numTravelers, '$cardNumber', '$expiryDate', '$cvv', '$amount')";

    if ($conn->query($sql) === TRUE) {
        // Store booking data in session
        $_SESSION['booking'] = [
            'fullName' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'destination' => $destination,
            'departureDate' => $departureDate,
            'numTravelers' => $numTravelers,
            'amount' => $amount
        ];

        // Redirect to ticket page
        header("Location: ticket.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
