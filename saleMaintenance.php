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
    <title>Sales Maintanance</title>

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
    <!-- <script src="./dist/js/saleMaintenance.prod.js"></script> -->
    <script src="./dist/js/datatables.min.js"></script>


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
                        <li class="breadcrumb-item active">Sales Maintanance</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-lg-10 col-md-8 col-sm-6">
                        <h1 class="h1-responsive">Sales Maintanance</h1>
                    </div>
                </div>
                <div class="mt-3 row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="salesorder-tab" data-toggle="tab" href="#salesorder" role="tab" aria-controls="salesorder" aria-selected="true">Sales Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="salespayment-tab" data-toggle="tab" href="#salespayment" role="tab" aria-controls="salespayment" aria-selected="false">Sales Payment</a>
                            </li>
                        </ul>
                    </div>
                </div>  
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="salesorder" role="tabpanel" aria-labelledby="salesorder-tab">
                        <?php include "./salesOrderPage.php"; ?>
                    </div>
                    <div class="tab-pane fade" id="salespayment" role="tabpanel" aria-labelledby="salespayment-tab">
                        <?php include "./salesPaymentPage.php"; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="successToModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-notify modal-success" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="heading lead" id="successModalHeadline"></p>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <p id="successModalBody"></p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a type="button" class="btn btn-outline-success btnSuccess waves-effect"
                            data-dismiss="modal">OK</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Failed Alert -->
        <div class="modal fade" id="failedToModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
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