<?php
// Start session
session_start();

// Check if booking data exists in session
if (!isset($_SESSION['booking'])) {
    // Redirect to book.php if booking data is not found
    header("Location: book.php");
    exit;
}
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
// Check if action is delete and the feedback ID is provided
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['feedback_id'])) {
    // Sanitize the feedback ID to prevent SQL injection
    $feedbackId = $conn->real_escape_string($_POST['feedback_id']);
    // SQL query to delete feedback
    $sql = "DELETE FROM feedback WHERE id='$feedbackId'";
    if ($conn->query($sql) === TRUE) {
        echo "Feedback deleted successfully!";
        // No need to redirect after deletion
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Query to retrieve feedback data from the database
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="feedback.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #FFC60B;
        }
        .delete-button {
            background-color: red;
            color: white;
        }
    </style>
</head>
<header>
    <div class="header-buttons">
        <a href="#" onclick="loadMainPage()">MainPage</a>
    </div>
    <h1>Users Management</h1>
</header>
<nav>
    <a href="admin.html"><i class="fas fa-home"></i> Dashboard</a>
    <a href="users.php"><i class="fas fa-users"></i> Users</a>
    <a href="feedback.php"><i class="fas fa-comment"></i> Feedback</a>
    <a href="settings.html"><i class="fas fa-cog"></i> Settings</a>
    <a href="logout.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>
<body>
<div class="ticket-container">
    <div class="ticket">
        <h2>Travel Adventures Ticket</h2>
        <div class="ticket-info">
            <?php
            if (isset($_SESSION['booking'])) {
                $booking = $_SESSION['booking'];
                echo "<p><span>Full Name:</span> " . $booking['fullName'] . "</p>";
                echo "<p><span>Email:</span> " . $booking['email'] . "</p>";
                echo "<p><span>Phone:</span> " . $booking['phone'] . "</p>";
                echo "<p><span>Destination:</span> " . $booking['destination'] . "</p>";
                echo "<p><span>Departure Date:</span> " . $booking['departureDate'] . "</p>";
                echo "<p><span>Number of Travelers:</span> " . $booking['numTravelers'] . "</p>";
                echo "<p><span>Amount:</span> " . $booking['amount'] . "</p>";
            }
            ?>
        </div>
    </div>
</div>
<h1>Feedback Received</h1>
<table>
    <tr>
        <th style="background-color: yellow;">Booking Experience</th>
        <th style="background-color: yellow;">Satisfaction with Destination</th>
        <th style="background-color: yellow;">Service Rating</th>
        <th style="background-color: yellow;">Recommendation</th>
        <th style="background-color: yellow;">Suggestions</th>
        <th style="background-color: yellow;">Action</th>
    </tr>
    <?php
    // Check if there are rows in the result
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['question1'] . "</td>";
            echo "<td>" . $row['question2'] . "</td>";
            echo "<td>" . $row['question3'] . "</td>";
            echo "<td>" . $row['question4'] . "</td>";
            echo "<td>" . $row['suggestion'] . "</td>";
            echo "<td><form action='' method='post'><input type='hidden' name='feedback_id' value='" . $row['id'] . "'><input type='hidden' name='action' value='delete'><button type='submit' class='delete-button'>Delete</button></form></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No feedback received yet.</td></tr>";
    }
    ?>
</table>
    <script>
        function loadMainPage() {
            window.location.href = "MasterPage.html";
        }
    </script>
</body>
</html>
<?php
// Close MySQL connection
$conn->close();
?>
