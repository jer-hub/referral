<?php
session_start();
require_once "database.php"; // Ensure this file contains the connection setup

// Fetch booking sessions from the database
$booking_sessions = [];
$upcoming_sessions = [];
$user_remarks = [];
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Updated query to fetch booking sessions with user information
    $query = "
    SELECT b.*, u.first_name AS user_firstname, u.last_name AS user_lastname, 
           f.first_name AS facilitator_firstname, f.last_name AS facilitator_lastname
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN users f ON b.facilitator_id = f.id 
    WHERE b.user_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId); // Bind the user ID as an integer
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set from the prepared statement

    // Fetch all booking sessions
    while ($row = $result->fetch_assoc()) {
        $booking_sessions[] = $row; // Add each row to the booking_sessions array
    }

    // Query to fetch upcoming booking sessions
    $upcoming_query = "
    SELECT b.*, u.first_name AS user_firstname, u.last_name AS user_lastname, 
           f.first_name AS facilitator_firstname, f.last_name AS facilitator_lastname
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN users f ON b.facilitator_id = f.id 
    WHERE b.user_id = ? AND b.schedule BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 DAY) AND b.status NOT IN ('finished', 'on process')";

    $upcoming_stmt = $conn->prepare($upcoming_query);
    $upcoming_stmt->bind_param("i", $userId); // Bind the user ID as an integer
    $upcoming_stmt->execute();
    $upcoming_result = $upcoming_stmt->get_result(); // Get the result set from the prepared statement

    // Fetch all upcoming booking sessions
    while ($row = $upcoming_result->fetch_assoc()) {
        $upcoming_sessions[] = $row; // Add each row to the upcoming_sessions array
    }

    // Query to fetch user remarks related to referrals made by the user
    $remarks_query = "
    SELECT ur.*, r.concerns, r.concern_details, r.recommendations AS referral_recommendations, r.actions_taken AS referral_actions_taken, ur.follow_up, ur.actions
    FROM user_remarks ur
    JOIN referrals r ON ur.referral_id = r.id
    WHERE r.user_id = ?";

    $remarks_stmt = $conn->prepare($remarks_query);
    $remarks_stmt->bind_param("i", $userId); // Bind the user ID as an integer
    $remarks_stmt->execute();
    $remarks_result = $remarks_stmt->get_result(); // Get the result set from the prepared statement

    // Fetch all user remarks
    while ($row = $remarks_result->fetch_assoc()) {
        $user_remarks[] = $row; // Add each row to the user_remarks array
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Sessions Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="static/styles.css">
</head>

<body>
    <?php include("_partials/_navbar.php"); ?>

    <!-- Booking Sessions Dashboard -->
    <section class="section">
        <div class="container">
            <h1 class="title">Booking Sessions Dashboard</h1>
            <?php if (!empty($booking_sessions)): ?>
                <div class="columns is-multiline">
                    <?php foreach ($booking_sessions as $session): ?>
                        <div class="column is-one-third">
                            <div class="box">
                                <p><strong>Facilitator:</strong>
                                    <?php echo htmlspecialchars($session['facilitator_firstname']) . ' ' . htmlspecialchars($session['facilitator_lastname']); ?>
                                </p>
                                <p><strong>Scheduled Date:</strong> <?php echo htmlspecialchars($session['schedule']); ?></p>
                                <p><strong>Result ID:</strong> <?php echo htmlspecialchars($session['result_id']); ?></p>
                                <p><strong>User:</strong>
                                    <?php echo htmlspecialchars($session['user_firstname']) . ' ' . htmlspecialchars($session['user_lastname']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No booking sessions found.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Upcoming Booking Sessions -->
    <section class="section">
        <div class="container">
            <h1 class="title">Upcoming Booking Sessions</h1>
            <?php if (!empty($upcoming_sessions)): ?>
                <div class="columns is-multiline">
                    <?php foreach ($upcoming_sessions as $session): ?>
                        <div class="column is-one-third">
                            <div class="box">
                                <p><strong>Facilitator:</strong>
                                    <?php echo htmlspecialchars($session['facilitator_firstname']) . ' ' . htmlspecialchars($session['facilitator_lastname']); ?>
                                </p>
                                <p><strong>Scheduled Date:</strong> <?php echo htmlspecialchars($session['schedule']); ?></p>
                                <p><strong>Result ID:</strong> <?php echo htmlspecialchars($session['result_id']); ?></p>
                                <p><strong>User:</strong>
                                    <?php echo htmlspecialchars($session['user_firstname']) . ' ' . htmlspecialchars($session['user_lastname']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No upcoming booking sessions found.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- User Remarks -->
    <section class="section">
        <div class="container">
            <h1 class="title">Remarks from referral</h1>
            <?php if (!empty($user_remarks)): ?>
                <div class="columns is-multiline">
                    <?php foreach ($user_remarks as $remark): ?>
                        <div class="column is-one-third">
                            <div class="box">
                                <p><strong>Concern:</strong> <?php echo htmlspecialchars($remark['concerns']); ?></p>
                                <p><strong>Concern Details:</strong> <?php echo htmlspecialchars($remark['concern_details']); ?></p>
                                <p><strong>Referral Recommendations:</strong> <?php echo htmlspecialchars($remark['referral_recommendations']); ?></p>
                                <p><strong>Referral Actions Taken:</strong> <?php echo htmlspecialchars($remark['referral_actions_taken']); ?></p>
                                <p><strong>Remarks:</strong> <?php echo htmlspecialchars($remark['remarks']); ?></p>
                                <p><strong>Recommendations:</strong> <?php echo htmlspecialchars($remark['recommendations']); ?></p>
                                <p><strong>Follow-up:</strong> <?php echo htmlspecialchars($remark['follow_up']); ?></p>
                                <p><strong>Created At:</strong> <?php echo htmlspecialchars($remark['created_at']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No remarks found.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <div style="position:fixed; bottom:0; width: 100%">
        <?php include("_partials/_footer.php"); ?>
    </div>
</body>

</html>