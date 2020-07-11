<?php

session_start();
require '../../db/db.php';
require '../../db/db_connect.php';

$usermailtoken = $_GET['token'];
$useremail = $_GET['email'];
$username = $_GET['username'];
$feedbacksno = $_GET['sno'];

$userfeedback = $_GET['q'];

if (isset($_POST['submit'])) {
    $useremail = $_POST['useremail'];
    $mailbody = $_POST['mailbody'];

    require "../../phpmailer/class.phpmailer.php";

    $mail = new PHPMailer();
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = '_Your GmailId_';                     // SMTP username
    $mail->Password = '_Your GmailPassword_';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('_Your GmailId_', 'Wispychat');
    $mail->addAddress($useremail, "$username");     // Add a recipient
    $mail->isHTML(true);

    $mail->Subject = "Wispychat Feedback Response";
    $mail->Body = "$mailbody" . "\n\n<em>-Admin</em>";

    if ($mail->send()) {
        $sql = "UPDATE `contactus` SET `status`='mailed' WHERE `sno`='$feedbacksno';";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['msg'] = "Mail Sent";
            header("location: ../feedback_admin/");
        } else {
            $_SESSION['msg'] = "Failed To Change Status";
        }
    } else {
        $_SESSION['msg'] = "Failed To Sent";
        $_SESSION['msgbg'] = "danger";
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <?php require '../../link/links.html'; ?>
    <title>Wispychat Send Mail</title>
</head>

<body>
    <?php require '../../partials/_header.html' ?>

    <div class="container my-3">
        <h3 class="text-muted" style="letter-spacing: 2px;">Send Mail:</h3>
        <form action="" method="POST">
            <br>

            <div class="mb-3">
                <label for="userfeedbackLabel" class="form-label">User Feedback</label>
                <textarea class="form-control" rows="2" placeholder="" readonly=""><?php echo $userfeedback; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="emailLabel" class="form-label">Email</label>
                <input class="form-control" id="useremail" rows="3" name="useremail" readonly="" placeholder="Type email" value="<?php echo $useremail; ?>" required="">
            </div>

            <div class="mb-3">
                <label for="bodyLabel" class="form-label">Mail Body</label>
                <textarea class="form-control" id="mailbody" rows="5" name="mailbody" placeholder="Type Body" required=""></textarea>
            </div>
            <input type="submit" value="SEND" name="submit" class="btn btn-success">
        </form>

        <div id="quickDiv" class="quickDiv my-2">
            <button class="btn btn-dark btn-sm" onclick="addValue(this.innerHTML)">Hi <?php echo $username; ?>, </button>
            <button class="btn btn-dark btn-sm" onclick="addValue(this.innerHTML)">br</button>
            <button class="btn btn-dark btn-sm" onclick="addValue(this.innerHTML)">Thanks For Contacting Us.</button>
            <button class="btn btn-dark btn-sm" onclick="addValue(this.innerHTML)">Thanks For Your Feedback.</button>
        </div>
    </div>

    <?php require '../../link/footer.html'; ?>


    <script>
        function addValue(val) {
            if (val == "Hi <?php echo $username; ?>, ") {
                document.getElementById('mailbody').value += val + "<br> \t"
            } else if (val == "br") {
                document.getElementById('mailbody').value += "<br>"
            } else if (val == "Thanks For Contacting Us.") {
                document.getElementById('mailbody').value += val + "<br>"
            } else if (val == "Thanks For Your Feedback.") {
                document.getElementById('mailbody').value += "<br>" + val + "<br>"
            } else {
                document.getElementById('mailbody').value += val
            }
        }



        $(document).keydown(function(objEvent) {
            if (objEvent.keyCode == 9) { //tab pressed
                document.getElementById('mailbody').value += "\t"
                objEvent.preventDefault();
            }
        })
    </script>
</body>

</html>
