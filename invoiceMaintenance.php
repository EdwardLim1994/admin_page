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
    <title>Invoice Maintanance</title>

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
    <script src="./dist/js/invoiceMaintenance.prod.js"></script> 
    <script src="./dist/js/datatables.min.js"></script>
<!-- 
    <script src="./invoiceMaintenance.js"></script> -->

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
                        <li class="breadcrumb-item active">Invoice Maintanance</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-lg-10 col-md-8 col-sm-6">
                        <h1 class="h1-responsive">Invoice Maintanance</h1>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 text-right">
                        <button id="addModalBtn" class="btn btn-danger py-md-3 px-md-4 p-sm-3" data-toggle="modal" data-target="#addModal">
                            <span class="textBreak">Add Invoice</span>
                            <span class="iconBreak"><i class="fas fa-file-invoice"></i></span>
                        </button>
                    </div>
                </div>


                <!-- <div class="row">
                    <div class="col-12 pt-2">
                        <div id="search-input-wrapper">
                            <h6>Searching: <span id="search-input"></span></h6>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <!-- <div class="col-12 col-lg-6">
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
                    </div> -->
                    <div class="col-12 text-right">
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
                <div id="general-table" class='table-responsive'></div>
            </div>
        </div>
        </div>
        <!-- Central Modal Medium Info -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
                <div class="modal-content">
                    <div class="bg-white sticky-top p-0 m-0 border-bottom">
                        <!--Header-->
                        
                        <div class="modal-header">
                            <p class="heading lead">Add Invoice</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</spans>
                            </button>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-end">
                            <button id="addInvoiceSubmitBtn" class="btn btn-info">Add Invoice</button>
                            <!-- <a type="button" class="btn btn-outline-info waves-effect nevermind" data-dismiss="modal">Nevermind</a> -->
                        </div>
                    </div>


                    <!--Body-->
                    <div class="modal-body">
                        <div class="form-group position-relative">
                            <div class="row">
                                <div class="col-6">
                                    <label for="edit-customer_name">Customer Name</label>
                                    <input type="text" autocomplete="off" class="form-control" name="customer_account" id="search-customer_name" placeholder="">
                                </div>
                                <div class="col-6">
                                    <label for="edit-customer_account">Account Number</label>
                                    <input type="text" autocomplete="off" class="form-control" name="customer_account" id="search-customer_id" placeholder="">
                                </div>
                            </div>

                            <!-- Customer search result -->
                            <div id="customer-search" class="w-100 m-0 bg-white position-absolute" style="z-index:5;"></div>
                        </div>
                        <hr>
                        <div class="form-group">

                            <h3>Receive Information</h3>
                            <div class="row">
                                <div class="col-6">
                                    <label for="edit-customer_account">Invoice No:</label>
                                    <input type="text" class="form-control" name="customer_account" id="invoice_number" placeholder="">

                                </div>

                                <div class="col-6">
                                    <label for="edit-customer_account">Doc No:</label>
                                    <input type="text" class="form-control" name="customer_account" id="doc_no" placeholder="">

                                </div>
                            </div>
                            <div class="row">

                                <div class="col-6">
                                    <label for="edit-customer_account">Invoice Date:</label>
                                    <input type="date" class="form-control" name="customer_account" id="invoice_date" placeholder="">

                                </div>
                                <div class="col-6">
                                    <label for="edit-customer_account">Due Date:</label>
                                    <input type="date" class="form-control" name="customer_account" id="due_date" placeholder="">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="edit-customer_account">Remark:</label>
                                    <input type="text" class="form-control" name="customer_account" id="invoice_remark" placeholder="">

                                </div>
                            </div>
                        </div>
                        <div class="form-group ">

                            <h3>Item Information</h3>

                            <div class="row pb-5 ">
                                <div class="col-12">
                                    <div class="position-relative">
                                        <label for="edit-customer_account">Item Name or Barcode:</label>
                                        <input type="text" class="form-control" id="search-item" placeholder="">

                                        <!-- Item search result -->
                                        <div id="item-search" class="w-100 m-0 bg-white position-absolute" style="z-index:5;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="grey white-text">
                                        <tr>
                                            <th class="th-sm text-center">Action</th>
                                            <th class="th-sm text-center">Barcode
                                            </th>
                                            <th class="th-sm text-center">Description
                                            </th>
                                            <th class="th-sm text-center">Qty
                                            </th>
                                            <th class="th-sm text-center">UOM
                                            </th>
                                            <th class="th-sm text-center">Selling Price(RM)
                                            </th>
                                            <th class="th-sm text-center">Base Cost(RM)
                                            </th>
                                            <th class="th-sm text-center">Discount(%)
                                            </th>
                                            <th class="th-sm text-center">Amount(RM)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="item-bucket">
                                        <tr class="noResultText">
                                            <td colspan="9" class="text-center">
                                                <h5>No item added yet</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="grey white-text">
                                        <tr>
                                            <th colspan="8" class="text-right"><strong>Discount : </strong></th>
                                            <th id="total_discount"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="8" class="text-right"><strong>Total Amount : </strong></th>
                                            <th id="total_cost"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-notify modal-info" role="document">
                <!--Content-->
                <input hidden="true" type="text" id="update-invoice_id">
                <div class="modal-content">
                    <div class="bg-white sticky-top p-0 m-0 border-bottom">
                        <!--Header-->
                        <input hidden="true" type="text" name="postType" value="add">
                        <div class="modal-header">
                            <p class="heading lead">Update Invoice</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</spans>
                            </button>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-end">
                            <button id="updateInvoiceSubmitBtn" class="btn btn-info">Update Invoice</button>
                            <!-- <a type="button" class="btn btn-outline-info waves-effect nevermind" data-dismiss="modal">Nevermind</a> -->
                        </div>
                    </div>


                    <!--Body-->
                    <div class="modal-body">
                        <div class="form-group position-relative">
                            <div class="row">
                                <div class="col-6">
                                    <label for="edit-customer_name">Customer Name</label>
                                    <input type="text" autocomplete="off" class="form-control" name="customer_account" id="update-search-customer_name" placeholder="">
                                </div>
                                <div class="col-6">
                                    <label for="edit-customer_account">Account Number</label>
                                    <input type="text" autocomplete="off" class="form-control" name="customer_account" id="update-search-customer_id" placeholder="">
                                </div>
                            </div>

                            <!-- Customer search result -->
                            <div id="update-customer-search" class="w-100 m-0 bg-white position-absolute" style="z-index:5;"></div>
                        </div>
                        <hr>
                        <div class="form-group">

                            <h3>Receive Information</h3>
                            <div class="row">
                                <div class="col-6">
                                    <label for="edit-customer_account">Invoice No:</label>
                                    <input type="text" class="form-control" name="customer_account" id="update-invoice_number" placeholder="">

                                </div>

                                <div class="col-6">
                                    <label for="edit-customer_account">Doc No:</label>
                                    <input type="text" class="form-control" name="customer_account" id="update-doc_no" placeholder="">

                                </div>
                            </div>
                            <div class="row">

                                <div class="col-6">
                                    <label for="edit-customer_account">Invoice Date:</label>
                                    <input type="date" class="form-control" name="customer_account" id="update-invoice_date" placeholder="">

                                </div>
                                <div class="col-6">
                                    <label for="edit-customer_account">Due Date:</label>
                                    <input type="date" class="form-control" name="customer_account" id="update-due_date" placeholder="">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="edit-customer_account">Remark:</label>
                                    <input type="text" class="form-control" name="customer_account" id="update-invoice_remark" placeholder="">

                                </div>
                            </div>
                        </div>
                        <div class="form-group ">

                            <h3>Item Information</h3>

                            <div class="row pb-5 ">
                                <div class="col-12">
                                    <div class="position-relative">
                                        <label for="edit-customer_account">Item Name or Barcode:</label>
                                        <input type="text" class="form-control" id="update-search-item" placeholder="">

                                        <!-- Item search result -->
                                        <div id="update-item-search" class="w-100 m-0 bg-white position-absolute" style="z-index:5;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead class="grey white-text">
                                        <tr>
                                            <th class="th-sm text-center">Action</th>
                                            <th class="th-sm text-center">Barcode
                                            </th>
                                            <th class="th-sm text-center">Description
                                            </th>
                                            <th class="th-sm text-center">Qty
                                            </th>
                                            <th class="th-sm text-center">UOM
                                            </th>
                                            <th class="th-sm text-center">Selling Price(RM)
                                            </th>
                                            <th class="th-sm text-center">Base Cost(RM)
                                            </th>
                                            <th class="th-sm text-center">Discount(%)
                                            </th>
                                            <th class="th-sm text-center">Amount(RM)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="update-item-bucket">
                                        <tr class="update-noResultText">
                                            <td colspan="9" class="text-center">
                                                <h5>No item added yet</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="grey white-text">
                                        <tr>
                                            <th colspan="8" class="text-right"><strong>Discount : </strong></th>
                                            <th id="update-total_discount"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="8" class="text-right"><strong>Total Amount : </strong></th>
                                            <th id="update-total_cost"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </div>
        <!-- Central Modal Medium Info-->

        <!-- Central Modal Warning Demo-->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <!-- <form action="./backend/invoice/invoice.php" method="POST"> -->
                    <!--Header-->
                    <!-- <input hidden="true" type="text" name="postType" value="deleteHeader"> -->
                    <input hidden="true" type="text" name="invoice_id" id="delete_id">
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading">Delete Invoice</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">
                            <p>Are you want to delete <span id="deleteInvoiceName"></span>?</p>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button id="deleteInvoiceSubmitButton" class="btn btn-warning">Yes</button>
                            <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Nevermind</a>
                        </div>
                    </div>
                <!-- </form> -->
            </div>
        </div>
        <!-- Central Modal Warning Demo-->

        <!-- Central Modal Warning Demo-->
        <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <form action="./backend/invoice/printInvoice.php" method="POST">
                    <!--Header-->
                    <input hidden="true" type="text" name="postType" value="print">
                    <input hidden="true" type="text" name="invoice_id" id="print_id">
                    <div class="modal-content">
                        <!--Header-->
                        <div class="modal-header">
                            <p class="heading">Print Invoice</p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>

                        <!--Body-->
                        <div class="modal-body">
                            <p>Do you want to print <span id="printInvoiceName"></span>?</p>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" id="printInvoiceSubmitButton" class="btn btn-warning">Yes</button>
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