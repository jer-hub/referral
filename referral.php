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
                <h1 class="title">Refer a Concern</h1>
            </header>
            <main>
                <!-- concerns -->
                <div>
                    <div class="mt-3">
                        <p class="has-text-weight-bold">Concerns: </p>
                    </div>
                    <div class="checkboxes">
                        <label class="checkbox">
                            <input type="checkbox" />
                            Absences/Tardiness/Cutting classes
                        </label>

                        <label class="checkbox">
                            <input type="checkbox" />
                            Academic Problems
                        </label>

                        <label class="checkbox">
                            <input type="checkbox" />
                            Personal Problems
                        </label>

                        <label class="checkbox">
                            <input type="checkbox" />
                            Family Problems
                        </label>

                        <label class="checkbox">
                            <input type="checkbox" />
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
                            <input class="input mx-2" type="text" placeholder="" />
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
                            <input class="input mx-2" type="text" placeholder="" />
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
                            <input class="input mx-2" type="text" placeholder="" />
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
                            <input class="input mx-2" type="text" placeholder="" />
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
                            <input class="input mx-2" type="text" placeholder="" />
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
                            <label for="concern_details">Details of Concern: </label>
                            <textarea id="concern_details" class="textarea" name="concern_details" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="buttons is-flex is-justify-content-end my-2">
                    <button class="button is-link is-light">Submit</button>
                </div>
            </main>
        </div>
        <?php include("_partials/_footer.php"); ?>
    </body>

    </html>