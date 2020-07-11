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
    <title>Recover Wispychat Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php require '../../link/links.html'; ?>

    <link rel="stylesheet" href="../../css/style2.css">

</head>

<body>
    <?php

    $_SESSION['msg'] = "Type Your Email";
    if (isset($_POST['submit'])) {
        include '../../db/db.php';

        $email = mysqli_real_escape_string($con, $_POST['email']);

        $emailquery = "select * from emaillogin where email='$email'";
        $query = mysqli_query($con, $emailquery);

        $emailcount = mysqli_num_rows($query);

        if ($emailcount) {

            $userdata = mysqli_fetch_array($query);
            $username = $userdata['Username'];
            $token = $userdata['token'];

            require "../../phpmailer/class.phpmailer.php";

            $mail = new PHPMailer();
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'henilmalaviya06@gmail.com';                     // SMTP username
            $mail->Password = 'henil_646';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('henilmalaviya06@gmail.com', 'Wispychat');
            $mail->addAddress($email, "$username");     // Add a recipient
            $mail->isHTML(false);

            $mail->Subject = "Wispychat Reset Password";
            $mail->Body = "Hi $username, Click here to Reset your Password - http://localhost/chat%20room%20versions/chat%20room%2014/login/forgotpass/reset_password.php?token=$token";

            if ($mail->send()) {
                $_SESSION['msg'] = "Check Your Mail At $email To Reset Wispychat Account Password";
                header("location: ../");
            } else {
                $_SESSION['msg'] = "Email Sending Failed At $email, Please Try Again";
            }
        } else {
            $_SESSION['msg'] = "No Email Found";
        }
    }
    ?>
    <!-- main -->
    <div class="wrapper fadeInDown">
        <div id="formContent">

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
                <input type="email" id="email" class="fadeIn third" name="email" placeholder="Email" required="">
                <input type="submit" name="submit" class="fadeIn eighth" value="SEND MAIL">
            </form>

        </div>
    </div>
    <!-- //main -->
    <?php require '../../link/footer.html'; ?>

</body>

</html>