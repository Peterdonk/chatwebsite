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
    <title>Password Recover</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="logo" src="img1.png" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Custom Theme files -->
    <?php require '../../link/links.html'; ?>
    <link rel="stylesheet" href="../../css/style2.css">
</head>

<body>
    <?php

    if (isset($_POST['submit'])) {
        include '../../db/db.php';

        if (isset($_GET['token'])) {

            $token = $_GET['token'];

            $password = mysqli_real_escape_string($con, $_POST['password']);
            $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

            $pass = password_hash($password, PASSWORD_BCRYPT);
            $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

            if ($password === $cpassword) {

                $updatequery = " update emaillogin set password='$pass' where token='$token' ";

                $iqueary = mysqli_query($con, $updatequery);

                if ($iqueary) {
                    $_SESSION['msg'] = "Your Password has been Updated";
                    header('location: ../');
                } else {
                    $_SESSION['msg'] = "Password Update Failed";
                }
            } else {
                $_SERVER['msg'] = "Password are not Mathcing";
            }
        } else {
            $_SESSION['msg'] = "No Email Found";
        }
    } else {
        $_SESSION['msg'] = "Fill All Imformation";
    }
    ?>
    <!-- main -->
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first my-2">
                <div class="bg-<?php echo $_SESSION['msgBg'] ?> text-<?php echo $_SESSION['msgTxt'] ?> fadeIn first">
                    <p class="px-2" style="width: 100%;"><?php if (isset($_SESSION['msg'])) {
                                                                echo $_SESSION['msg'];
                                                            } ?></p>
                </div>
            </div>

            <!-- Login Form -->
            <form action="" method="POST">
                <input type="password" id="password" class="fadeIn fifth pass" name="password" placeholder="Choose Password" required="">
                <input type="password" id="cpassword" class="fadeIn sixth cpass" name="cpassword" placeholder="Repeat Password" required="">
                <i>
                    <p id="passmsg" class="passmsg"></p>
                </i>
                <input type="submit" name="submit" class="fadeIn eighth" value="Reset Password">
            </form>

        </div>
    </div>
    <!-- //main -->
    <?php require '../../link/footer.html'; ?>

    <script>
        var cpassword = document.getElementById('cpassword')
        cpassword.addEventListener('input', () => {
            cpassword = document.getElementById('cpassword').value
            password = document.getElementById('password').value
            if (password == cpassword) {
                passMsg = "The Password Are Matching Now";
                document.getElementById('passmsg').innerHTML = passMsg;
                document.getElementsByClassName('pass')[0].style.border = "0.5px solid green";
                document.getElementsByClassName('cpass')[0].style.border = "0.5px solid green";
                document.getElementsByClassName('passmsg')[0].style.color = "green";
                setTimeout(() => {
                    document.getElementsByClassName('pass')[0].style.border = "";
                    document.getElementsByClassName('cpass')[0].style.border = "";
                }, 1000);
            } else {
                passMsg = "The Password is not Matching";
                document.getElementById('passmsg').innerHTML = passMsg;
                document.getElementsByClassName('pass')[0].style.border = "0.5px solid red";
                document.getElementsByClassName('cpass')[0].style.border = "0.5px solid red";
                document.getElementsByClassName('passmsg')[0].style.color = "red";
            }
        })
    </script>

</body>

</html>