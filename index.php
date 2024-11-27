<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral System</title>
    <link rel="stylesheet" type="text/css" href="static/styles.css">
    <link rel="stylesheet" type="text/css" href="css/homepagestyles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
</head>
<body>
    <?php include("_partials/_navbar.php"); ?>
    <!-- Hero Section -->
    <header class="hero-section">
        <div class="hero-content">
            <h1>Welcome to the Referral Assessment System</h1>
            <p>Your guide to personalized counseling and support services.</p>
        </div>
    </header>

    <!-- Grid Container -->
    <div class="grid-container">
        <div class="section-container" onclick="window.location.href='bookedsessions.php';">
            <section class="content-section">
                <h2>Book a counseling</h2>
                <p>Book now—our counselors are ready to assist you.</p>
            </section>
        </div>

        <div class="section-container" onclick="window.location.href='viewbookedsessions.php';">
            <section class="content-section">
                <h2>View Booked Sessions</h2>
                <p>Check your schedule and session details easily.</p>
            </section>
        </div>
    </div>
    <?php include("_partials/footer.php"); ?>
</body>

</html>