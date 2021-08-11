<?php
session_start();

if (isset($_SESSION["loggedin"]))
    switch ($_SESSION['role']) {
        case ("administrator"):
            header("location: ./menu.php");
            break;
        case ("stuff"):
            header("location: ./stuff.html");
            break;
        case ("normal"):
            header("location: ./normal.html");
            break;
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="192x192" href="./assets/favicon/android-chrome-192x192.png" />
    <link rel="icon" type="image/png" sizes="512x512" href="./assets/favicon/android-chrome-512x512.png" />
    <link rel="apple-touch-icon" href="./assets/favicon/apple-touch-icon.png">
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico">

    <link rel="stylesheet" href="normalize.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.0.0/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="./dist/css/style.min.css">


</head>

<body>
    <header>
        <div class="blue">
            <div class="container">
                <div class="py-2 row">
                    <div class="my-auto col-4">

                    </div>
                    <div class="text-center col-4">
                        <a href="https://www.nightcatdigitalsolutions.com">
                            <img class="rounded img-fluid logo hoverable" src="./assets/titleImage.jpeg" alt="Title Image">
                        </a>
                    </div>
                    <div class="my-auto text-right col-4">

                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container py-4 my-4 py-md-5 my-md-5">
            <div class="row justify-content-center">
                <div class="border col-lg-6 col-md-8 border-3">

                    <form class="p-5 text-center border border-light" action="./backend/login/login.php" method="post" id="loginForm">

                        <p class="py-3 mb-4 h4">Welcome to Admin Portal</p>

                        <div class="form-row justify-content-center">
                            <div class="col-md-8 col-sm-10">
                                <!-- Email -->
                                <input type="username" id="username" name="username" class="mb-4 form-control" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="col-md-8 col-sm-10">
                                <!-- Password -->
                                <input type="password" id="password" name="password" class="mb-4 form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="col-md-4 col-sm-6">
                                <!-- Sign in button -->
                                <button class="my-4 btn btn-primary btn-block" type="submit">Login</button>
                            </div>
                        </div>

                        <input type="text" hidden="true" id="ip_address" name="ip_address" value="<?= $_SERVER['REMOTE_ADDR'] ?>">
                        <input type="text" hidden="true" id="browser" name="browser" value="<?= getCurrentBrowser() ?>">

                        <?php if (isset($_GET['error'])) : ?>
                            <div class="mt-3 row justify-content-center">
                                <div role=" alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
                                    <div class="py-2 toast-header danger-color-dark justify-content-between">
                                        <h5 class="text-white">Alert</h5>
                                        <button type="button" class="mb-1 ml-2 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true" class="white-text">&times;</span>
                                        </button>
                                    </div>
                                    <div class="text-center toast-body danger-color white-text">
                                        <?= $_GET['error'] ?>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                    </form>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.0.0/mdb.min.js">
    </script>

    <script src="./dist/js/script.prod.js"></script>

</body>
<script type="text/javascript">
    <?php if (isset($_GET['error'])) : ?>
        $(document).ready(function() {
            $('.toast').toast('show');
        })
    <?php endif; ?>
</script>

</html>

<?php

function getCurrentBrowser()
{
    $arr_browsers = ["Opera", "Edg", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];

    $agent = $_SERVER['HTTP_USER_AGENT'];

    $user_browser = '';
    foreach ($arr_browsers as $browser) {
        if (strpos($agent, $browser) !== false) {
            $user_browser = $browser;
            break;
        }
    }

    switch ($user_browser) {
        case 'MSIE':
            $user_browser = 'Internet Explorer';
            break;

        case 'Trident':
            $user_browser = 'Internet Explorer';
            break;

        case 'Edg':
            $user_browser = 'Microsoft Edge';
            break;
    }

    return $user_browser;
}

?>