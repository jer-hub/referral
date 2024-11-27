<?php
session_start();
require_once "database.php"; // Ensure this file contains the connection setup

$error = ""; // Initialize the error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Sanitize inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        $error = "Both username and password are required.";
    } else {
        // Prepare a SQL statement to fetch user data
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id();

                // Store session variables
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id']; // Store user ID in session

                // Redirect based on user type
                switch ($row['usertype']) {
                    case 'psychmeth':
                        $_SESSION['psychmeth'] = true;
                        header("Location: index.php");
                        exit();
                    case 'ghead':
                        $_SESSION['ghead'] = true;
                        header("Location: index.php");
                        exit();
                    default:
                        header("Location: index.php");
                        exit();
                }
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Username not found.";
        }

        $stmt->close();
    }
}

// Close the connection after all operations are done
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div>
        <img src="media\logo\dcnhs.png" alt="">
    </div>
    <div class="container">
        <header>
            <h1>Login</h1>
        </header>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <div class="button-container">
                <button type="submit" class="login" name="login">Login</button>
                <button type="button" class="register" onclick="window.location.href='register.php'">Register</button>
            </div>

            <!-- Display error message if login fails -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
