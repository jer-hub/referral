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
    <title>View Referral</title>
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
                <div class="is-flex is-justify-content-space-between">
                    <div>
                        <h1 class="title">Referral Details</h1>
                    </div>
                    <div>
                        <?php
                        if (isset($_GET["id"])) {
                            $referral_id = $_GET["id"];
                            echo '<a href="issue_certificate.php?id=' . $referral_id . '" class="button is-secondary">Give Remarks</a>';
                        } else {
                            echo '<button class="button is-secondary" disabled>Give Remarks</button>';
                        }
                        ?>
                    </div>
                </div>
                <!-- View Referral -->
                <?php
                if (isset($_GET["id"])) {
                    $referral_id = $_GET["id"];

                    $conn = new mysqli("localhost", "root", "", "referral");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT r.*, u.username, u.first_name, u.last_name 
                            FROM referrals r 
                            JOIN users u ON r.user_id = u.id 
                            WHERE r.id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $referral_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<p><strong>Referral ID:</strong> " . $row["id"] . "</p>";
                        echo "<p><strong>User:</strong> " . $row["username"] . "</p>";
                        echo "<p><strong>First Name:</strong> " . $row["first_name"] . "</p>";
                        echo "<p><strong>Last Name:</strong> " . $row["last_name"] . "</p>";
                        echo "<p><strong>Concerns:</strong> " . $row["concerns"] . "</p>";
                        echo "<p><strong>Concern Details:</strong> " . $row["concern_details"] . "</p>";
                        echo "<p><strong>Actions Taken:</strong> " . $row["actions_taken"] . "</p>";
                        echo "<p><strong>Recommendations:</strong> " . $row["recommendations"] . "</p>";
                        echo "<p><strong>Status:</strong> " . $row["status"] . "</p>";
                        echo "<p><strong>Created At:</strong> " . $row["created_at"] . "</p>";
                    } else {
                        echo "Referral not found.";
                    }

                    $stmt->close();
                    $conn->close();
                } else {
                    echo "No referral ID provided.";
                }
                ?>
            </div>
        </div>
    </main>

    <?php include("../_partials/_footer.php"); ?>
</body>

</html>