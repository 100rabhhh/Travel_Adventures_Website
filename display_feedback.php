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

// Select feedback data from the "feedback" table
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);

// Check if there are any feedback records
if ($result->num_rows > 0) {
    // Output feedback data in a table
    echo "<table border='1'>";
    echo "<tr><th>Question 1</th><th>Question 2</th><th>Question 3</th><th>Question 4</th><th>Suggestion</th></tr>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["question1"] . "</td>";
        echo "<td>" . $row["question2"] . "</td>";
        echo "<td>" . $row["question3"] . "</td>";
        echo "<td>" . $row["question4"] . "</td>";
        echo "<td>" . $row["suggestion"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No feedback yet.";
}
$conn->close();
?>