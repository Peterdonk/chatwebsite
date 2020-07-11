<?php
session_start();

require '../../db/db.php';
require '../../db/db_connect.php';
$token = $_SESSION['token'];

if (isset($token)) {
    $sql = "SELECT * FROM `settings` WHERE `token`='$token'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $default_show_message = $row['default_show_message'];
        $default_pre_message = $row['default_pre_message'];
        $run_time = $row['run_time'];
        echo $run_time;
    }
} else {
    header("location: ../home/");
}



if (isset($_POST['submit'])) {
    $showMessage = $_POST['showMessage'];
    $preMessage = $_POST['preMessage'];
    $run_time = $_POST['runTime'];

    $sql = "UPDATE `settings` SET `default_show_message`='$showMessage', `default_pre_message`='$preMessage',`run_time`='$run_time' WHERE `token`='$token';";
    $result = mysqli_query($conn, $sql);


    $sql = "SELECT * FROM `settings` WHERE `token`='$token'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $default_show_message = $row['default_show_message'];
            $default_pre_message = $row['default_pre_message'];
            $run_time = $row['run_time'];
        }
        $_SESSION['msg'] = "The Setting Has Been Updated";
        $_SESSION['msgbg'] = "success";
    } else {
        $_SESSION['msg'] = "Failed To Update Settings";
        $_SESSION['msgbg'] = "danger";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php require '../../link/links.html' ?>

    <link rel="stylesheet" href="../../css/settings.css">

    <title>Wispychat Settings</title>

</head>

<body>

    <?php require '../../partials/_header.html' ?>

    <div class="container my-3">
        <form action="" method="POST">
            <h4 class="message" id="message"></h4>
            <div class="showMessage" id="showMessage">
                <h4>Default Show Message In Room:</h4>
                <div class="container mx-5 my-3">
                    <input type="number" name="showMessage" id="showMessage" class="mx-2" oninput="
                    if(this .value > 100){
                        document.getElementById('message').innerHTML = `Warning: '${this.value} Default Show Message' May Take Big Ammount Of Data And Speed`;
                    }
                    else{
                        document.getElementById('message').innerHTML = ``;
                    }" min="10" max="300" value="<?php echo $default_show_message ?>">
                </div>
            </div>

            <div class="preMessage" id="preMessage">
                <h4>Previous Message In Room:</h4>
                <div class="container mx-5 my-3">
                    <input type="number" name="preMessage" id="preMessage" class="mx-2" min="10" max="300" value="<?php echo $default_pre_message ?>">
                </div>
            </div>

            <div class="runTime" id="runTime">
                <h4>Run Time:</h4>
                <div class="container mx-5">
                    <input type="number" name="runTime" id="runTime" oninput="
                        if(this.value < 4){
                            document.getElementById('message').innerHTML = `Warning: '${this.value}' Run Time May Take Big Ammount Of Data And Speed`;
                        }
                        else if(this.value == `0`){
                            this.value = 2;
                        }
                        else{
                            document.getElementById('message').innerHTML = ``;
                        }
                    " class="mx-2" min="1" max="20" value="<?php echo $run_time ?>"><span>Second</span>
                </div>
            </div>
            <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Save">
    </div>

    </form>
    </div>




    <?php require '../../link/footer.html' ?>
</body>

</html>