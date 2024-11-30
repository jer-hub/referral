<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["referral_id"])) {
    $referral_id = $_POST["referral_id"];
    $action_taken_1 = $_POST["action_taken_1"];
    $date_1 = $_POST["date_1"];
    $remarks_1 = $_POST["remarks_1"];
    $action_taken_2 = $_POST["action_taken_2"];
    $date_2 = $_POST["date_2"];
    $remarks_2 = $_POST["remarks_2"];
    $action_taken_3 = $_POST["action_taken_3"];
    $date_3 = $_POST["date_3"];
    $remarks_3 = $_POST["remarks_3"];
    $recommendations = $_POST["recommendations"];
    $follow_up = $_POST["follow_up"];

    $conn = new mysqli("localhost", "root", "", "referral");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the referral exists
    $check_sql = "SELECT * FROM referrals WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $referral_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Referral exists, check if user_remarks already exists
        $remarks_check_sql = "SELECT * FROM user_remarks WHERE referral_id = ?";
        $remarks_check_stmt = $conn->prepare($remarks_check_sql);
        $remarks_check_stmt->bind_param("i", $referral_id);
        $remarks_check_stmt->execute();
        $remarks_check_result = $remarks_check_stmt->get_result();

        $actions_taken = "$action_taken_1 ($date_1): $remarks_1, $action_taken_2 ($date_2): $remarks_2, $action_taken_3 ($date_3): $remarks_3";

        if ($remarks_check_result->num_rows > 0) {
            // user_remarks exists, update it
            $update_remarks_sql = "UPDATE user_remarks SET remarks = ?, recommendations = ?, follow_up = ?, actions = ? WHERE referral_id = ?";
            $update_remarks_stmt = $conn->prepare($update_remarks_sql);
            $update_remarks_stmt->bind_param("ssssi", $actions_taken, $recommendations, $follow_up, $actions_taken, $referral_id);

            if ($update_remarks_stmt->execute()) {
                $success_message = "Updated successfully.";
                // Update referral status to approved
                $update_referral_sql = "UPDATE referrals SET status = 'approved' WHERE id = ?";
                $update_referral_stmt = $conn->prepare($update_referral_sql);
                $update_referral_stmt->bind_param("i", $referral_id);
                $update_referral_stmt->execute();
                $update_referral_stmt->close();
            } else {
                $error_message = "Error updating remarks: " . $conn->error;
            }

            $update_remarks_stmt->close();
        } else {
            // user_remarks does not exist, create a new entry
            $insert_remarks_sql = "INSERT INTO user_remarks (user_id, referral_id, remarks, recommendations, follow_up, actions) VALUES (?, ?, ?, ?, ?, ?)";
            $insert_remarks_stmt = $conn->prepare($insert_remarks_sql);
            $insert_remarks_stmt->bind_param("iissss", $_SESSION['user_id'], $referral_id, $actions_taken, $recommendations, $follow_up, $actions_taken);

            if ($insert_remarks_stmt->execute()) {
                $success_message = "Remarks created successfully.";
                // Update referral status to approved
                $update_referral_sql = "UPDATE referrals SET status = 'approved' WHERE id = ?";
                $update_referral_stmt = $conn->prepare($update_referral_sql);
                $update_referral_stmt->bind_param("i", $referral_id);
                $update_referral_stmt->execute();
                $update_referral_stmt->close();
            } else {
                $error_message = "Error creating remarks: " . $conn->error;
            }

            $insert_remarks_stmt->close();
        }

        $remarks_check_stmt->close();
    } else {
        $error_message = "Referral not found.";
    }

    $check_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Certificate</title>
    <link rel="stylesheet" type="text/css" href="../static/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/homepagestyles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include("../_partials/_navbar_admin.php"); ?>
    <main class="container my-5">
        <h1 class="title">Issue Remarks</h1>
        <?php if (isset($success_message)): ?>
            <div class="notification is-success">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="notification is-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <div class="m-1" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
            <form method="POST">
                <input type="hidden" name="referral_id" value="<?php echo $_GET['id']; ?>">
                <div class="field">
                    <label class="label">Action Taken 1</label>
                    <div class="control">
                        <input class="input" type="text" name="action_taken_1">
                    </div>
                    <label class="label">Date</label>
                    <div class="control">
                        <input class="input" type="date" name="date_1">
                    </div>
                    <label class="label">Remarks</label>
                    <div class="control">
                        <input class="input" type="text" name="remarks_1">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Action Taken 2</label>
                    <div class="control">
                        <input class="input" type="text" name="action_taken_2">
                    </div>
                    <label class="label">Date</label>
                    <div class="control">
                        <input class="input" type="date" name="date_2">
                    </div>
                    <label class="label">Remarks</label>
                    <div class="control">
                        <input class="input" type="text" name="remarks_2">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Action Taken 3</label>
                    <div class="control">
                        <input class="input" type="text" name="action_taken_3">
                    </div>
                    <label class="label">Date</label>
                    <div class="control">
                        <input class="input" type="date" name="date_3">
                    </div>
                    <label class="label">Remarks</label>
                    <div class="control">
                        <input class="input" type="text" name="remarks_3">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Recommendations</label>
                    <div class="control">
                        <textarea class="textarea" name="recommendations"></textarea>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Follow Up</label>
                    <div class="control">
                    <textarea class="textarea" name="follow_up"></textarea>
                    </div>
                </div>
                <div class="control is-flex is-justify-content-end">
                    <button class="button" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </main>
    <?php include("../_partials/_footer.php"); ?>
</body>

</html>