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
    <title>Customer Maintanance</title>

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
    <script src="./dist/js/customerMaintenance.prod.js"></script>
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
                        <li class="breadcrumb-item active">Customer Maintanance</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-lg-10 col-md-8 col-sm-6">
                        <h1 class="h1-responsive">Customer Maintanance</h1>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 text-right">
                        <button class="btn btn-danger py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#addModal">
                            <span class="textBreak">Add Customer</span>
                            <span class="iconBreak"><i class="fas fa-user-plus"></i></span>
                        </button>
                    </div>
                </div>
                <div class="row py-3">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="additionalinfo-tab" data-toggle="tab" href="#additionalinfo" role="tab" aria-controls="additionalinfo" aria-selected="false">Additional Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="accounting-tab" data-toggle="tab" href="#accounting" role="tab" aria-controls="accounting" aria-selected="false">Accounting</a>
                        </li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-12 pt-2">
                        <div id="search-input-wrapper">
                            <h6>Searching: <span id="search-input"></span></h6>
                        </div>
                    </div>
                </div>
                <div class="row w-100">
                    <div class="col-12 col-lg-6">
                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input id="searchRow" class="form-control my-0 py-1" type="text" placeholder="Search" aria-label="Search" value="<?= isset($_SESSION['searchTerm']) ? $_SESSION['searchTerm'] : "" ?>">
                            <div class="input-group-append" id="searchClear">
                                <button class="input-group-text lighten-2">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="input-group-append">
                                <button class="input-group-text lighten-2" id="searchConfirm">
                                    <span class="textBreak">Search</span>
                                    <span class="iconBreak"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-flex justify-content-end py-4 rowResults">
                            
                            <h6 class="my-auto">Total rows in database: <span class="font-weight-bold" id="rowTotal"></span></h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 "></div>
                    <div class="col-12 col-md-6 py-3 d-flex flex-row justify-content-end">
                        <div class="pageWrapper">
                            <h5>Page : </h5>
                            <input type="number" id="currentPageNum" class="form-control pageNumInput" min="1" value="<?= isset($_SESSION['currPage']) ? $_SESSION['currPage'] : 1 ?>">
                            <h5> of <span id="pageTotal"></span></h5>
                        </div>

                    </div>
                </div>
                 <div class="row">
                    <div class="tab-content w-100" id="myTabContent">
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div id="general-table" class='table-responsive'>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="additionalinfo" role="tabpanel" aria-labelledby="additionalinfo-tab">
                            <div id="additionalinfo-table" class='table-responsive'>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="accounting" role="tabpanel" aria-labelledby="accounting-tab">
                            <div id="accounting-table" class='table-responsive'>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Central Modal Medium Info -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
                <div class="modal-content">

                <form action="./backend/customer/customer.php" enctype="multipart/form-data" method="POST">
                        <!--Header-->
                        <input hidden="true" type="text" name="postType" value="add">
                        <div class="modal-header">
                            <p class="heading lead">Add Item</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</spans>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="add-customer_account">Customer Account</label>
                                        <input type="text" class="form-control" name="customer_account" id="add-customer_account" placeholder="">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="add-outstanding">Outstanding</label>
                                        <input type="text" class="form-control" name="outstanding" id="add-outstanding" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="add-name">Name</label>
                                        <input type="text" class="form-control" name="name" id="add-name" placeholder="">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="add-points">Points</label>
                                        <input type="text" class="form-control" name="points" id="add-points" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="add-reg_num">Reg Name</label>
                                        <input type="text" class="form-control" name="reg_num" id="add-reg_num" placeholder="">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="add-status">Status</label>
                                        <input type="text" class="form-control" name="status" id="add-status" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="add-general-tab" data-toggle="tab" href="#add-general" role="tab" aria-controls="add-general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="add-additionalinfo-tab" data-toggle="tab" href="#add-additionalinfo" role="tab" aria-controls="add-additionalinfo" aria-selected="false">Additional Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="add-accounting-tab" data-toggle="tab" href="#add-accounting" role="tab" aria-controls="add-accounting" aria-selected="false">Accounting</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content w-100" id="myTabContent">
                                <div class="tab-pane fade show active" id="add-general" role="tabpanel" aria-labelledby="add-general-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-address">Address</label>
                                                <textarea class="form-control" name="address" id="add-address" rows="3" style="resize:none;" placeholder=""></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-postcode">Postcode</label>
                                                <input type="text" class="form-control" name="postcode" id="add-postcode" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-city">City</label>
                                                <input type="text" class="form-control" name="city" id="add-city" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-state">State</label>
                                                <input type="text" class="form-control" name="state" id="add-state" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-country">Country</label>
                                                <input type="text" class="form-control" name="country" id="add-country" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-salutation">Salutation</label>
                                                <input type="text" class="form-control" name="salutation" id="add-salutation" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-attention">Attention</label>
                                                <input type="text" class="form-control" name="attention" id="add-attention" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-email">Email</label>
                                                <input type="text" class="form-control" name="email" id="add-email" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-website">Website</label>
                                                <input type="text" class="form-control" name="website" id="add-website" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-biz_nature">Biz Nature</label>
                                                <input type="text" class="form-control" name="biz_nature" id="add-biz_nature" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-salesperson">Sales Person</label>
                                                <input type="text" class="form-control" name="salesperson" id="add-salesperson" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-reg_date">Reg Date</label>
                                                <input type="text" class="form-control" name="reg_date" id="add-reg_date" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-introducer">Introducer</label>
                                                <input type="text" class="form-control" name="introducer" id="add-introducer" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-expiry_date">Expiry Date</label>
                                                <input type="text" class="form-control" name="expiry_date" id="add-expiry_date" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-category">Category</label>
                                                <input type="text" class="form-control" name="category" id="add-category" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-telephone1">Telephone 1</label>
                                                <input type="text" class="form-control" name="telephone1" id="add-telephone1" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-nric">NRIC</label>
                                                <input type="text" class="form-control" name="nric" id="add-nric" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-telephone2">Telephone 2</label>
                                                <input type="text" class="form-control" name="telephone2" id="add-telephone2" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-gender">Gender</label>
                                                <input type="text" class="form-control" name="gender" id="add-gender" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-fax">Fax</label>
                                                <input type="text" class="form-control" name="fax" id="add-fax" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-dob">DOB</label>
                                                <input type="text" class="form-control" name="dob" id="add-dob" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-handphone">Handphone</label>
                                                <input type="text" class="form-control" name="handphone" id="add-handphone" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-race">Race</label>
                                                <input type="text" class="form-control" name="race" id="add-race" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-skype">Skype</label>
                                                <input type="text" class="form-control" name="skype" id="add-skype" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-religion">Religion</label>
                                                <input type="text" class="form-control" name="religion" id="add-religion" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="add-additionalinfo" role="tabpanel" aria-labelledby="add-additionalinfo-tab">
                                <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-info1">Info 1</label>
                                                <input type="text" class="form-control" id="add-info1" name="info1" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="add-info2">Info 2</label>
                                                <input type="text" class="form-control" id="add-info2" name="info2" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-info3">Info 3</label>
                                                <input type="text" class="form-control" id="add-info3" name="info3" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-info4">Info 4</label>
                                                <input type="text" class="form-control" id="add-info4" name="info4" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="add-info5">Info 5</label>
                                                <input type="text" class="form-control" id="add-info5" name="info5" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-info6">Info 6</label>
                                                <input type="text" class="form-control" id="add-info6" name="info6" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-info7">Info 7</label>
                                                <input type="text" class="form-control" id="add-info7" name="info7" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="add-info8">Info 8</label>
                                                <input type="text" class="form-control" id="add-info8" name="info8" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-info9">Info 9</label>
                                                <input type="text" class="form-control" id="add-info9" name="info9" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-info10">Info 10</label>
                                                <input type="text" class="form-control" id="add-info10" name="info10" placeholder="">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="add-accounting" role="tabpanel" aria-labelledby="add-accounting-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-control_ac">Control A/C</label>
                                                <input type="text" class="form-control" name="control_ac" id="add-control_ac" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="add-accounting_account">Accounting Account</label>
                                                <input type="text" class="form-control" name="accounting_account" id="add-accounting_account" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="addItemSubmitBtn" class="btn btn-info">Add Item</button>
                            <a type="button" class="btn btn-outline-info waves-effect nevermind" data-dismiss="modal">Nevermind</a>
                        </div>
                    </form>
                </div>

                <!-- </form> -->
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Medium Info-->

        <!-- Central Modal Medium Info -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
                <!--Content-->
                <form action="./backend/customer/customer.php" enctype="multipart/form-data" method="POST">
                    <!--Header-->
                    <input hidden="true" type="text" name="postType" value="update">
                    <input hidden="true" type="number" name="customer_id" id="edit_id">
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading lead">Edit Item</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="edit-customer_account">Customer Account</label>
                                        <input type="text" class="form-control" name="customer_account" id="edit-customer_account" placeholder="">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="edit-outstanding">Outstanding</label>
                                        <input type="text" class="form-control" name="outstanding" id="edit-outstanding" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="edit-name">Name</label>
                                        <input type="text" class="form-control" name="name" id="edit-name" placeholder="">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="edit-points">Points</label>
                                        <input type="text" class="form-control" name="points" id="edit-points" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="edit-reg_num">Reg Number</label>
                                        <input type="text" class="form-control" name="reg_num" id="edit-reg_num" placeholder="">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="edit-status">Status</label>
                                        <input type="text" class="form-control" name="status" id="edit-status" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="edit-general-tab" data-toggle="tab" href="#edit-general" role="tab" aria-controls="edit-general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="edit-additionalinfo-tab" data-toggle="tab" href="#edit-additionalinfo" role="tab" aria-controls="edit-additionalinfo" aria-selected="false">Additional Info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="edit-accounting-tab" data-toggle="tab" href="#edit-accounting" role="tab" aria-controls="edit-accounting" aria-selected="false">Accounting</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content w-100" id="myTabContent">
                                <div class="tab-pane fade show active" id="edit-general" role="tabpanel" aria-labelledby="edit-general-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-address">Address</label>
                                                <textarea class="form-control" name="address" id="edit-address" rows="3" style="resize:none;" placeholder=""></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-postcode">Postcode</label>
                                                <input type="text" class="form-control" name="postcode" id="edit-postcode" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-city">City</label>
                                                <input type="text" class="form-control" name="city" id="edit-city" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-state">State</label>
                                                <input type="text" class="form-control" name="state" id="edit-state" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-country">Country</label>
                                                <input type="text" class="form-control" name="country" id="edit-country" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-salutation">Salutation</label>
                                                <input type="text" class="form-control" name="salutation" id="edit-salutation" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-attention">Attention</label>
                                                <input type="text" class="form-control" name="attention" id="edit-attention" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-email">Email</label>
                                                <input type="text" class="form-control" name="email" id="edit-email" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-website">Website</label>
                                                <input type="text" class="form-control" name="website" id="edit-website" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-biz_nature">Biz Nature</label>
                                                <input type="text" class="form-control" name="biz_nature" id="edit-biz_nature" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-salesperson">Sales Person</label>
                                                <input type="text" class="form-control" name="salesperson" id="edit-salesperson" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-reg_date">Reg Date</label>
                                                <input type="text" class="form-control" name="reg_date" id="edit-reg_date" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-introducer">Introducer</label>
                                                <input type="text" class="form-control" name="introducer" id="edit-introducer" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-expiry_date">Expiry Date</label>
                                                <input type="text" class="form-control" name="expiry_date" id="edit-expiry_date" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-category">Category</label>
                                                <input type="text" class="form-control" name="category" id="edit-category" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-telephone1">Telephone 1</label>
                                                <input type="text" class="form-control" name="telephone1" id="edit-telephone1" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-nric">NRIC</label>
                                                <input type="text" class="form-control" name="nric" id="edit-nric" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-telephone2">Telephone 2</label>
                                                <input type="text" class="form-control" name="telephone2" id="edit-telephone2" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-gender">Gender</label>
                                                <input type="text" class="form-control" name="gender" id="edit-gender" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-fax">Fax</label>
                                                <input type="text" class="form-control" name="fax" id="edit-fax" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-dob">DOB</label>
                                                <input type="text" class="form-control" name="dob" id="edit-dob" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-handphone">Handphone</label>
                                                <input type="text" class="form-control" name="handphone" id="edit-handphone" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-race">Race</label>
                                                <input type="text" class="form-control" name="race" id="edit-race" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-skype">Skype</label>
                                                <input type="text" class="form-control" name="skype" id="edit-skype" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-religion">Religion</label>
                                                <input type="text" class="form-control" name="religion" id="edit-religion" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="edit-additionalinfo" role="tabpanel" aria-labelledby="edit-additionalinfo-tab">
                                <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-info1">Info 1</label>
                                                <input type="text" class="form-control" id="edit-info1" name="info1" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-info2">Info 2</label>
                                                <input type="text" class="form-control" id="edit-info2" name="info2" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info3">Info 3</label>
                                                <input type="text" class="form-control" id="edit-info3" name="info3" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info4">Info 4</label>
                                                <input type="text" class="form-control" id="edit-info4" name="info4" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-info5">Info 5</label>
                                                <input type="text" class="form-control" id="edit-info5" name="info5" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info6">Info 6</label>
                                                <input type="text" class="form-control" id="edit-info6" name="info6" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info7">Info 7</label>
                                                <input type="text" class="form-control" id="edit-info7" name="info7" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-info8">Info 8</label>
                                                <input type="text" class="form-control" id="edit-info8" name="info8" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info9">Info 9</label>
                                                <input type="text" class="form-control" id="edit-info9" name="info9" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info10">Info 10</label>
                                                <input type="text" class="form-control" id="edit-info10" name="info10" placeholder="">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="edit-accounting" role="tabpanel" aria-labelledby="edit-accounting-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-control_ac">Control A/C</label>
                                                <input type="text" class="form-control" name="control_ac" id="edit-control_ac" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="edit-accounting_account">Accounting Account</label>
                                                <input type="text" class="form-control" name="accounting_account" id="edit-accounting_account" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="editItemSubmitButton" class="btn btn-info">Edit Item</button>
                            <a type="button" class="btn btn-outline-info waves-effect nevermind" data-dismiss="modal">Nevermind</a>
                        </div>
                    </div>
                </form>
                <!-- </form> -->
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Medium Info-->

        <!-- Central Modal Warning Demo-->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <form action="./backend/customer/customer.php"  method="POST">
                    <!--Header-->
                    <input hidden="true" type="text" name="postType" value="delete">
                    <input hidden="true" type="number" name="customer_id" id="delete_id">
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading">Delete Customer</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">
                            <p>Are you want to delete <span id="deleteCustomerName"></span>?</p>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="deleteCsutomerSubmitButton" class="btn btn-warning">Yes</button>
                            <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Nevermind</a>
                        </div>
                    </div>
                </form>
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
    $(document).ready(function() {
        <?php if (isset($_GET["success"])) : ?>

            successMessage("Success", "<?= $_GET['success'] ?>");

            function successMessage(headline, body) {
                $("#successToModal").modal("show");
                $("#successModalHeadline").empty().append(headline);
                $("#successModalBody").empty().append(body);

            }

        <?php endif; ?>

        <?php if (isset($_GET["failed"])) : ?>

            failedMessage("Failed", "<?= $_GET['failed'] ?>");

            function failedMessage(headline, body) {
                $("#failedToModal").modal("show");
                $("#failedModalHeadline").empty().append(headline);
                $("#failedModalBody").empty().append(body);
            }
        <?php endif; ?>

    });
</script>

</html>