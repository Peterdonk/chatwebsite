<?php
session_start();
?>

<!--
Author: Colorlib
Author URL: https://colorlib.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<head>
    <title>ROOM PASSWORD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Custom Theme files -->
    <link href="style2.css" rel="stylesheet" type="text/css" media="all" />
    <!-- //Custom Theme files -->
    <!-- web font -->
    <link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
    <!-- //web font -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <?php

    if (isset($_POST['submit'])) {
        require 'db.php';
        require 'db_connect.php';
        $token = $_SESSION['token'];
        $roomname = $_SESSION['roomname'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `rooms2` WHERE `roomname`='$roomname'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['password'] == $password) {
                    $_SESSION['roomname'] = $roomname;
                    $_SESSION['password'] = $password;
                    if ($token == "admin") {
                    } else {
                        $sql2 = "SELECT * FROM `emaillogin` WHERE `token`='$token'";
                        $result2 = mysqli_query($con, $sql2);
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            $username = $row2['Username'];
                            $email = $row2['email'];

                            $ip = $_SERVER['REMOTE_ADDR'];
                            $sql = "INSERT INTO `msgs2`(`room`, `msg`, `name`, `email`, `ip`, `type`, `token`) VALUES ('$roomname','$username Joined The Room','$username','$email','$ip','join','$token')";
                            $result = mysqli_query($conn, $sql);
                        }
                    }
                    $sql = "UPDATE `emaillogin` SET `currentroom`='$roomname' WHERE `token`='$token'";
                    $result = mysqli_query($con, $sql);
                    header("location: rooms.php");
                } else {
                    $_SESSION['msg'] = "Incorrect Password";
                    $_SESSION['msgBg'] = "danger";
                    $_SESSION['msgTxt'] = "white";
                }
            }
        } else {
            $_SESSION['msg'] = "Something Went Wrong";
            $_SESSION['msgBg'] = "danger";
            $_SESSION['msgTxt'] = "white";
        }
    }
    ?>
    <!-- main -->
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="inactive underlineHover"><a accesskey="l" href=""> ROOM PASSWORD </a></h2>

            <!-- Icon -->
            <div class="fadeIn first">
                <div class="bg-<?php echo $_SESSION['msgBg'] ?> text-<?php echo $_SESSION['msgTxt'] ?> fadeIn first">
                    <p class="px-2" style="width: 100%;"><?php if (isset($_SESSION['msg'])) {
                                                                echo $_SESSION['msg'];
                                                            } ?></p>
                </div>
            </div>

            <!-- Login Form -->
            <form action="" method="POST">
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Enter Room Password" required="">
                <input type="submit" name="submit" class="fadeIn eighth" value="GO AHEAD">
            </form>

        </div>
    </div>
    <!-- //main -->
</body>

</html>