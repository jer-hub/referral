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
    <title>Referral System</title>
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
                <!-- Referrals -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["referral_id"]) && isset($_POST["status"])) {
                    $referral_id = $_POST["referral_id"];
                    $status = $_POST["status"];

                    $conn = new mysqli("localhost", "root", "", "referral");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "UPDATE referrals SET status = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $status, $referral_id);

                    if ($stmt->execute()) {
                        echo "<div class='notification is-info is-light'>Referral status updated successfully.</div>";
                    } else {
                        echo "Error updating referral status: " . $conn->error;
                    }

                    $stmt->close();
                    $conn->close();
                }

                $conn = new mysqli("localhost", "root", "", "referral");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT r.id, u.first_name, u.last_name, r.concerns, r.status, r.created_at 
                        FROM referrals r 
                        JOIN users u ON r.user_id = u.id 
                        ORDER BY r.created_at DESC";
                $result = $conn->query($sql);

                echo "<table class='table is-fullwidth'>";
                echo "<thead><tr><th>Referral ID</th><th>First Name</th><th>Last Name</th><th>Concerns</th><th>Status</th><th>Created At</th><th>Actions</th></tr></thead>";
                echo "<tbody>";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "<td>" . $row["concerns"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo "<td>
                                <form method='POST' class='is-flex is-align-items-center is-gap-2'>
                                    <input type='hidden' name='referral_id' value='" . $row["id"] . "'>
                                    <select name='status' class='control'>
                                        <option value='pending'" . ($row["status"] == "pending" ? " selected" : "") . ">Pending</option>
                                        <option value='approved'" . ($row["status"] == "approved" ? " selected" : "") . ">Approved</option>
                                        <option value='rejected'" . ($row["status"] == "rejected" ? " selected" : "") . ">Rejected</option>
                                    </select>
                                    <button class='button is-small' type='submit'>Update</button>
                                    <a href='view_referral.php?id=" . $row["id"] . "' class='button is-link is-light is-small'>View</a>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No referrals found.</td></tr>";
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