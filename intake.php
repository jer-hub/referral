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
                <h1 class="title">Intake Summary</h1>
            </header>
            <main>
                <div>

                    <div class="control mt-5 mb-1">
                        <label for="">Counselor's Name</label>
                        <div class="control mx-2">
                            <input class="input" type="text">
                        </div>
                    </div>
                    <div class="control my-1">
                        <label for="">Client Number and Folder #</label>
                        <div class="control mx-2">
                            <input class="input" type="text">
                        </div>
                    </div>
                    <div class="is-flex is-align-items-center my-1">
                        <div>
                            <label for="">Date</label>
                            <div class="control mx-2">
                                <input class="input" type="date" placeholder="Select a date">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- questions -->
                <div class="mt-6">
                    <div>
                        <div class="my-1">
                            <p>1.) Breif description of client:</p>
                        </div>
                        <div class="my-1">
                            <div class="mx-2">
                                <div>
                                    <label>
                                        <input type="radio" name="foobar" />
                                        Walk In
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        <input type="radio" name="foobar" />
                                        Call In
                                    </label>
                                </div>
                                <div>
                                    <label>
                                        <input type="radio" name="foobar" />
                                        or Referral/Referred By:
                                        <input type="text" class="input">
                                    </label>
                                </div>
                                <div class="my-1">
                                    <textarea id="q_1" class="textarea" name="q_1"
                                        rows="3" placeholder="Write description here"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1">
                            <p>2.) Presenting problem (what client reports): </p>
                        </div>
                        <div class="my-1">
                            <div class="mx-2">
                                <div class="my-1">
                                    <textarea id="q_2" class="textarea" name="q_2"
                                        rows="3" placeholder="Write description here"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1">
                            <p>3.) Breif psychosocial history(family/cultural background): (e.g History Problem)</p>
                        </div>
                        <div class="my-1">
                            <div class="mx-2">
                                <div class="my-1">
                                    <textarea id="q_3" class="textarea" name="q_3"
                                        rows="3" placeholder="Write description here"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1">
                            <p>4.) Interaction, relationship, affect during intake: (e.g. Counselor's observation of client)</p>
                        </div>
                        <div class="my-1">
                            <div class="mx-2">
                                <div class="my-1">
                                    <textarea id="q_4" class="textarea" name="q_4"
                                        rows="3" placeholder="Write description here"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1">
                            <p>5.) Conceptualization (including degree of disturbance and client resources) How do you assess degree if disturbance? What's causing problem?</p>
                        </div>
                        <div class="my-1">
                            <div class="mx-2">
                                <div class="my-1">
                                    <textarea id="q_5" class="textarea" name="q_5"
                                        rows="3" placeholder="Write description here"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="my-1">
                            <p>6.) Recommendation for treatment or disposition (include category VST, ST, group, etc.)</p>
                        </div>
                        <div class="my-1">
                            <div class="mx-2">
                                <div class="my-1">
                                    <textarea id="q_4" class="textarea" name="q_4"
                                        rows="3" placeholder="Write description here"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- attented by -->
                <div class="control my-6">
                    <label for="">Attended by:</label>
                    <input type="text" name="" id="" class="input">
                </div>


                <!-- submit btn -->
                <div class="buttons is-flex is-justify-content-end my-5">
                    <button class="button is-link is-light">Submit</button>
                </div>
            </main>
        </div>
        <?php include("_partials/_footer.php"); ?>
    </body>

    </html>