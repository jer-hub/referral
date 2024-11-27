<?php
session_start();
require_once "database.php"; // Ensure this file contains the connection setup

// Initialize variables
$facilitator_firstname = '';
$facilitator_lastname = '';
$schedule = '';
$resultid = '';
$error = '';
$success = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Check if the user ID exists in the users table
        $checkUserQuery = "SELECT id FROM users WHERE id = ?";
        $checkUserStmt = $conn->prepare($checkUserQuery);
        $checkUserStmt->bind_param("i", $userId); // Bind the user ID as an integer
        $checkUserStmt->execute();
        $checkUserStmt->store_result(); // Store the result to check if any rows were returned

        if ($checkUserStmt->num_rows > 0) {
            // User ID exists, proceed with booking insertion
            // Get form data
            $facilitator_firstname = trim($_POST['facilitator_firstname']);
            $facilitator_lastname = trim($_POST['facilitator_lastname']);
            $schedule = trim($_POST['schedule']);
            $resultid = trim($_POST['resultid']);

            // Validate input
            if (empty($facilitator_firstname) || empty($facilitator_lastname) || empty($schedule) || empty($resultid)) {
                $error = "All fields are required.";
            } else {
                // Prepare and execute the insert query
                $query = "INSERT INTO bookings (user_id, facilitator_firstname, facilitator_lastname, schedule, resultid) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("issss", $userId, $facilitator_firstname, $facilitator_lastname, $schedule, $resultid); // Bind parameters
                if ($stmt->execute()) {
                    $success = "Booking session created successfully!";
                    // Clear the form fields
                    $facilitator_firstname = '';
                    $facilitator_lastname = '';
                    $schedule = '';
                    $resultid = '';
                } else {
                    $error = "Error creating booking session.";
                }
            }
        } else {
            $error = "User ID does not exist.";
        }
    } else {
        $error = "You must be logged in to create a booking session.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking Session</title>
    <link rel="stylesheet" type="text/css" href="css/booking.css">
    <style>
        .booking-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
        }

        .booking-form h1 {
            text-align: center;
            color: #333;
        }

        .booking-form label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .booking-form input[type="text"],
        .booking-form input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .booking-form button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .booking-form button:hover {
            background-color: #4cae4c;
        }

        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: green;
            text-align: center;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
     <!-- Navigation Bar -->
     <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Booking Session Form -->
    <div class="booking-form">
        <h1>Create Booking Session</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="facilitator_firstname">Facilitator First Name:</label>
            <input type="text" id="facilitator_firstname" name="facilitator_firstname" value="<?php echo htmlspecialchars($facilitator_firstname); ?>" required>

            <label for="facilitator_lastname">Facilitator Last Name:</label>
            <input type="text" id="facilitator_lastname" name="facilitator_lastname" value="<?php echo htmlspecialchars($facilitator_lastname); ?>" required>

            <label for="schedule">Scheduled Date and Time:</label>
            <input type="datetime-local" id="schedule" name="schedule" value="<?php echo htmlspecialchars($schedule); ?>" required>

            <label for="resultid">Result ID:</label>
            <input type="text" id="resultid" name="resultid" value="<?php echo htmlspecialchars($resultid); ?>" required>

            <button type="submit">Create Booking Session</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Referral System. All rights reserved.</p>
    </footer>
</body>
</html>