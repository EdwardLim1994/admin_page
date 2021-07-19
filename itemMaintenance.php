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
    <title>Item Maintanance</title>

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
    <script src="./dist/js/itemMaintenance.prod.js"></script>
    <script src="./dist/js/datatables.min.js"></script>

    <!-- <script src="./itemMaintenance.js"></script> -->


</head>

<body>
    <header>
        <div class="blue">
            <div class="container-fluid">
                <div class="py-2 row">
                    <div class="my-auto col-4 ">

                    </div>
                    <div class="my-auto text-center col-4">
                        <a href="https://nightcatdigitalsolutions.com/avenger/menu.php">
                            <img class="rounded img-fluid logo hoverable" src="./assets/titleImage.jpeg" alt="Title Image">
                        </a>
                    </div>
                    <div class="my-auto text-right col-4">
                        <button class="px-3 py-2 btn btn-primary px-sm-4 py-sm-3 dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <ol class="pl-0 breadcrumb white">
                        <li class="breadcrumb-item"><a href="./menu.php">Menu</a></li>
                        <li class="breadcrumb-item active">Item Maintanance</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-lg-10 col-md-8 col-sm-6">
                        <h1 class="h1-responsive">Item Maintanance</h1>
                    </div>
                    <div class="text-right col-lg-2 col-md-4 col-sm-6">
                        <button class="btn btn-danger py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#addModal">
                            <span class="textBreak">Add Item</span>
                            <span class="iconBreak"><i class="fas fa-user-plus"></i></span>
                        </button>
                    </div>
                </div>
                <div class="py-3 row">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="item-tab" data-toggle="tab" href="#item" role="tab" aria-controls="item" aria-selected="true">Item</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="false">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="vendor-tab" data-toggle="tab" href="#vendor" role="tab" aria-controls="vendor" aria-selected="false">Vendor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="picture-tab" data-toggle="tab" href="#picture" role="tab" aria-controls="picture" aria-selected="false">Picture</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="plu-tab" data-toggle="tab" href="#plu" role="tab" aria-controls="plu" aria-selected="false">PLU</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="others-tab" data-toggle="tab" href="#others" role="tab" aria-controls="others" aria-selected="false">Others</a>
                        </li>
                    </ul>

                </div>

                <div class="row">
                    <div class="pt-2 col-12">
                        <div id="search-input-wrapper">
                            <h6>Searching: <span id="search-input"></span></h6>
                        </div>
                    </div>
                </div>
                <div class="row w-100">
                    <div class="col-12 col-lg-6">
                        <div class="pl-0 input-group md-form form-sm form-2">
                            <input id="searchRow" class="py-1 my-0 form-control" type="text" placeholder="Search" aria-label="Search" value="<?= isset($_SESSION['searchTerm']) ? $_SESSION['searchTerm'] : "" ?>">
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
                        <div class="py-4 d-flex justify-content-end rowResults">
                            
                            <h6 class="my-auto">Total rows in database: <span class="font-weight-bold" id="rowTotal"></span></h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"></div>
                    <div class="flex-row py-3 col-4 d-flex justify-content-end">
                        <div class="pageWrapper">
                            <h5>Page : </h5>
                            <input type="number" id="currentPageNum" class="form-control pageNumInput" min="1" value="<?= isset($_SESSION['currPage']) ? $_SESSION['currPage'] : 1 ?>">
                            <h5> of <span id="pageTotal"></span></h5>
                        </div>

                    </div>
                </div>
                 <div class="row">
                    <div class="tab-content w-100" id="myTabContent">
                        <div class="tab-pane fade show active" id="item" role="tabpanel" aria-labelledby="item-tab">
                            <div id="item-table" class='table-responsive'>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div id="general-table" class='table-responsive'>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="vendor" role="tabpanel" aria-labelledby="vendor-tab">
                            <div id="vendor-table" class='table-responsive'>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="picture" role="tabpanel" aria-labelledby="picture-tab">
                            <div id="picture-table" class='table-responsive'>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="plu" role="tabpanel" aria-labelledby="plu-tab">
                            <div id="plu-table" class='table-responsive'>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
                            <div id="others-table" class='table-responsive'>

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

                <form action="./backend/item/item.php" enctype="multipart/form-data" method="POST">
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
                            <div class="py-3 row">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="add-item-tab" data-toggle="tab" href="#add-item" role="tab" aria-controls="add-item" aria-selected="true">Item</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="add-general-tab" data-toggle="tab" href="#add-general" role="tab" aria-controls="add-general" aria-selected="false">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="add-vendor-tab" data-toggle="tab" href="#add-vendor" role="tab" aria-controls="add-vendor" aria-selected="false">Vendor</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="add-picture-tab" data-toggle="tab" href="#add-picture" role="tab" aria-controls="add-picture" aria-selected="false">Picture</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="add-plu-tab" data-toggle="tab" href="#add-plu" role="tab" aria-controls="add-plu" aria-selected="false">PLU</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="add-others-tab" data-toggle="tab" href="#add-others" role="tab" aria-controls="add-others" aria-selected="false">Others</a>
                                    </li>
                                </ul>

                            </div>
                            <div class="tab-content w-100" id="myTabContent">
                                <div class="tab-pane fade show active" id="add-item" role="tabpanel" aria-labelledby="add-item-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-item-no">Item no</label>
                                                <input type="text" class="form-control" name="item_no" id="add-item-no" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="add-doc-key">Doc key</label>
                                                <input type="text" class="form-control" name="doc_key" id="add-doc-key" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-description">Description</label>
                                                <input type="text" class="form-control" name="description" id="add-description" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-description2">Description 2</label>
                                                <input type="text" class="form-control" name="description2" id="add-description2" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-description3">Description 3</label>
                                                <input type="text" class="form-control" name="description3" id="add-description3" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="add-selling-price1">Selling Price</label>
                                                <input type="text" class="form-control" name="selling_price1" id="add-selling-price1" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="add-master-vendor">Master Vendor</label>
                                                <input type="text" class="form-control" name="master_vendor" id="add-master-vendor" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-vendor-item">Vendor Item</label>
                                                <input type="text" class="form-control" name="vendor_item" id="add-vendor-item" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="add-item-type">Item Type</label>
                                                <input type="text" class="form-control" name="item_type" id="add-item-type" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-category">Category</label>
                                                <input type="text" class="form-control" name="category" id="add-category" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-item-group">Item Group</label>
                                                <input type="text" class="form-control" name="item_group" id="add-item-group" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="add-general" role="tabpanel" aria-labelledby="add-general-tab">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-unit-cost">Unit Cost</label>
                                                <input type="number" min="0.01" step="0.01" class="form-control" name="unit_cost" id="add-unit-cost" placeholder="">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="add-qty-hand">Qty On Hand</label>
                                                <input type="text" class="form-control" name="qty_hand" id="add-qty-hand" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-qty-hold">Qty On Hold</label>
                                                <input type="text" class="form-control" name="qty_hold" id="add-qty-hold" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="add-qty-available">Qty Available</label>
                                                <input type="text" class="form-control" name="qty_available" id="add-qty-available" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-qty-reorder-available">Qty Reorder Available</label>
                                                <input type="text" class="form-control" name="qty_reorder_available" id="add-qty-reorder-available" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="add-qty-max">Qty Max</label>
                                                <input type="text" class="form-control" name="qty_max" id="add-qty-max" placeholder="">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="add-vendor" role="tabpanel" aria-labelledby="add-vendor-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="add-vendor">Vendor</label>
                                                <input type="text" class="form-control" name="vendor" id="add-vendor" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="add-vendor-company">Vendor Company</label>
                                                <input type="text" class="form-control" name="vendor_company" id="add-vendor-company" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- |vendor|varchar(50)|Yes|NULL
                                    |vendor_company|varchar(50)|Yes|NULL -->
                                </div>
                                <div class="tab-pane fade" id="add-picture" role="tabpanel" aria-labelledby="add-picture-tab">
                                    <!-- |item_picture|longtext|Yes|NULL -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <p>Item Picture</p>
                                                    <div class="custom-file">
                                                    
                                                    <label class="custom-file-label" for="add-item-picture">Choose file</label>
                                                    <input type="file" class="custom-file-input" name="imgUpload" id="add-item-picture" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="add-plu" role="tabpanel" aria-labelledby="add-plu-tab">
                                    <!-- |plu|varchar(255)|No| -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="add-plu">PLU</label>
                                                <input type="text" class="form-control" name="plu" id="add-plu" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="add-others" role="tabpanel" aria-labelledby="add-others-tab">

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
                <form action="./backend/item/item.php" enctype="multipart/form-data" method="POST">
                    <!--Header-->
                    <input hidden="true" type="text" name="postType" value="update">
                    <input hidden="true" type="number" name="item_id" id="edit_id">
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
                            <div class="py-3 row">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="edit-item-tab" data-toggle="tab" href="#edit-item" role="tab" aria-controls="edit-item" aria-selected="true">Item</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="edit-general-tab" data-toggle="tab" href="#edit-general" role="tab" aria-controls="edit-general" aria-selected="false">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="edit-vendor-tab" data-toggle="tab" href="#edit-vendor" role="tab" aria-controls="edit-vendor" aria-selected="false">Vendor</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="edit-picture-tab" data-toggle="tab" href="#edit-picture" role="tab" aria-controls="edit-picture" aria-selected="false">Picture</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="edit-plu-tab" data-toggle="tab" href="#edit-plu" role="tab" aria-controls="edit-plu" aria-selected="false">PLU</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="edit-others-tab" data-toggle="tab" href="#edit-others" role="tab" aria-controls="edit-others" aria-selected="false">Others</a>
                                    </li>
                                </ul>

                            </div>
                            <div class="tab-content w-100" id="myTabContent">
                                <div class="tab-pane fade show active" id="edit-item" role="tabpanel" aria-labelledby="edit-item-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-item-no">Item no</label>
                                                <input type="text" class="form-control" name="item_no" id="edit-item-no" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="edit-doc-key">Doc key</label>
                                                <input type="text" class="form-control" name="doc_key" id="edit-doc-key" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-description">Description</label>
                                                <input type="text" class="form-control" name="description" id="edit-description" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-description2">Description 2</label>
                                                <input type="text" class="form-control" name="description2" id="edit-description2" placeholder="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-description3">Description 3</label>
                                                <input type="text" class="form-control" name="description3" id="edit-description3" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-selling-price1">Selling Price</label>
                                                <input type="text" class="form-control" name="selling_price1" id="edit-selling-price1" placeholder="">
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="edit-master-vendor">Master Vendor</label>
                                                <input type="text" class="form-control" name="master_vendor" id="edit-master-vendor" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-vendor-item">Vendor Item</label>
                                                <input type="text" class="form-control" name="vendor_item" id="edit-vendor-item" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-item-type">Item Type</label>
                                                <input type="text" class="form-control" name="item_type" id="edit-item-type"placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-category">Category</label>
                                                <input type="text" class="form-control" name="category" id="edit-category" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-item-group">Item Group</label>
                                                <input type="text" class="form-control" name="item_group" id="edit-item-group" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="edit-general" role="tabpanel" aria-labelledby="edit-general-tab">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-unit-cost">Unit Cost</label>
                                                <input type="text" class="form-control" name="unit_cost" id="edit-unit-cost" placeholder="">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-qty-hand">Qty On Hand</label>
                                                <input type="text" class="form-control" name="qty_hand" id="edit-qty-hand" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-qty-hold">Qty On Hold</label>
                                                <input type="text" class="form-control" name="qty_hold" id="edit-qty-hold" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-qty-available">Qty Available</label>
                                                <input type="text" class="form-control" name="qty_available" id="edit-qty-available" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-qty-reorder-available">Qty Reorder Qvailable</label>
                                                <input type="text" class="form-control" name="qty_reorder_available" id="edit-qty-reorder-available" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="edit-qty-max">Qty Max</label>
                                                <input type="text" class="form-control" name="qty_max" id="edit-qty-max" placeholder="">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="edit-vendor" role="tabpanel" aria-labelledby="edit-vendor-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="edit-vendor">Vendor</label>
                                                <input type="text" class="form-control" name="vendor" id="edit-vendor-name" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="edit-vendor-company">Vendor Company</label>
                                                <input type="text" class="form-control" name="vendor_company" id="edit-vendor-company"placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- |vendor|varchar(50)|Yes|NULL
                                    |vendor_company|varchar(50)|Yes|NULL -->
                                </div>
                                <div class="tab-pane fade" id="edit-picture" role="tabpanel" aria-labelledby="edit-picture-tab">
                                    <!-- |item_picture|longtext|Yes|NULL -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <p>Item Picture</p>
                                                <div class="custom-file">
                                                    <label class="custom-file-label" for="edit-item-picture">Choose file</label>
                                                    <input type="file" class="custom-file-input" name="imgUpload" id="edit-item-picture" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="edit-plu" role="tabpanel" aria-labelledby="edit-plu-tab">
                                    <!-- |plu|varchar(255)|No| -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-plu">PLU</label>
                                                <input type="text" class="form-control" name="plu" id="edit-plu-item" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="edit-others" role="tabpanel" aria-labelledby="edit-others-tab">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="edit-info1">Info</label>
                                                <input type="text" class="form-control" name="info1" id="edit-info1" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-info2">Info 2</label>
                                                <input type="text" class="form-control" name="info2" id="edit-info2" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info3">Info 3</label>
                                                <input type="text" class="form-control" name="info3" id="edit-info3" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info4">Info 4</label>
                                                <input type="text" class="form-control" name="info4" id="edit-info4" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-info5">Info 5</label>
                                                <input type="text" class="form-control" name="info5" id="edit-info5" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info6">Info 6</label>
                                                <input type="text" class="form-control" name="info6" id="edit-info6" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info7">Info 7</label>
                                                <input type="text" class="form-control" name="info7" id="edit-info7" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label for="edit-info8">Info 8</label>
                                                <input type="text" class="form-control" name="info8" id="edit-info8" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info9">Info 9</label>
                                                <input type="text" class="form-control" name="info9" id="edit-info9" placeholder="">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label for="edit-info10">Info 10</label>
                                                <input type="text" class="form-control" name="info10" id="edit-info10" placeholder="">
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
                <form action="./backend/item/item.php"  method="POST">
                    <!--Header-->
                    <input hidden="true" type="text" name="postType" value="delete">
                    <input hidden="true" type="number" name="item_id" id="delete_id">
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
                            <p>Are you want to delete <span id="deleteItemName"></span>?</p>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="deleteItemSubmitButton" class="btn btn-warning">Yes</button>
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

    <footer class="page-footer font-small blue">
        <div class="text-center col-md-12">

            <!-- Social Link on Bottom -->
            <div class="pt-4 mb-4 flex-center">
                <a class="whatsappLink">
                    <i class="mr-3 fab fa-whatsapp a-lg mr-md-5 fa-2x hoverable"></i>
                </a>
                <!-- Facebook -->
                <a class="fb-ic" href="https://www.facebook.com/nightcatdigitalsolutions">
                    <i class="mr-3 fab fa-facebook fa-lg mr-md-5 fa-2x hoverable"> </i>
                </a>
                <!-- Twitter -->
                <a class="tw-ic" href="https://twitter.com/nightcatdigital">
                    <i class="mr-3 fab fa-twitter fa-lg mr-md-5 fa-2x hoverable"> </i>
                </a>
                <!--Instagram-->
                <a class="ins-ic" href="https://www.instagram.com/nightcatdigitalsolutions/">
                    <i class="mr-3 fab fa-instagram fa-lg mr-md-5 fa-2x hoverable"> </i>
                </a>
            </div>
        </div>
        <div class="py-3 text-center footer-copyright">
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