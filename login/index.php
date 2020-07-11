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
    <title>SignIn Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        #toggle {
            position: absolute;
            top: 45%;
            right: 10%;
            width: 30px;
            height: 30px;
            transform: translateY(-50%);
            background-size: cover;
            cursor: pointer;
        }
    </style>
    <!-- Custom Theme files -->
    <link href="../css/style2.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
    <?php

    if (isset($_POST['submit'])) {
        require '../db/db.php';
        require '../db/db_connect.php';
        $email = $_POST['email'];
        $password = $_POST['password'];

        $email_search = " select * from emaillogin where email='$email' and status='active' ";
        $query = mysqli_query($con, $email_search);

        $email_count = mysqli_num_rows($query);

        if ($email_count) {
            $email_pass = mysqli_fetch_assoc($query);

            $db_pass = $email_pass['password'];
            $db_user = $email_pass['Username'];
            $db_token = $email_pass['token'];
            $db_mobile = $email_pass['mobile'];
            $db_email = $email_pass['email'];
            $db_status2 = $email_pass['status2'];

            $_SESSION['username'] = $db_user;
            $_SESSION['email'] = $db_email;
            $_SESSION['mobile'] = $db_mobile;
            $_SESSION['token'] = $db_token;
            $_SESSION['status2'] = $db_status2;


            $pass_decode = password_verify($password, $db_pass);

            if ($pass_decode) {
                setcookie('tokenwispy', $db_token, time() + (10 * 365 * 24 * 60 * 60));
                setcookie('emailwispy', $db_email, time() + (10 * 365 * 24 * 60 * 60));
                setcookie('passwordwispy', $password, time() + (10 * 365 * 24 * 60 * 60));
                if (isset($_POST['rememberme'])) {
                    setcookie('emailcookie', $email, time() + 86400);
                    setcookie('passwordcookie', $password, time() + 86400);
                    $_SESSION['loginTrace'] = "Loginned";
                    $updatequery = "UPDATE emaillogin SET `status2`='online' WHERE token='$db_token'";
                    $query = mysqli_query($con, $updatequery);
                    if ($query) {
                        header("location:../site/home/");
                    }
                } else {
                    setcookie('emailcookie', '', time() - 86400);
                    setcookie('passwordcookie', '', time() - 86400);
                    $_SESSION['loginTrace'] = "Loginned";
                    $updatequery = "UPDATE emaillogin SET `status2`='online' WHERE token='$db_token'";
                    $query = mysqli_query($con, $updatequery);
                    if ($query) {
                        header("location:../site/home/");
                    }
                }
            } else {
                $_SESSION['msg'] = "Password Incorect";
                $_SESSION['msgBg'] = "danger";
                $_SESSION['msgTxt'] = "white";
            }
        } else {
            $_SESSION['msg'] = "Invalid Email";
            $_SESSION['msgBg'] = "danger";
            $_SESSION['msgTxt'] = "white";
        }
    }
    ?>
    <!-- main -->
    <div class="wrapper fadeInDown">
        <div id="formContent">

            <!-- Icon -->
            <div class="bg-<?php echo $_SESSION['msgBg'] ?> text-<?php echo $_SESSION['msgTxt'] ?> fadeIn first">
                <p class="px-2" style="width: 100%;"><?php echo $_SESSION['msg']; ?></p>
            </div>

            <!-- Login Form -->
            <form action="" method="POST">
                <input type="email" id="login" class="fadeIn second" name="email"" value=" <?php
                                                                                            if (isset($_COOKIE['emailcookie'])) {
                                                                                                echo $_COOKIE['emailcookie'];
                                                                                            } else {
                                                                                                echo "";
                                                                                            }
                                                                                            ?>" placeholder="Email" required="">
                <input type="password" id="password" class="fadeIn third" name="password" value="<?php
                                                                                                    if (isset($_COOKIE['passwordcookie'])) {
                                                                                                        echo $_COOKIE['passwordcookie'];
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    }
                                                                                                    ?>" placeholder="Password" required="">
                <div id="toggle" onclick="showHide()">
                    <i class="fas fa-eye"></i>
                    <!-- <i class="fas fa-eye-slash"></i> -->
                </div>
                <br>
                <input type="checkbox" accesskey="m" id="checkbox" checked="" class="fadeIn fourth" name="rememberme">
                <label class="fadeIn fourth">Remember Me</label>
                <br>
                <input type="submit" name="submit" class="fadeIn fifth" value="Log In">
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover fadeIn sixth" href="forgotpass/">Forgot Password?</a>
            </div>

        </div>
    </div>
    <!-- //main -->

    <script>
        const password = document.getElementById('password');
        const toogle = document.getElementById('toggle');

        function showHide() {
            if (password.type === "password") {
                password.setAttribute('type', 'text')
                toogle.innerHTML = `<i class="fas fa-eye-slash"></i>`;
            } else {
                password.setAttribute('type', 'password')
                toogle.innerHTML = `<i class='fas fa-eye'></i>`;
            }
        }
    </script>
</body>

</html>