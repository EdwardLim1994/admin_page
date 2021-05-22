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
    <title>Admin</title>

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
    <script src="./dist/js/menu.prod.js"></script>
</head>

<body>
    <header>
        <div class="blue">
            <div class="container-fluid">
                <div class="row py-2">
                    <div class="col-4 my-auto ">

                    </div>
                    <div class="col-4 text-center my-auto">
                        <a href="<?= $homepage_url ?>">
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
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="col-md-6 col-sm-12 text-md-left text-center p-2">
                <h5><?php if(isset($_GET['searchButton'])) echo "Search : " . $_GET['searchButton']; ?></h5>
            </div>

            <div class="col-md-6 col-sm-12">    
                <div class="input-group md-form form-sm form-2 pl-0">
                    <input class="form-control my-0 py-1 blue-border" type="text" id="searchBtnInput" placeholder="<?php if(isset($_GET['searchButton'])) echo $_GET['searchButton']; else echo "Search Button"; ?>" aria-label="Search">
                    <div class="input-group-append">
                        <button class="input-group-text blue lighten-2" id="searchBtnSubmit" type="button">
                            <i class="fas fa-search text-grey" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="input-group-append">
                        <a class="input-group-text blue lighten-2" <?php if(isset($_GET['searchButton'])) echo "href='./menu.php'"; ?>>
                            <i class="fas fa-sync-alt text-grey"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container-fluid py-5">
        <h2 class="h2-responsive text-center py-3 mb-3"><strong>Welcome to Admin Portal</strong></h2>


            <div class="row justify-content-around">

                <?php
                if(isset($_GET['searchButton'])){
                    $stmt = $mysqli->prepare("SELECT para_description, para_description2 FROM parameter where para_code = 'menu_button' and para_description3 like '%" .$_SESSION['role']. "%' and para_description like '%". $_GET['searchButton'] ."%'");
                    $stmt->execute();
                    $result = $stmt->get_result();
                }else{
                    $stmt = $mysqli->prepare("SELECT para_description, para_description2 FROM parameter where para_code = 'menu_button' and para_description3 like '%" .$_SESSION['role']. "%'");
                    $stmt->execute();
                    $result = $stmt->get_result();
                }


                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6  text-center">
                            <a href="./<?= $row['para_description2'] ?>" class="btn btn-primary roundBtn">
                                <p class="text-wrap text-capitalize h5-responsive"><?= $row['para_description'] ?></p>
                            </a>
                        </div>
                    <?php
                    };
                } else {
                    ?>
                    <div class="col-12 py-3 text-center">
                        <h3>No found</h3>
                    </div>

                <?php
                }

                $stmt->close();
                mysqli_close($mysqli);

                ?>


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