<?php

session_start();

if (isset($_SESSION['token'])) {
    require '../../db/db.php';
    require '../../db/db_connect.php';
    $token = $_SESSION['token'];
    $sqlofgetdata = "SELECT * FROM `emaillogin` WHERE `token`='$token'";
    $resultofgetdata = mysqli_query($con, $sqlofgetdata);
    if (mysqli_num_rows($resultofgetdata) > 0) {
        while ($row = mysqli_fetch_assoc($resultofgetdata)) {
            $username = $row['Username'];
            $email = $row['email'];
        }
    } else {
        header("location: login.php");
    }
} else {
    header("location: login.php");
}




if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $query = $_POST['query'];
    date_default_timezone_set("Asia/Kolkata");
    $time = date("d-m-Y h:i A");

    $sqlofinsertquery = "INSERT INTO `contactus`(`query`, `username`, `email`, `token`, `time`) VALUES ('$query','$username','$email','$token','$time')";
    $resultofinsertquery = mysqli_query($conn, $sqlofinsertquery);
    if ($resultofinsertquery) {
        $_SESSION['msg'] = "Thanks For Your Feedback.";
        $_SESSION['msgbg'] = "success";
    } else {
        $_SESSION['msg'] = "Failed To Send Your Feedback Please Try Again Later...";
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
    <title>Wispychat Contact Us</title>
</head>

<body>
    <?php require '../../partials/_header.html' ?>

    <div class="container my-3">
        <h3 class="text-muted" style="letter-spacing: 2px;">Contact Us:</h3>
        <form action="" method="POST">
            <br>
            <div class="mb-3">
                <label for="usernamelabel" class="form-label">Username</label>
                <input class="form-control" name="username" id="username" value="<?php echo $username; ?>" placeholder="Username" required="">
            </div>

            <div class="mb-3">
                <label for="emaillabel" class="form-label">Email</label>
                <input class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email" required="">
            </div>

            <div class="mb-3">
                <label for="querylabel" class="form-label">Your Query</label>
                <textarea class="form-control" id="query" rows="3" name="query" placeholder="Type Your Query/Feedback" required=""></textarea>
            </div>
            <input type="submit" name="submit" class="btn btn-success">
        </form>
    </div>

    <?php require '../../link/footer.html'; ?>

</body>

</html>