<header?php session_start(); ?>

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
                <h1 class="title">Refer a Conference</h1>
            </header>
            <main>

                <div class="is-flex is-align-items-center mt-5">
                    <div>
                        <label for="">Date/Time: </label>
                        <div class="control mx-2">
                            <input class="input" type="datetime-local">
                        </div>
                    </div>

                    <div class="ml-5">
                        <label for="">Nature of Conference: </label>
                        <div class="control mx-2">
                            <div>
                                <label class="radio">
                                    <input type="radio" name="foobar" />
                                    Walk In
                                </label>
                            </div>
                            <div>
                                <label class="radio">
                                    <input type="radio" name="foobar" />
                                    Call In
                                </label>
                            </div>
                        </div>
                        <div>
                            <div class="control mx-2">
                                <label for="">Or Referral/Referred By: </label>
                                <input class="input" type="text">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- personal data -->
                <div class="mt-3">
                    <div>
                        <p class="has-text-weight-bold">Personal Data: </p>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="control my-1">
                                <label for="">Name: </label>
                                <input class="input mx-2" type="text" placeholder="Select a date">
                            </div>
                            <div class="control my-1">
                                <label for="">Address: </label>
                                <input class="input mx-2" type="text" placeholder="Select a date">
                            </div>
                            <div class="control my-1">
                                <label for="">Father: </label>
                                <input class="input mx-2" type="text" placeholder="Select a date">
                            </div>
                            <div class="control my-1">
                                <label for="">Mother: </label>
                                <input class="input mx-2" type="text" placeholder="Select a date">
                            </div>
                        </div>
                        <div class="column">
                            <div class="control my-1">
                                <label for="">Grade and Section: </label>
                                <input class="input mx-2" type="text" placeholder="Select a date">
                            </div>
                            <div class="control my-1">
                                <label for="">Sex: </label>
                                <input class="input mx-2" type="text" placeholder="Select a date">
                            </div>
                            <div class="control my-1">
                                <label for="">Father's Contact Number: </label>
                                <input class="input mx-2" type="text" placeholder="Select a date">
                            </div>
                            <div class="control my-1">
                                <label for="">Mother's Contact Number: </label>
                                <input class="input mx-2" type="text" placeholder="Select a date">
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="my-1">
                                <label for="students_commitment">Student's Commitment: </label>
                                <textarea id="students_commitment" class="textarea" name="students_commitment"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="column">
                            <div class="my-1">
                                <label for="parents_commitment">Parent's Commitment: </label>
                                <textarea id="parents_commitment" class="textarea" name="parents_commitment"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- submit btn -->
                <div class="buttons is-flex is-justify-content-end my-2">
                    <button class="button is-link is-light">Submit</button>
                </div>
            </main>
        </div>
        <?php include("_partials/_footer.php"); ?>
    </body>

    </html>