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
    <title>Parameter Maintanance</title>

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
    <link rel="stylesheet" href="./dist/css/datatables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js">
    </script>

    <script src="./dist/js/script.prod.js"></script>
    <script src="./dist/js/parameterMaintaanance.prod.js"></script>
    <script src="./dist/js/datatables.min.js"></script>

</head>

<body>
    <header>
        <div class="blue">
            <div class="container-fluid">
                <div class="row py-2">
                    <div class="col-4 my-auto ">

                    </div>
                    <div class="col-4 text-center my-auto">
                        <a href="https://nightcatdigitalsolutions.com/avenger/menu.php">
                            <img class="img-fluid rounded logo hoverable" src="./assets/titleImage.jpeg" alt="Title Image">
                        </a>
                    </div>
                    <div class="col-4 text-right my-auto">
                        <button class="btn btn-primary px-3 px-sm-4 py-2 py-sm-3 dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <h5 class="h5-responsive">Hi, <?= $currentUser ?></h5>
                        </button>
                        <div class="dropdown-menu">
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
        <div class="container-fluid">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb white pl-0">
                        <li class="breadcrumb-item"><a href="./menu.php">Menu</a></li>
                        <li class="breadcrumb-item active">Parameter Maintanance</li>
                    </ol>
                </nav>

                <h1 class="mt-4 h1-responsive">Parameter Maintanance</h1>
                <div class="row">
                    <div class="col-6 my-auto">
                        <!-- Basic dropdown -->
                        <button class="btn btn-cyan dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="textBreak">Show / Hide</span>
                            <span class="iconBreak"><i class="fas fa-eye"></i> / <i class="fas fa-eye-slash"></i></span>
                        </button>

                        <div class="dropdown-menu">
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="0">#</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="1">Action</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="2">Type</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="3">Description</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="4">Description 2</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="5">Description 3</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="6">Quantity</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="7">Amount</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="8">Start Date</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="9">End Date</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="10">Start Time</a>
                            <a class="toggle-vis dropdown-item pr-5" data-status="false" data-column="11">End Time</a>
                        </div>
                        <!-- Basic dropdown -->
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-success py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#addModal">
                            <span class="textBreak">Add Parameter</span>
                            <span class="iconBreak"><i class="fas fa-plus-square fa-2x"></i></span>
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
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-notify modal-success" role="document">
                <!--Content-->
                <form action="./backend/parameter/parameter.php" method="post" name="postType" id="addParameterForm" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="postType" value="add">
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading lead">Add Parameter</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</spans>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">

                            <!-- <div class="form-row mb-3">
                                <div class="col-8 mb-3">
                                    <label for="addFilename" id="addFilenameLabel" class="">
                                        Image
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="addFilename" name="imgUpload" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="addFilename">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3 border">
                                    <img id='addFilePreview' class="img-preview" />
                                </div>
                            </div> -->
                            <div class="form-row mb-3">
                                <div class="col-12 mb-3">
                                    <label for="addType">Type<span class="text-danger">&#8727;</span></label>
                                    <input type="text" id="addType" name="para_code" class="form-control" required>
                                    <!-- <select class="custom-select" id="addType" name="role" value="active">
                                    <option value="maybank">Maybank</option>
                                    <option value="cimb">CIMB</option>
                                    <option value="publicbank">Public Bank</option>
                                </select> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="addDescription">Description</label>
                                    <input type="text" id="addDescription" name="para_description" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="addDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description 2</label>
                                    <input type="text" id="addDescription2" name="para_description2" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description 3</label>
                                    <input type="text" id="addDescription3" name="para_description3" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="addStartDate" class="row">
                                        <div class="col-6">
                                            Start Date
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-success p-1" id="addStartDateReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="date" name="start_date" id="addStartDate">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="addEndDate" class="row">
                                        <div class="col-6">
                                            End Date
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-success p-1" id="addEndDateReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="date" name="end_date" id="addEndDate">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="addStartTime" class="row">
                                        <div class="col-6">
                                            Start Time
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-success p-1" id="addStartTimeReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="time" name="start_time" id="addStartTime">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="addEndTime" class="row">
                                        <div class="col-6">
                                            End Time
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-success p-1" id="addEndTimeReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="time" name="end_time" id="addEndTime">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="addQuantity">Quantity</label>
                                    <input class="form-control" type="number" min="0" step="1" name="quantity" id="addQuantity">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="addAmount">Amount</label>
                                    <input class="form-control" type="number" min="0.00" step="0.01" name="amount" id="addAmount">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="addParameterSubmitBtn" class="btn btn-success">Add Parameter</button>
                            <a type="button" class="btn btn-outline-success waves-effect nevermind" data-dismiss="modal">Nevermind</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Central Modal Medium Info-->

        <!-- Central Modal Medium Info -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <form action="./backend/parameter/parameter.php" method="post" id="editParameterForm" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="postType" value="update">
                    <input type="number" hidden="true" name="parameter_id" id="editParameterID">
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading lead">Edit Parameter (ID : <span id="editParameterIDHeader"></span>)</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">

                            <!-- <div class="form-row mb-3">
                                <div class="col-8 mb-3">
                                    <label for="editFilename" id="editFilenameLabel" class="">
                                        Image
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="editFilename" name="imgUpload" aria-describedby="editFilename">
                                        <label class="custom-file-label" for="editFilename">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3 border">
                                    <img id='editFilePreview' class="img-preview" />
                                </div>
                            </div> -->
                            <div class="form-row  mb-3">
                                <div class="col-12 mb-3">
                                    <label for="editType">Type<span class="text-danger">&#8727;</span></label>
                                    <input type="text" class="form-control" name="para_code" id="editType">
                                    <!-- <select class="custom-select" id="editType" name="role" value="active">
                                    <option value="maybank">Maybank</option>
                                    <option value="cimb">CIMB</option>
                                    <option value="publicbank">Public Bank</option>
                                </select> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="editDescription">Description</label>
                                    <input type="text" id="editDescription" name="para_description" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description 2</label>
                                    <input type="text" id="editDescription2" name="para_description2" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description 3</label>
                                    <input type="text" id="editDescription3" name="para_description3" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="editStartDate" class="row">
                                        <div class="col-6">
                                            Start Date
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-warning p-1" id="editStartDateReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="date" name="start_date" id="editStartDate">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editEndDate" class="row">
                                        <div class="col-6">
                                            End Date
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-warning p-1" id="editEndDateReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="date" name="end_date" id="editEndDate">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="editStartTime" class="row">
                                        <div class="col-6">
                                            Start Time
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-warning p-1" id="editStartTimeReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="time" name="start_time" id="editStartTime">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editEndTime" class="row">
                                        <div class="col-6">
                                            End Time
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-warning p-1" id="editEndTimeReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="time" name="end_time" id="editEndTime">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="editQuantity">Quantity</label>
                                    <input class="form-control" type="number" min="0" step="1" name="quantity" id="editQuantity">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editAmount">Amount</label>
                                    <input class="form-control" type="number" min="0" step="0.01" name="amount" id="editAmount">
                                </div>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="editParameterSubmitButton" class="btn btn-warning">Edit Parameter</button>
                            <a type="button" class="btn btn-outline-warning waves-effect nevermind" data-dismiss="modal">Nevermind</a>
                        </div>
                    </div>
                </form>
                <!-- </form> -->
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Medium Info-->

        <!-- Central Modal Medium Info -->
        <div class="modal fade" id="cloneModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-notify" role="document">
                <!--Content-->
                <form action="./backend/parameter/parameter.php" method="post" id="cloneParameterForm" enctype="multipart/form-data">
                    <input type="text" hidden="true" name="postType" value="add">
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header secondary-color">
                            <p class="heading lead">Clone Parameter (ID : <span id="cloneParameterIDHeader"></span>)</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">

                            <!-- <div class="form-row mb-3">
                                <div class="col-8 mb-3">
                                    <label for="cloneFilename" id="cloneFilenameLabel" class="">
                                        Image
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="cloneFilename" name="imgUpload" aria-describedby="cloneFilename">
                                        <label class="custom-file-label" for=cloneFilename">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3 border">
                                    <img id='cloneFilePreview' class="img-preview" />
                                </div>
                            </div> -->
                            <div class="form-row  mb-3">
                                <div class="col-12 mb-3">
                                    <label for="cloneType">Type<span class="text-danger">&#8727;</span></label>
                                    <input type="text" id="cloneType" name="para_code" class="form-control">
                                    <!-- <select class="custom-select" id="cloneType" name="role" value="active">
                                    <option value="maybank">Maybank</option>
                                    <option value="cimb">CIMB</option>
                                    <option value="publicbank">Public Bank</option>
                                </select> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="cloneDescription">Description</label>
                                    <input type="text" id="cloneDescription" name="para_description" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="cloneDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description 2</label>
                                    <input type="text" id="cloneDescription2" name="para_description2" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description 3</label>
                                    <input type="text" id="cloneDescription3" name="para_description3" class="form-control">
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="cloneStartDate" class="row">
                                        <div class="col-6">
                                            Start Date
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-secondary p-1" id="cloneStartDateReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="date" name="start_date" id="cloneStartDate">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cloneEndDate" class="row">
                                        <div class="col-6">
                                            End Date
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-secondary p-1" id="cloneEndDateReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="date" name="end_date" id="cloneEndDate">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="cloneStartTime" class="row">
                                        <div class="col-6">
                                            Start Time
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-secondary p-1" id="cloneStartTimeReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="time" name="start_time" id="cloneStartTime">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cloneEndTime" class="row">
                                        <div class="col-6">
                                            End Time
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-secondary p-1" id="cloneEndTimeReset"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </label>
                                    <input class="form-control" type="time" name="end_time" id="cloneEndTime">
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="cloneQuantity">Quantity</label>
                                    <input class="form-control" type="number" min="0" step="1" name="quantity" id="cloneQuantity">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cloneAmount">Amount</label>
                                    <input class="form-control" type="number" min="0" step="0.01" name="amount" id="cloneAmount">
                                </div>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="cloneParameterSubmitButton" class="btn btn-secondary">Clone Parameter</button>
                            <a type="button" class="btn btn-outline-secondary waves-effect nevermind" data-dismiss="modal">Nevermind</a>

                        </div>
                    </div>
                </form>
                <!-- </form> -->
                <!--/.Content-->
            </div>
        </div>

        <!-- Central Modal Warning Demo-->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-notify modal-danger" role="document">
                <!--Content-->
                <!-- <form action="./backend/login/userOperation.php" method="post" name="postType"> -->
                <form action="./backend/parameter/parameter.php" method="post" id="deleteParameterForm">
                    <input type="text" hidden="true" name="postType" value="delete">
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


                            <p>Are you want to delete parameter with ID <strong><span id="deleteParameterIDHeader"></span></strong>?</p>
                            <strong><p>This cannot be undone!!!</p></strong>
                            <input type="number" hidden="true" id="deleteParameter" name="parameter_id">

                            <!-- <div class="form-row mb-3">
                                <div class="col-8 mb-3">
                                    <label for="editFilename" id="editFilenameLabel" class="">
                                        Image
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="editFilename" name="imgUpload" aria-describedby="editFilename">
                                        <label class="custom-file-label" for="editFilename">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-4 mb-3 border">
                                    <img id='editFilePreview' class="img-preview" />
                                </div>
                            </div> -->
                            <div class="form-row  mb-3">
                                <div class="col-12 mb-3">
                                    <label for="deleteType">Type<span class="text-danger">&#8727;</span></label>
                                    <input type="text" class="form-control" name="para_code" id="deleteType" readonly>
                                    <!-- <select class="custom-select" id="editType" name="role" value="active">
                                    <option value="maybank">Maybank</option>
                                    <option value="cimb">CIMB</option>
                                    <option value="publicbank">Public Bank</option>
                                </select> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description</label>
                                    <input type="text" id="deleteDescription" name="para_description" class="form-control" readonly>
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description 2</label>
                                    <input type="text" id="deleteDescription2" name="para_description2" class="form-control" readonly>
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-3">
                                    <label for="deleteDescription">Description 3</label>
                                    <input type="text" id="deleteDescription3" name="para_description3" class="form-control" readonly>
                                    <!-- <textarea class="form-control rounded-0" id="editDescription" rows="3"></textarea> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="deleteStartDate" class="row">Start Date</label>
                                    <input class="form-control" type="date" name="start_date" id="deleteStartDate" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="deleteEndDate" class="row">End Date</label>
                                    <input class="form-control" type="date" name="end_date" id="deleteEndDate" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="deleteStartTime" class="row">Start Time</label>
                                    <input class="form-control" type="time" name="start_time" id="deleteStartTime" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="deleteEndTime" class="row">End Time</label>
                                    <input class="form-control" type="time" name="end_time" id="deleteEndTime" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="deleteQuantity">Quantity</label>
                                    <input class="form-control" type="number" min="0" step="1" name="quantity" id="deleteQuantity" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="deleteAmount">Amount</label>
                                    <input class="form-control" type="number" min="0" step="0.01" name="amount" id="deleteAmount" readonly>
                                </div>
                            </div>
                        </div>
                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="deleteParameterSubmitButton" class="btn btn-danger">Yes</button>
                            <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Nevermind</a>
                        </div>
                    </div>
                </form>
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

<script type="text/javascript">
    <?php
    if (isset($_GET['failed'])) {
        switch ($_GET['failed']) {

            case ("wrong image format"):
    ?>
                $("#failedModalHeadline").empty().append("Failed to Add Parameter");
                $("#failedModalBody").empty().append("Your image must in format 'jpg', 'jpeg' or 'png'");
                $('#failedToModal').modal('show');
            <?php
                break;
            case ("id no found"):
            ?>
                $("#failedModalHeadline").empty().append("Failed to Delete Parameter");
                $("#failedModalBody").empty().append("Parameter ID not found");
                $('#failedToModal').modal('show');
            <?php
                break;
            case ("no image found"):
            ?>
                $("#failedModalHeadline").empty().append("Failed to Edit Parameter");
                $("#failedModalBody").empty().append("Image not found");
                $('#failedToModal').modal('show');
        <?php
                break;
        }
        ?>
    <?php } ?>

    <?php
    if (isset($_GET['success'])) {
        switch ($_GET['success']) {
            case ("parameter added"):
    ?>
                $("#successModalHeadline").empty().append("Parameter Added");
                $("#successModalBody").empty().append("A parameter is successfully added.");
                $('#successToModal').modal('show')
            <?php
                break;
            case ("parameter edited"):
            ?>
                $("#successModalHeadline").empty().append("Parameter Edited");
                $("#successModalBody").empty().append("A parameter is successfully edited.");
                $('#successToModal').modal('show')
            <?php
                break;
            case ("parameter deleted"):
            ?>
                $("#successModalHeadline").empty().append("Parameter Deleted");
                $("#successModalBody").empty().append("A parameter is successfully deleted.");
                $('#successToModal').modal('show')
        <?php
                break;
        }
        ?>

    <?php } ?>
</script>

</html>