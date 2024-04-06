<?php
// Start session
session_start();

// Check if booking data exists in session
if (isset($_SESSION['booking'])) {
    // Get booking data from session
    $booking = $_SESSION['booking'];
} else {
    // Redirect to book.php if booking data is not found
    header("Location: book.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get feedback data from the form
    $question1 = $_POST['question1'];
    $question2 = $_POST['question2'];
    $question3 = $_POST['question3'];
    $question4 = $_POST['question4'];
    $suggestion = $_POST['suggestion'];

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

    // Insert feedback data into the database
    $sql = "INSERT INTO feedback (question1, question2, question3, question4, suggestion) 
            VALUES ('$question1', '$question2', '$question3', '$question4', '$suggestion')";

    if ($conn->query($sql) === TRUE) {
        echo "Feedback submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Adventures - Ticket</title>
    <link rel="stylesheet" href="ticket.css">
    <style>
        /* Feedback form styling */
        .feedback-form {
            display: none; /* Initially hide the feedback form */
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 300px;
            max-width: 90%;
            margin-top: 20px;
            transition: opacity 0.5s ease;
        }

        .feedback-form.show {
            display: block;
        }

        .feedback-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .question {
            margin-bottom: 15px;
        }

        .question label {
            display: block;
            margin-bottom: 5px;
        }

        .question select,
        .suggestion textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .suggestion textarea {
            height: 100px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="ticket">
            <h2>Travel Adventures Ticket</h2>
            <div class="ticket-info">
                <p><span>Full Name:</span> <?php echo $booking['fullName']; ?></p>
                <p><span>Email:</span> <?php echo $booking['email']; ?></p>
                <p><span>Phone:</span> <?php echo $booking['phone']; ?></p>
                <p><span>Destination:</span> <?php echo $booking['destination']; ?></p>
                <p><span>Departure Date:</span> <?php echo $booking['departureDate']; ?></p>
                <p><span>Number of Travelers:</span> <?php echo $booking['numTravelers']; ?></p>
                <p><span>Amount:</span> <?php echo $booking['amount']; ?></p>
            </div>
        </div>
        
        <!-- Feedback form -->
        <div class="feedback-form" id="feedbackForm">
            <h2>Feedback Form</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="question">
                    <label for="question1">How was the booking experience?</label>
                    <select id="question1" name="question1">
                        <option value="poor">Poor</option>
                        <option value="good">Good</option>
                        <option value="excellent">Excellent</option>
                    </select>
                </div>
                <div class="question">
                    <label for="question2">How satisfied were you with the destination?</label>
                    <select id="question2" name="question2">
                        <option value="poor">Poor</option>
                        <option value="good">Good</option>
                        <option value="excellent">Excellent</option>
                    </select>
                </div>
                <div class="question">
                    <label for="question3">How would you rate our service?</label>
                    <select id="question3" name="question3">
                        <option value="poor">Poor</option>
                        <option value="good">Good</option>
                        <option value="excellent">Excellent</option>
                    </select>
                </div>
                <div class="question">
                    <label for="question4">Would you recommend us to others?</label>
                    <select id="question4" name="question4">
                        <option value="no">No</option>
                        <option value="maybe">Maybe</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <div class="suggestion">
                    <label for="suggestion">Any suggestions for improvement?</label>
                    <textarea id="suggestion" name="suggestion" rows="4" cols="50"></textarea>
                </div>
                <button type="submit" class="submit-btn">Submit Feedback</button>
            </form>
        </div>
    </div>

    <script>
        // Function to show feedback form after a delay
        function showFeedbackForm() {
            document.getElementById("feedbackForm").classList.add("show");
        }

        // Show feedback form after 3 seconds
        setTimeout(showFeedbackForm, 3000);
    </script>
</body>
</html>
