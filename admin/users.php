<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
                <!-- Users -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"]) && isset($_POST["is_admin"])) {
                    $user_id = $_POST["user_id"];
                    $is_admin = $_POST["is_admin"];

                    $conn = new mysqli("localhost", "root", "", "referral");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "UPDATE users SET is_admin = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $is_admin, $user_id);

                    if ($stmt->execute()) {
                        if ($user_id == $_SESSION['user_id'] && $is_admin == 0) {
                            header("Location: ../logout.php");
                            exit();
                        }
                        echo "<div class='notification is-info is-light'>User admin status updated successfully.</div>";
                    } else {
                        echo "Error updating user admin status: " . $conn->error;
                    }

                    $stmt->close();
                    $conn->close();
                }

                $conn = new mysqli("localhost", "root", "", "referral");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, first_name, last_name, email, is_admin FROM users ORDER BY last_name ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table class='table is-fullwidth'>";
                    echo "<thead><tr><th>User ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Admin Status</th><th>Actions</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . ($row["is_admin"] ? "Yes" : "No") . "</td>";
                        echo "<td>
                                <form method='POST' class='is-flex is-align-items-center is-gap-2'>
                                    <input type='hidden' name='user_id' value='" . $row["id"] . "'>
                                    <select name='is_admin' class='control'>
                                        <option value='1'" . ($row["is_admin"] ? " selected" : "") . ">Yes</option>
                                        <option value='0'" . (!$row["is_admin"] ? " selected" : "") . ">No</option>
                                    </select>
                                    <button class='button is-small' type='submit'>Update</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "No users found.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </main>

    <?php include("../_partials/_footer.php"); ?>
</body>

</html>