<?php 
session_start(); 
include("db_connection.php"); // Include the database connection file
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral System</title>
    <link rel="stylesheet" type="text/css" href="static/styles.css">
</head>

<body>
    <?php include("_partials/_navbar.php"); ?>
    <div class="container">
        <header class="my-2">
            <h1 class="title">Refer a Concern</h1>
        </header>
        <main>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $user_id = $_SESSION['user_id'];
                $concerns = isset($_POST['concerns']) ? implode(", ", $_POST['concerns']) : '';
                $other_concerns = $_POST['other_concerns'];
                $concern_details = $_POST['concern_details'];
                $actions_taken = isset($_POST['actions_taken']) ? implode(", ", $_POST['actions_taken']) : '';
                $recommendations = $_POST['recommendations'];

                if (empty($concerns) && empty($other_concerns)) {
                    echo '<div class="notification is-danger">Please specify at least one concern.</div>';
                } elseif (empty($actions_taken)) {
                    echo '<div class="notification is-danger">Please specify at least one action taken.</div>';
                } else {
                    $concerns .= ", " . $other_concerns;
                    $stmt = $conn->prepare("INSERT INTO referrals (user_id, concerns, concern_details, actions_taken, recommendations, notification_status) VALUES (?, ?, ?, ?, ?, 'unread')");
                    $stmt->bind_param("issss", $user_id, $concerns, $concern_details, $actions_taken, $recommendations);

                    if ($stmt->execute()) {
                        echo '<div class="notification is-success">Referral submitted successfully</div>';
                    } else {
                        echo '<div class="notification is-danger">Error: ' . $stmt->error . '</div>';
                    }

                    $stmt->close();
                }
            }
            ?>
            <form method="POST" action="">
                <!-- concerns -->
                <div>
                    <div class="mt-3">
                        <p class="has-text-weight-bold">Concerns: </p>
                    </div>
                    <div class="checkboxes">
                        <label class="checkbox">
                            <input type="checkbox" name="concerns[]" value="Absences/Tardiness/Cutting classes" />
                            Absences/Tardiness/Cutting classes
                        </label>

                        <label class="checkbox">
                            <input type="checkbox" name="concerns[]" value="Academic Problems" />
                            Academic Problems
                        </label>

                        <label class="checkbox">
                            <input type="checkbox" name="concerns[]" value="Personal Problems" />
                            Personal Problems
                        </label>

                        <label class="checkbox">
                            <input type="checkbox" name="concerns[]" value="Family Problems" />
                            Family Problems
                        </label>

                        <label class="checkbox">
                            <input type="checkbox" name="concerns[]" value="Peer Problems" />
                            Peer Problems
                        </label>
                    </div>
                    <div>
                        <label for="other_concerns">other concerns: </label>
                        <textarea id="other_concerns" class="textarea" name="other_concerns" rows="3"></textarea>
                    </div>
                    <div>
                        <label for="concern_details">Details of Concern: </label>
                        <textarea id="concern_details" class="textarea" name="concern_details" rows="3"></textarea>
                    </div>
                </div>
                <!-- actions taken -->
                <div>
                    <div>
                        <div class="mt-3">
                            <p class="has-text-weight-bold">A. Actions taken: </p>
                        </div>
                        <div class="control is-flex is-align-items-center my-1">
                            <label for="action-a">1.) </label>
                            <input class="input mx-2" type="text" name="actions_taken[]" placeholder="" />
                            <div class="is-flex is-align-items-center">
                                <p class="has-text-weight-bold">Date: </p>
                                <div class="field mx-2">
                                    <div class="control">
                                        <input class="input" type="date" placeholder="Select a date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control is-flex is-align-items-center my-1">
                            <label for="action-a">2.) </label>
                            <input class="input mx-2" type="text" name="actions_taken[]" placeholder="" />
                            <div class="is-flex is-align-items-center">
                                <p class="has-text-weight-bold">Date: </p>
                                <div class="field mx-2">
                                    <div class="control">
                                        <input class="input" type="date" placeholder="Select a date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control is-flex is-align-items-center my-1">
                            <label for="action-a">3.) </label>
                            <input class="input mx-2" type="text" name="actions_taken[]" placeholder="" />
                            <div class="is-flex is-align-items-center">
                                <p class="has-text-weight-bold">Date: </p>
                                <div class="field mx-2">
                                    <div class="control">
                                        <input class="input" type="date" placeholder="Select a date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control is-flex is-align-items-center my-1">
                            <label for="action-a">4.) </label>
                            <input class="input mx-2" type="text" name="actions_taken[]" placeholder="" />
                            <div class="is-flex is-align-items-center">
                                <p class="has-text-weight-bold">Date: </p>
                                <div class="field mx-2">
                                    <div class="control">
                                        <input class="input" type="date" placeholder="Select a date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control is-flex is-align-items-center my-1">
                            <label for="action-a">5.) </label>
                            <input class="input mx-2" type="text" name="actions_taken[]" placeholder="" />
                            <div class="is-flex is-align-items-center">
                                <p class="has-text-weight-bold">Date: </p>
                                <div class="field mx-2">
                                    <div class="control">
                                        <input class="input" type="date" placeholder="Select a date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mt-3">
                            <p class="has-text-weight-bold">B. Recommendations </p>
                        </div>
                        <div>
                            <textarea id="concern_details" class="textarea" name="recommendations" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="buttons is-flex is-justify-content-end my-2">
                    <button class="button is-link is-light" type="submit">Submit</button>
                </div>
            </form>
        </main>
    </div>
    <?php include("_partials/_footer.php"); ?>
</body>

</html>