<?php
// Include the database connection file
include 'db_connection.php';

// Function to sanitize user input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Perform CRUD operations based on the action parameter
if(isset($_POST['action'])) {
    $action = $_POST['action'];

    // Add new user
    if($action == 'add') {
        $newUsername = sanitizeInput($_POST['newUsername']);
        $newPassword = sanitizeInput($_POST['newPassword']);
        $name = sanitizeInput($_POST['name']);
        $age = sanitizeInput($_POST['age']);
        $gender = sanitizeInput($_POST['gender']);
        $city = sanitizeInput($_POST['city']);
        $contact = sanitizeInput($_POST['contact']);
        $email = sanitizeInput($_POST['email']);

        // SQL query to insert new user
        $sql = "INSERT INTO users_registration (username, password, name, age, gender, city, contact, email) 
                VALUES ('$newUsername', '$newPassword', '$name', '$age', '$gender', '$city', '$contact', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "User added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Delete user
    elseif($action == 'delete') {
        $userId = $_POST['userId'];

        // SQL query to delete user
        $sql = "DELETE FROM users_registration WHERE id='$userId'";

        if ($conn->query($sql) === TRUE) {
            echo "User deleted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        exit; // Terminate further execution after deletion
    }
    // Edit user
    elseif($action == 'edit') {
        $userId = $_POST['userId'];
        $newUsername = sanitizeInput($_POST['newUsername']);
        $newPassword = sanitizeInput($_POST['newPassword']);
        $name = sanitizeInput($_POST['name']);
        $age = sanitizeInput($_POST['age']);
        $gender = sanitizeInput($_POST['gender']);
        $city = sanitizeInput($_POST['city']);
        $contact = sanitizeInput($_POST['contact']);
        $email = sanitizeInput($_POST['email']);

        // SQL query to update user data
        $sql = "UPDATE users_registration SET 
                username='$newUsername', 
                password='$newPassword', 
                name='$name', 
                age='$age', 
                gender='$gender', 
                city='$city', 
                contact='$contact', 
                email='$email' 
                WHERE id='$userId'";

        if ($conn->query($sql) === TRUE) {
            echo "User updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        exit; // Terminate further execution after editing
    }
}

// Select all users from the database
$sql = "SELECT * FROM users_registration";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Admin Dashboard</title>
    <link rel="stylesheet" href="users.css">
</head>
<body>
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
    
    <section class="dashboard-container">
        <h2>Users Information</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>City</th>
                    <th>Contact</th>
                    <th>Email ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr id="userRow_' . $row['id'] . '">';
                        echo '<td>' . $row['username'] . '</td>';
                        echo '<td>' . $row['password'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['age'] . '</td>';
                        echo '<td>' . $row['gender'] . '</td>';
                        echo '<td>' . $row['city'] . '</td>';
                        echo '<td>' . $row['contact'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        // Add delete and edit buttons with onclick events
                        echo '<td><button class="delete-button" onclick="deleteUser(' . $row['id'] . ')">Delete</button>';
                        echo ' <button class="edit-button" onclick="editUser(' . $row['id'] . ')">Edit</button></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="9">No users found</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <div class="add-user">
            <button onclick="showAddUserForm()">Add User</button>
            <div class="user-form hidden" id="addUserForm">
                <h3>Add New User</h3>
                <form id="userForm" onsubmit="return addUser()">
                    <input type="text" name="newUsername" placeholder="Username" required>
                    <input type="password" name="newPassword" placeholder="Password" required>
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="text" name="age" placeholder="Age" required>
                    <select name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <input type="text" name="city" placeholder="City" required>
                    <input type="text" name="contact" placeholder="Contact" required>
                    <input type="email" name="email" placeholder="Email ID" required>
                    <button type="submit">Save</button>
                    <button type="button" onclick="hideAddUserForm()">Cancel</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        &copy; 2024 Travel Adventures. All rights reserved.
    </footer>

    <script>
        function loadMainPage() {
            window.location.href = "MasterPage.html";
        }

        function showAddUserForm() {
            document.getElementById("addUserForm").classList.remove("hidden");
        }

        function hideAddUserForm() {
            document.getElementById("addUserForm").classList.add("hidden");
        }

        function deleteUser(userId) {
            if(confirm("Are you sure you want to delete this user?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "users.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText);
                        if (xhr.responseText.includes("successfully")) {
                            // Remove the deleted row from the table
                            var row = document.getElementById("userRow_" + userId);
                            row.parentNode.removeChild(row);
                        }
                    }
                };
                var data = "action=delete&userId=" + userId;
                xhr.send(data);
            }
        }

        function editUser(userId) {
            // You can implement the edit functionality here, like opening a modal or redirecting to an edit page
            alert("Edit user clicked for user ID: " + userId);
        }

        function addUser() {
            var form = document.getElementById("userForm");
            var formData = new FormData(form);
            formData.append("action", "add");

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "users.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    if (xhr.responseText.includes("successfully")) {
                        window.location.reload(); // Refresh the page after adding user
                    }
                }
            };
            xhr.send(formData);

            return false; // Prevent form submission
        }
    </script>
</body>
</html>
