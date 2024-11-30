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
    <title>Intake Management</title>
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
                <!-- Intakes -->
                <table class='table is-fullwidth'>
                    <thead>
                        <tr>
                            <th>Intake ID</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Empty table for now -->
                        <tr><td colspan='4'>No intakes found.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include("../_partials/_footer.php"); ?>
</body>

</html>