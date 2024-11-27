<?php
session_start();
require_once "database.php"; // Ensure this file contains the connection setup

// Fetch booking sessions from the database
$booking_sessions = []; // Initialize the variable
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // Updated query to fetch booking sessions with user information
    $query = "
    SELECT b.*, ui.firstname AS user_firstname, ui.lastname AS user_lastname 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN user_information ui ON u.username = ui.username 
    WHERE b.user_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId); // Bind the user ID as an integer
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set from the prepared statement

    // Fetch all booking sessions
    while ($row = $result->fetch_assoc()) {
        $booking_sessions[] = $row; // Add each row to the booking_sessions array
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Sessions Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/booking.css">
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

    <!-- Booking Sessions Dashboard -->
    <div class="dashboard-wrapper">
        <h1>Booking Sessions Dashboard</h1>
        <?php if (!empty($booking_sessions)): ?>
            <div class="session-container">
                <?php foreach ($booking_sessions as $session): ?>
                    <div class="session">
                        <p><strong>Facilitator:</strong> <?php echo htmlspecialchars($session['facilitator_firstname']) . ' ' . htmlspecialchars($session['facilitator_lastname']); ?></p>
                        <p><strong>Scheduled Date:</strong> <?php echo htmlspecialchars($session['schedule']); ?></p>
                        <p><strong>Result ID:</strong> <?php echo htmlspecialchars($session['resultid']); ?></p>
                        <p><strong>User:</strong> <?php echo htmlspecialchars($session['user_firstname']) . ' ' . htmlspecialchars($session['user_lastname']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No booking sessions found.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Referral System. All rights reserved.</p>
    </footer>

</body>
</html>
