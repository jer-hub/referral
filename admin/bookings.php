<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management</title>
    <link rel="stylesheet" type="text/css" href="../static/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/homepagestyles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include("../_partials/_navbar_admin.php"); ?>
    <main class="container my-5">
        <div class="columns">
            <?php include("side_links.php"); ?>
            <div class="column m-1" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
                <!-- Bookings -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["booking_id"]) && isset($_POST["status"]) && isset($_POST["schedule"])) {
                    $booking_id = $_POST["booking_id"];
                    $status = $_POST["status"];
                    $schedule = $_POST["schedule"];

                    $conn = new mysqli("localhost", "root", "", "referral");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "UPDATE bookings SET status = ?, schedule = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssi", $status, $schedule, $booking_id);

                    if ($stmt->execute()) {
                        echo "<div class='notification is-info is-light'>Booking status and schedule updated successfully.</div>";
                    } else {
                        echo "Error updating booking status and schedule: " . $conn->error;
                    }

                    $stmt->close();
                    $conn->close();
                }

                $conn = new mysqli("localhost", "root", "", "referral");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT b.id, u.first_name, u.last_name, b.schedule, b.status, b.result_id 
                        FROM bookings b 
                        JOIN users u ON b.user_id = u.id 
                        ORDER BY b.schedule DESC";
                $result = $conn->query($sql);

                echo "<table class='table is-fullwidth'>";
                echo "<thead><tr><th>Booking ID</th><th>First Name</th><th>Last Name</th><th>Schedule</th><th>Status</th><th>Result ID</th><th>Actions</th></tr></thead>";
                echo "<tbody>";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "<td>" . $row["schedule"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["result_id"] . "</td>";
                        echo "<td>
                                <form method='POST' class='is-flex is-align-items-center is-gap-2'>
                                    <input type='hidden' name='booking_id' value='" . $row["id"] . "'>
                                    <input type='datetime-local' name='schedule' value='" . date('Y-m-d\TH:i', strtotime($row["schedule"])) . "' class='control'>
                                    <select name='status' class='control'>
                                        <option value='pending'" . ($row["status"] == "pending" ? " selected" : "") . ">Pending</option>
                                        <option value='on process'" . ($row["status"] == "on process" ? " selected" : "") . ">On Process</option>
                                        <option value='finished'" . ($row["status"] == "finished" ? " selected" : "") . ">Finished</option>
                                    </select>
                                    <button class='button is-small' type='submit'>Update</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No bookings found.</td></tr>";
                }
                echo "</tbody></table>";

                $conn->close();
                ?>
            </div>
        </div>
    </main>
    
    <?php include("../_partials/_footer.php"); ?>
</body>

</html>