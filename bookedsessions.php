<?php
session_start();
require_once "database.php"; // Ensure this file contains the connection setup

// Initialize variables
$facilitator_id = '';
$schedule = '';
$resultid = '';
$error = '';
$success = '';

// Fetch facilitators (users who are admins)
$facilitatorsQuery = "SELECT id, first_name, last_name FROM users WHERE is_admin = TRUE";
$facilitatorsResult = $conn->query($facilitatorsQuery);
$facilitators = [];
if ($facilitatorsResult->num_rows > 0) {
    while ($row = $facilitatorsResult->fetch_assoc()) {
        $facilitators[] = $row;
    }
}

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
            $facilitator_id = trim($_POST['facilitator_id']);
            $schedule = trim($_POST['schedule']);
            $resultid = trim($_POST['resultid']);

            // Validate input
            if (empty($facilitator_id) || empty($schedule) || empty($resultid)) {
                $error = "All fields are required.";
            } else {
                // Check if the ticket ID already exists for the user
                $checkTicketQuery = "SELECT id FROM bookings WHERE user_id = ? AND result_id = ?";
                $checkTicketStmt = $conn->prepare($checkTicketQuery);
                $checkTicketStmt->bind_param("is", $userId, $resultid); // Bind parameters
                $checkTicketStmt->execute();
                $checkTicketStmt->store_result(); // Store the result to check if any rows were returned

                if ($checkTicketStmt->num_rows > 0) {
                    $error = "This ticket ID already exists in your bookings.";
                } else {
                    // Prepare and execute the insert query
                    $query = "INSERT INTO bookings (user_id, facilitator_id, schedule, result_id) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("iiss", $userId, $facilitator_id, $schedule, $resultid); // Bind parameters
                    if ($stmt->execute()) {
                        $success = "Booking session created successfully!";
                        // Clear the form fields
                        $facilitator_id = '';
                        $schedule = '';
                        $resultid = '';
                    } else {
                        $error = "Error creating booking session.";
                    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="static/styles.css">
</head>

<body>
    <?php include("_partials/_navbar.php"); ?>

    <!-- Booking Session Form -->
    <div class="container">
        <div class="box">
            <h1 class="title has-text-centered">Create Booking Session</h1>
            <?php if ($error): ?>
                <p class="notification is-danger"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="notification is-success"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <div class="field">
                    <label class="label" for="facilitator_id">Facilitator:</label>
                    <div class="control">
                        <div class="select">
                            <select id="facilitator_id" name="facilitator_id" required>
                                <option value="">Select Facilitator</option>
                                <?php foreach ($facilitators as $facilitator): ?>
                                    <option value="<?php echo $facilitator['id']; ?>" <?php echo ($facilitator_id == $facilitator['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($facilitator['first_name'] . ' ' . $facilitator['last_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="schedule">Scheduled Date and Time:</label>
                    <div class="control">
                        <input class="input" type="datetime-local" id="schedule" name="schedule"
                            value="<?php echo htmlspecialchars($schedule); ?>" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="resultid">Ticket ID:</label>
                    <div class="control">
                        <input class="input" type="text" id="resultid" name="resultid"
                            value="<?php echo htmlspecialchars($resultid); ?>" required>
                    </div>
                </div>

                <div class="field">
                    <div class="control is-flex is-justify-content-end">
                        <button class="button is-link is-light" type="submit">Create Booking Session</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div style="position:fixed; bottom:0; width: 100%">
        <?php include("_partials/_footer.php"); ?>
    </div>
</body>

</html>