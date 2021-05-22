<?php
require_once('./backend/login/dbConfig.php');
session_start();

//Get current session id from database
$stmt = $mysqli->prepare("SELECT current_session_id FROM users where username = '" . $_SESSION['username'] . "'");
$stmt->execute();
$result = $stmt->get_result();
$current_session = mysqli_fetch_assoc($result)['current_session_id'];

$stmt->close();
mysqli_close($mysqli);

if (isset($_SESSION["loggedin"]))
    //Compare current session id between session and database
    if ($_SESSION['currentId'] == $current_session)
        $currentUser = $_SESSION["username"];
    else {
        session_destroy();
        header("location: ./index.php?error=Your account is logged in by another browser");
    }
else
    header("location: ./index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>

    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="192x192" href="./assets/favicon/android-chrome-192x192.png" />
    <link rel="icon" type="image/png" sizes="512x512" href="./assets/favicon/android-chrome-512x512.png" />
    <link rel="apple-touch-icon" href="./assets/favicon/apple-touch-icon.png">
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./dist/css/style.min.css">
    <link rel="stylesheet" href="./dist/css/simple-sidebar.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js">
    </script>

    <script src="./dist/js/script.prod.js"></script>
    <script src="./dist/js/passwordValidator.prod.js"></script>
</head>

<body>
    <header>
        <div class="blue">
            <div class="container-fluid">
                <div class="row py-2">
                    <div class="col-4 my-auto ">

                    </div>
                    <div class="col-4 text-center my-auto">
                        <a href="https://www.nightcatdigitalsolutions.com">
                            <img class="img-fluid rounded logo hoverable" src="./assets/titleImage.jpeg" alt="Title Image">
                        </a>
                    </div>
                    <div class="col-4 text-right my-auto">
                        <button class="btn btn-primary px-3 px-sm-4 py-2 py-sm-3 dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <h5 class="h5-responsive">Hi, <?= $currentUser ?></h5>
                        </button>
                        <div class="dropdown-menu">

                            <!-- <div class="dropdown-divider"></div> -->
                            <form action="./backend/login/logout.php" method="post">
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container py-5">

            <div class="col-12">



                <!-- Default form contact -->
                <!-- <form class="p-5" action="post" action="./Backend/login/userOperation.php" id="accountEditForm"> -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb white pl-0">
                        <li class="breadcrumb-item"><a href="./menu.php">Menu</a></li>
                        <li class="breadcrumb-item active">Account</li>
                    </ol>
                </nav>
                <p class="h4 mb-4">Account Setting</p>

                <div class="form-row">
                    <div class="col-12 mb-3">
                        <label for="accountUsername" id="accountUsernameLable" class="">
                            Username
                        </label>
                        <input type="text" id="accountUsername" name="username" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 mb-3">
                        <label for="accountContact" id="accountContactLabel" class="">
                            Contact
                        </label>
                        <input type="text" id="accountContact" name="contactno" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 mb-3">
                        <label for="accountEmail" id="accountEmailLabel" class="">
                            Email
                        </label>
                        <input type="text" id="accountEmail" name="email" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 mb-3">

                        <label for="accountPassword">
                            <div class="row justify-content-between">
                                <div class="col-10">
                                    Your password
                                </div>
                                <div class="col-2">
                                    <a id="accountPasswordVisible">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </label>
                        <input type="password" id="accountPassword" name="password" class="form-control" autocomplete="on">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 mb-3">
                        <label for="accountPasswordConfirm" id="accountPasswordConfirmLabel">
                            <div class="row justify-content-between">
                                <div class="col-10">
                                    Confirm password
                                </div>
                                <div class="col-2">
                                    <a id="accountConfirmPasswordVisible">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </label>
                        <input type="password" id="accountPasswordConfirm" class="form-control" autocomplete="on">
                        <div id="accountPasswordConfirmValidate"></div>
                    </div>
                </div>


                <!-- Send button -->
                <div class="form-row justify-content-center">
                    <div class="col-md-4 col-sm-6">
                        <button class="btn btn-primary btn-block" type="button" id="accountSubmit">Update</button>
                    </div>
                </div>
                <!-- </form> -->
                <!-- Default form contact -->
            </div>
        </div>
        <!-- Success Alert -->
        <div class="modal fade" id="successToModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-success" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="heading lead" id="successModalHeadline"></p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <p id="successModalBody"></p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">OK</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Failed Alert -->
        <div class="modal fade" id="failedToModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="heading lead" id="failedModalHeadline"></p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <p id="failedModalBody"></p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">OK</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="page-footer font-small blue font-small">
        <div class="col-md-12 text-center">

            <!-- Social Link on Bottom -->
            <div class="mb-4 pt-4 flex-center">
                <a class="whatsappLink">
                    <i class="fab fa-whatsapp a-lg mr-md-5 mr-3 fa-2x hoverable"></i>
                </a>
                <!-- Facebook -->
                <a class="fb-ic" href="https://www.facebook.com/nightcatdigitalsolutions">
                    <i class="fab fa-facebook fa-lg mr-md-5 mr-3 fa-2x hoverable"> </i>
                </a>
                <!-- Twitter -->
                <a class="tw-ic" href="https://twitter.com/nightcatdigital">
                    <i class="fab fa-twitter fa-lg mr-md-5 mr-3 fa-2x hoverable"> </i>
                </a>
                <!--Instagram-->
                <a class="ins-ic" href="https://www.instagram.com/nightcatdigitalsolutions/">
                    <i class="fab fa-instagram fa-lg mr-md-5 mr-3 fa-2x hoverable"> </i>
                </a>
            </div>
        </div>
        <div class="footer-copyright text-center py-3">
            <a href="https://www.nightcatdigitalsolutions.com">NIGHTCAT DIGITAL SOLUTIONS © 2013 -
                <span id="latestYear"></span>. ALL RIGHTS RESERVED</a>
        </div>
    </footer>
</body>
<script type="text/javascript">
    $(document).ready(function() {

        $("#accountPasswordVisible").click(function() {
            toggleVisiblePassword("#accountPasswordVisible", "#accountPassword");
        });
        $("#accountConfirmPasswordVisible").click(function() {
            toggleVisiblePassword("#accountConfirmPasswordVisible", "#accountPasswordConfirm");
        });
        $.ajax({
            type: "post",
            url: "./backend/login/userOperation.php",
            data: {
                postType: "staffView"
            },
            beforeLoad: function() {

            },
            success: function(results) {
                if (results) {
                    results = JSON.parse(results);
                    $("#accountUsername").val(results[0].username);
                    $("#accountContact").val(results[0].contact_num);
                    $("#accountEmail").val(results[0].email);

                } else {
                    console.log("Something wrong");
                }
            },
            error: function() {

            }

        });

        var accountPasswordMatch = true;
        useOldPassword("#accountPasswordConfirm", "#accountPasswordConfirmValidate");
        useOldPassword("#accountPassword", "#accountPasswordValidate");
        $("#accountPasswordConfirm, #accountPassword").on("input focusout", function() {
            var password = $("#accountPassword").val();
            var confirm = $("#accountPasswordConfirm").val();

            if (password != "" && confirm != "") {
                if (password != confirm) {
                    $("#accountPassword").removeClass("is-valid").addClass("is-invalid");
                    notValidInput("#accountPasswordConfirm", "#accountPasswordConfirmValidate", "Password is not matched");
                    accountPasswordMatch = false;
                } else {
                    $("#accountPassword").removeClass("is-invalid").addClass("is-valid");
                    validInput("#accountPasswordConfirm", "#accountPasswordConfirmValidate");
                    accountPasswordMatch = true;
                }
            } else if (password == "" && confirm != "") {
                $("#accountPassword").removeClass("is-valid").addClass("is-invalid");
                notValidInput("#accountPasswordConfirm", "#accountPasswordConfirmValidate", "Password is empty");
                accountPasswordMatch = false;

            } else if (confirm == "" && password != "") {
                $("#accountPassword").removeClass("is-valid").addClass("is-invalid");
                notValidInput("#accountPasswordConfirm", "#accountPasswordConfirmValidate", "Confirm Password is empty");
                accountPasswordMatch = false;
            } else {

                useOldPassword("#accountPasswordConfirm", "#accountPasswordConfirmValidate");
                useOldPassword("#accountPassword", "#accountPasswordValidate");
                accountPasswordMatch = true;
            }
        });

        $("#accountSubmit").click(function() {
            var username = $("#accountUsername").val();
            var contact = $("#accountContact").val();
            var email = $("#accountEmail").val();
            var password = $("#accountPassword").val();

            if (username != "" && contact != "" && email != "" && accountPasswordMatch == true) {

                $.ajax({
                    type: "post",
                    url: "./backend/login/userOperation.php",
                    data: {
                        postType: "staffUpdate",
                        username: username,
                        contact_num: contact,
                        email: email,
                        password: password
                    },
                    beforeLoad: function() {

                    },
                    success: function(results) {
                        if (results.trim() == "Success") {
                            $("#accountPassword, #accountPasswordConfirm").val("");
                            $("#successModalHeadline").empty().append("Account Updated");
                            $("#successModalBody").empty().append("Your account detail has been successfully updated");
                            $('#successToModal').modal('show');
                        } else {
                            $("#failedModalHeadline").empty().append("Failed to Update Account");
                            $("#failedModalBody").empty().append(results);
                            $('#failedToModal').modal('show');
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }

                });
            } else {
                $("#failedModalHeadline").empty().append("Failed to Update Account");
                $("#failedModalBody").empty().append("Please fill up all the required fields");
                $('#failedToModal').modal('show');
            }
        });
    });
</script>

</html>