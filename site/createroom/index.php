<?php
session_start();

if ($_SESSION['token']) {
    require '../../db/db.php';
    require '../../db/db_connect.php';
    $token = $_SESSION['token'];
} else {
    $_SESSION['msg'] = "You Havn't Logged In.";
    header("location: login.php");
}

?>





<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chat Room</title>

    <?php require '../../link/links.html' ?>

    <!-- Favicons -->
    <link rel="icon" href="img/icon1.png" sizes="32x32" type="image/png">
    <link rel="icon" href="img/icon1.png" sizes="16x16" type="image/png">
    <meta name="theme-color" content="#563d7c">


    <style>
        .inp {
            z-index: 999999999;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .msg {
            margin-left: 35%;
            max-width: 30%;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="../../css/product.css" rel="stylesheet">
</head>

<body>

    <?php require '../../partials/_header.html'; ?>


    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="p-lg-5 mx-auto my-5">
            <p class="bg-info text-white msg" style="width: 380px;"><?php if (isset($_SESSION['msg'])) {
                                                                        echo $_SESSION['msg'];
                                                                    } ?></p>
            <h1 class="font-weight-normal">Wispy Chat Room</h1>
            <p class="lead font-weight-normal">Chat With Your Friend Free.</p>
            <form action="claim.php" method="POST">
                <input type="text" class="mx-2 inp" name="room">
                <select onchange="optionsChange(this.value)" name="options">
                    <option>Public</option>
                    <option>Private</option>
                </select>
                <div id="password"></div>
                <br>
                <button class="btn btn-outline-secondary my-3" name="submit">Claim Room</button>
            </form>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

    <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
        <div class="bg-dark mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
            <div class="my-3 py-3">

                <h2 class="display-5"><?php
                                        $sql = "SELECT * FROM emaillogin WHERE status='active'";
                                        $result = mysqli_query($con, $sql);
                                        echo mysqli_num_rows($result);
                                        ?></h2>
                <p class="lead">Peoples Already Regestered.</p>
            </div>
            <div class="bg-light shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
        </div>
        <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
            <div class="my-3 p-3">
                <h2 class="display-5"><?php
                                        $sql = "SELECT * FROM rooms2";
                                        $result = mysqli_query($conn, $sql);
                                        echo mysqli_num_rows($result);
                                        ?></h2>
                </h2>
                <p class="lead">Rooms Created</p>
            </div>
            <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
        </div>
    </div>

    <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
        <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
            <div class="my-3 p-3">
                <h2 class="display-5"><?php
                                        $sql = "SELECT * FROM msgs2";
                                        $result = mysqli_query($conn, $sql);
                                        echo mysqli_num_rows($result);
                                        ?></h2>
                <p class="lead">Massages Sent.</p>
            </div>
            <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
        </div>
        <div class="bg-primary mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
            <div class="my-3 py-3">
                <h2 class="display-5"><?php
                                        $sql = "SELECT * FROM emaillogin WHERE `status2`='online'";
                                        $result = mysqli_query($con, $sql);
                                        echo mysqli_num_rows($result);
                                        ?></h2>
                <p class="lead">Peoples Are Online.</p>
            </div>
            <div class="bg-light shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
        </div>
    </div>

    <footer class="container py-5">
        <div class="row">
            <div class="col-12 col-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mb-2" role="img" viewBox="0 0 24 24" focusable="false">
                    <title>Product</title>
                    <circle cx="12" cy="12" r="10" />
                    <path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94" />
                </svg>
                <small class="d-block mb-3 text-muted">&copy; 2017-2019</small>
            </div>
            <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Cool stuff</a></li>
                    <li><a class="text-muted" href="#">Random feature</a></li>
                    <li><a class="text-muted" href="#">Team feature</a></li>
                    <li><a class="text-muted" href="#">Stuff for developers</a></li>
                    <li><a class="text-muted" href="#">Another one</a></li>
                    <li><a class="text-muted" href="#">Last time</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Resources</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Resource</a></li>
                    <li><a class="text-muted" href="#">Resource name</a></li>
                    <li><a class="text-muted" href="#">Another resource</a></li>c
                    <li><a class="text-muted" href="#">Final resource</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Resources</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Business</a></li>
                    <li><a class="text-muted" href="#">Education</a></li>
                    <li><a class="text-muted" href="#">Government</a></li>
                    <li><a class="text-muted" href="#">Gaming</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>About</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Team</a></li>
                    <li><a class="text-muted" href="#">Locations</a></li>
                    <li><a class="text-muted" href="#">Privacy</a></li>
                    <li><a class="text-muted" href="#">Terms</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <?php require '../../link/footer.html' ?>

    <script>
        function optionsChange(value) {
            if (value == "Private") {
                document.getElementById('password').innerHTML = `
                    <input type="password" class="mx-2 inp my-3" name="password" required="" placeholder="Password">
                `
            } else {
                document.getElementById('password').innerHTML = "";
            }
        }
    </script>
</body>

</html>