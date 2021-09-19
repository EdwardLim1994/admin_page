<?php
require_once('./backend/login/dbConfig.php');
session_start();

//Get current session id from database
$stmt = $mysqli->prepare("SELECT current_session_id FROM users where username = '" . $_SESSION['username'] . "'");
$stmt->execute();
$result = $stmt->get_result();
$current_session = mysqli_fetch_assoc($result)['current_session_id'];

$stmt = $mysqli->prepare("SELECT para_description FROM parameter where para_code = 'homepage'");
$stmt->execute();
$result = $stmt->get_result();
$homepage_url = mysqli_fetch_assoc($result)['para_description'];

$stmt->close();
mysqli_close($mysqli);

if (isset($_SESSION["loggedin"]))
    //Compare current session id between session and database
    if ($_SESSION['currentId'] == $current_session)
        if ($_SESSION['role'] == "administrator")
            $currentUser = $_SESSION["username"];
        else
            header("location: ./menu.php");
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
    <title>User Maintanance</title>

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
    <link rel="stylesheet" href="./dist/css/datatables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js">
    </script>

    <script src="./dist/js/script.prod.js"></script>
    <script src="./dist/js/passwordValidator.prod.js"></script>
    <script src="./dist/js/userMaintanance.prod.js"></script>
    <script src="./dist/js/datatables.min.js"></script>

</head>

<body>
    <header>
        <div class="blue">
            <div class="container-fluid">
                <div class="row py-2">
                    <div class="col-md-4 my-auto ">

                    </div>
                    <div class="col-md-4 col-12 text-center my-auto">
                        <a href="<?= $homepage_url ?>">
                            <img class="img-fluid rounded logo hoverable" src="./assets/shopfront.jpeg" alt="Nightcat Shop">
                        </a>
                    </div>
                    <div class="col-md-4 text-center text-md-right my-auto">
                        <button class="btn btn-primary px-3 px-sm-4 py-2 py-sm-3 dropdown-toggle w-75 w-md-25" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <h5 class="h5-responsive">Hi, <?= $currentUser ?></h5>
                        </button>
                        <div class="dropdown-menu w-75 w-md-25">
                            <a class="dropdown-item" href="./account.php">Account</a>
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
        <!-- <div class="d-flex" id="wrapper">
            <div class="bg-light border-right" id="sidebar-wrapper">
                <div class="sidebar-heading">
                    <a href="./menu.php">Main Menu</a>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action bg-light">User Maintanance</a>

                </div>
            </div>
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="col-8">
                        <button class="btn" type="button" id="menu-toggle">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-4">
                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input class="form-control my-0 py-1 blue-border" type="text" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="input-group-text blue lighten-2" id="basic-text1">
                                    <i class="fas fa-search text-grey" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div> -->

        <div class="container-fluid">
            <div class="container">


                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb white pl-0">
                        <li class="breadcrumb-item"><a href="./menu.php">Menu</a></li>
                        <li class="breadcrumb-item active">User Maintanance</li>
                    </ol>
                </nav>

                <h1 class="mt-4 h1-responsive">User Maintanance</h1>
                <div class="row">
                    <div class="col-lg-10 col-md-8 col-sm-6"></div>
                    <div class="col-lg-2 col-md-4 col-sm-6 text-right">
                        <button class="btn btn-danger py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#addModal">
                            <span class="textBreak">Add User</span>
                            <span class="iconBreak"><i class="fas fa-user-plus"></i></span>
                        </button>
                    </div>
                </div>
                <div class="row py-3">
                    <div id="report-table" class='table-responsive'>

                    </div>
                </div>
            </div>
        </div>
        <!-- Central Modal Medium Info -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-info" role="document">
                <!--Content-->
                <!-- <form action="./Backend/login/userOperation.php" method="post" name="postType" id="addUserForm"> -->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading lead">Add User</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</spans>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="registerUsername" id="registerUsernameLabel" class="">
                                    Your username<span class="text-danger">&#8727;</span>
                                </label>
                                <input type="text" id="registerUsername" name="username" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="registerEmail" id="registerEmailLabel" class="">
                                    Your Email<span class="text-danger">&#8727;</span>
                                </label>
                                <input type="email" id="registerEmail" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="registerContact" id="registerContactLabel" class="">
                                    Your Contact<span class="text-danger">&#8727;</span>
                                </label>
                                <input type="text" id="registerContact" name="contactno" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 mb-3">

                                <label for="registerPassword">
                                    <div class="row justify-content-between">
                                        <div class="col-10">
                                            Your password<span class="text-danger">&#8727;</span>
                                        </div>
                                        <div class="col-2">
                                            <a id="PasswordVisible">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </label>
                                <input type="password" id="registerPassword" name="password" class="form-control" autocomplete="on">
                                <div id="registerPasswordValidate"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="passwordConfirm" id="passwordConfirmLabel">
                                    <div class="row justify-content-between">
                                        <div class="col-10">
                                            Confirm password<span class="text-danger">&#8727;</span>
                                        </div>
                                        <div class="col-2">
                                            <a id="ConfirmPasswordVisible">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </label>
                                <input type="password" id="passwordConfirm" class="form-control" autocomplete="on">
                                <div id="passwordConfirmValidate"></div>
                            </div>
                        </div>
                        <div class="form-row  mb-3">
                            <div class="col-12 mb-3">
                                <label for="registerStatus">Status</label>
                                <select class="custom-select" id="registerStatus" name="role" value="active">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row  mb-3">
                            <div class="col-12 mb-3">
                                <label for="registerRole">User Role<span class="text-danger">&#8727;</span></label>
                                <select class="custom-select" id="registerRole" name="role" value="staff">
                                    <option value="administrator">Administrator</option>
                                    <option value="staff">Staff</option>
                                    <!-- <option value="normal">Normal</option> -->
                                </select>
                            </div>
                        </div>

                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a type="button" id="addUserSubmitBtn" class="btn btn-info">Add User</a>
                        <a type="button" class="btn btn-outline-info waves-effect nevermind" data-dismiss="modal">Nevermind</a>
                    </div>
                </div>
                <!-- </form> -->
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Medium Info-->

        <!-- Central Modal Medium Info -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-info" role="document">
                <!--Content-->
                <!-- <form action="./backend/login/userOperation.php" method="post" name="postType"> -->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading lead">Edit User</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-2 mb-3">
                                <p><strong>Note***</strong></p>
                            </div>
                            <div class="col-10">
                                <p>Either to fill in both password and confirm password for changing password, or let both password and confirm password blank for not changing password</p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="registerUsername" id="editUsernameLabel">
                                    Your username
                                </label>
                                <input type="text" id="editUsername" name="username" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="reditEmail" id="reditEmailLabel" class="">
                                    Your Email
                                </label>
                                <input type="email" id="editEmail" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="editContact" id="editContactLabel" class="">
                                    Your Contact
                                </label>
                                <input type="text" id="editContact" name="contactno" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 mb-3">

                                <label for="editPassword">
                                    <div class="row justify-content-between">
                                        <div class="col-10">
                                            Your password
                                        </div>
                                        <div class="col-2">
                                            <a id="editPasswordVisible">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </label>
                                <input type="password" id="editPassword" name="password" class="form-control" autocomplete="on">
                                <div id="editPasswordValidate"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="editPasswordConfirm" id="editPasswordConfirmLabel">
                                    <div class="row justify-content-between">
                                        <div class="col-10">
                                            Confirm password
                                        </div>
                                        <div class="col-2">
                                            <a id="editConfirmPasswordVisible">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </label>
                                <input type="password" id="editPasswordConfirm" class="form-control" autocomplete="on">
                                <div id="editPasswordConfirmValidate"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 mb-3">

                                <label for="editLoginAttempt">Login Attempt</label>
                                <input type="number" id="editLoginAttempt" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="editStatus">Status</label>
                                <select class="custom-select" id="editStatus" name="role">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="editRole">User Role</label>
                                <select class="custom-select" id="editRole" name="role">
                                    <option value="administrator">Administrator</option>
                                    <option value="staff">Staff</option>
                                    <!-- <option value="normal">Normal</option> -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a type="button" id="editeUserSubmitButton" class="btn btn-info">Edit User</a>
                        <a type="button" class="btn btn-outline-info waves-effect nevermind" data-dismiss="modal">Nevermind</a>
                    </div>
                </div>
                <!-- </form> -->
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Medium Info-->

        <!-- Central Modal Warning Demo-->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <!-- <form action="./backend/login/userOperation.php" method="post" name="postType"> -->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading">Delete User</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <p>Are you want to delete <span id="deleteUserName"></span>?</p>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a type="button" id="deleteUserSubmitButton" class="btn btn-warning">Yes</a>
                        <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Nevermind</a>
                    </div>
                </div>
                <!-- </form> -->
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Warning Demo-->

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

</html>