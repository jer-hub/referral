<?php
session_start(); // Start the session
include 'database.php'; // Include database connection

$feedback = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $gender = trim($_POST['gender']);
    $contact = trim($_POST['contact']);
    $department = trim($_POST['department']);
    $designation = trim($_POST['designation']);

    // Check for empty fields
    if (empty($email) || empty($username) || empty($password) || empty($confirm_password) ||
        empty($firstname) || empty($lastname) || empty($gender) || empty($contact) || 
        empty($department) || empty($designation)) {
        $feedback = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedback = "Invalid email format!";
    } elseif ($password !== $confirm_password) {
        $feedback = "Passwords do not match!";
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $feedback = "Username or email already exists!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Begin transaction
            $conn->begin_transaction();

            try {
                // Insert into `users` table
                $stmt = $conn->prepare("INSERT INTO users (email, username, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param('sssss', $email, $username, $hashed_password, $firstname, $lastname);
                $stmt->execute();
                $user_id = $stmt->insert_id; // Get the inserted user ID
                $stmt->close();

                // Insert into `user_information` table
                $stmt = $conn->prepare("INSERT INTO user_information (user_id, gender, contact, department, designation) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param('issss', $user_id, $gender, $contact, $department, $designation);
                $stmt->execute();
                $stmt->close();

                // Commit transaction
                $conn->commit();

                // Set success feedback
                $_SESSION['feedback'] = "Registration successful! You can now log in.";
                header("Location: login.php");
                exit();
            } catch (Exception $e) {
                // Rollback on error
                $conn->rollback();
                echo $e->getMessage();
                $feedback = "An error occurred during registration. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral System - Register</title>
    <link rel="stylesheet" type="text/css" href="css/regstyles.css">
    <link rel="stylesheet" type="text/css" href="css/notification.css">
</head>
<body>
    <div>
        <img src="dcnhs.png" alt="">
    </div>
    <div class="container">
    <!-- Feedback Section -->
        <header>
            <h1>Register</h1>
        </header>
        <form method="post" action="">
        <div id="feedback-container" class="notification">
            <?php if (!empty($feedback)) echo htmlspecialchars($feedback); ?>
        </div>
            <label for="designation">Role:</label>
            <select id="designation" name="designation" required>
                <option value="student">STUDENT</option>
                <option value="faculty">FACULTY</option>
            </select>

            <label for="department">Department:</label>
            <select id="department" name="department" required>
                <option value="IBED">IBED</option>
                <option value="College">COLLEGE</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" required>

            <div class="button-container">
                <input type="submit" value="Register" name="register" class="register"/>
                <a href="login.php" class="login-link">Already have an account? Login</a>
            </div>
        </form>
    </div>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Referral System. All rights reserved.</p>
    </footer>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var feedbackContainer = document.getElementById("feedback-container");
        if (feedbackContainer.innerHTML.trim() !== "") {
            feedbackContainer.style.display = "block"; // Show feedback if not empty
        }
    });
</script>

</body>
</html>
