<?php

require "../../db/db.php";
require "../../db/db_connect.php";

$ptoken = $_GET['ptoken'];
$roomname = $_GET['room'];
$token = $_GET['token'];

// Getting Imformation About 'ptoken'
if ($ptoken && $token) {
    $sql = "SELECT * FROM `emaillogin` WHERE token='$ptoken'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row['Username'];
    $email = $row['email'];
    $status2 = $row['status2'];
    // echo "$name";
    // echo "$email";
    // echo "$status2";
} else {
    $_SESSION['roomsname'] = $roomname;
    $_SESSION['token'] = $token;
?>
    <script>
        alert("The User Is No Longer Exists Who are you looking For")
        location.href = "../room/";
    </script>
<?php
}



?>




<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/icon1.png" sizes="32x32" type="image/png">

    <?php require '../../link/links.html' ?>

    <title><?php echo $name; ?> - Profile</title>

    <style>
        .btn {
            text-transform: capitalize;
        }

        .name,
        .email,
        .status {
            display: flex;
        }

        .status {
            text-transform: capitalize;
        }
    </style>

</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand"><?php echo $name; ?> - Profile</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container my-4">
        <?php
        if ($roomname !== "") {
        ?>
            <button class="btn btn-outline-success my-2" onclick=" location.href = '../room/'">Go Back to <?php echo $roomname; ?> Room</button>
        <?php
        } else {
        }
        ?>


        <h3 class="my-2"><u>About - <?php echo $name; ?></u></h3>
        <div class="container mx-3 my-3">
            <div class="name">
                <h2><span class="badge badge-secondary">Name</span> - </h2>
                <h3 class="my-1 mx-4"> <?php echo $name; ?></h3>
            </div>
            <div class="email">
                <h2><span class="badge badge-secondary">Email</span> - </h2>
                <h3 class="my-1 mx-4"> <?php echo $email; ?></h3>
            </div>
            <div class="status">
                <h2><span class="badge badge-secondary">Status</span> - </h2>
                <h3 class="my-1 mx-4"> <?php echo $status2; ?></h3>
            </div>
        </div>
    </div> <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->


    <?php require '../../link/footer.html' ?>
</body>

</html>





<!-- Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, ullam rem blanditiis magni voluptatem iure quae porro culpa fugit sed dolorum. Minima sint natus perspiciatis est ipsum repellendus corrupti aliquam, ratione quo possimus quia explicabo, quisquam rerum ea autem ullam. Aliquam similique dolor voluptatibus at quaerat cupiditate laborum reprehenderit exercitationem quisquam? Dolor ipsum eveniet beatae suscipit labore ea ratione ullam praesentium sit minima! Dolor placeat et distinctio est id. Sunt eius placeat ipsa fuga impedit asperiores dolorum eaque rerum minima quasi? Repellat natus voluptatem a velit dolorem vitae officiis ad debitis maxime! Suscipit voluptatum eos placeat odit quas fugiat beatae. -->