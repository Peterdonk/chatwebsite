<?php
session_start();
require '../../db/db.php';
require '../../db/db_connect.php';

if ($_SESSION['token']) {
    $token = $_SESSION['token'];
    $joinroom = $_POST['joinroom'];
    $sql = "SELECT * FROM `rooms2` WHERE `roomname`='$joinroom';";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['type'] == "private") {
                    $_SESSION['roomname'] = $joinroom;
                    header("location: joinpass.php");
                } else {
                    $_SESSION['roomname'] = $joinroom;
                    $_SESSION['pass'] = "";
                    if ($token == "admin") {
                    } else {
                        $sql2 = "SELECT * FROM `emaillogin` WHERE `token`='$token'";
                        $result2 = mysqli_query($con, $sql2);
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            $username = $row2['Username'];
                            $email = $row2['email'];

                            $ip = $_SERVER['REMOTE_ADDR'];
                            $sql = "INSERT INTO `msgs2`(`room`, `msg`, `name`, `email`, `ip`, `type`, `token`) VALUES ('$joinroom','$username Joined The Room','$username','$email','$ip','join','$token')";
                            $result = mysqli_query($conn, $sql);
                        }
                    }
                    $sql = "UPDATE `emaillogin` SET `currentroom`='$joinroom' WHERE `token`='$token'";
                    $result = mysqli_query($con, $sql);
                    header("location: ../room/");
                }
            }
        } else {
?>
            <script>
                alert("This Room Is Not exists");
                location.href = "../home/";
            </script>
<?php
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    $_SESSION['msg'] = "You Havn't Logged In";
    header("login.php");
}


mysqli_close($conn);

?>