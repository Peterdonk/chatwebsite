<?php
session_start();
$room = $_POST['room'];

if ($_SESSION['token']) {
    require "../../db/db_connect.php";
    require "../../db/db.php";
    $token = $_SESSION['token'];
    if (strlen($room) > 20) {
?>
        <script>
            alert("Please Choose Name Between 2 or 20 Characters!");
            location.href = "../home/";
        </script>
    <?php
    } elseif (strlen($room) < 2) {
    ?>
        <script>
            alert("Please Choose Name Between 2 or 20 Characters!");
            location.href = "../home/";
        </script>
    <?php
    } elseif (!ctype_alnum($room)) {
    ?>
        <script>
            alert("Please Choose Alphanumaric room Name");
            location.href = "../home/";
        </script>
        <?php
    }

    $sql = "SELECT * FROM `rooms2` WHERE roomname = '$room';";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
        ?>

            <script>
                alert("Your Room Name is Already exists");
                location.href = "../home/";
            </script>

<?php
        } else {
            $owner = $_SESSION['token'];
            if ($_POST['options'] == "Private") {
                $password = $_POST['password'];
                $sql = "INSERT INTO `rooms2` (`roomname`, `owner`, `stime`, `type`, `password`) VALUES ('$room', '$owner', CURRENT_TIMESTAMP, 'private', '$password');";
            } else {
                $sql = "INSERT INTO `rooms2` (`roomname`, `owner`, `stime`, `type`) VALUES ('$room', '$owner', CURRENT_TIMESTAMP, 'public');";
            }
            if (mysqli_query($conn, $sql)) {
                $_SESSION['roomname'] = $room;
                $_SESSION['pass'] = $password;
                if ($token == "admin") {
                } else {
                    $sql2 = "SELECT * FROM `emaillogin` WHERE `token`='$token'";
                    $result2 = mysqli_query($con, $sql2);
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $username = $row2['Username'];
                        $email = $row2['email'];
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $sql = "INSERT INTO `msgs2`(`room`, `msg`, `name`, `email`, `ip`, `type`, `token`) VALUES ('$room','$username Joined The Room','$username','$email','$ip','join','$token')";
                        $result = mysqli_query($conn, $sql);
                    }
                }
                $sql = "UPDATE `emaillogin` SET `currentroom`='$room' WHERE `token`='$token'";
                $result = mysqli_query($con, $sql);
                header('location: ../room/');
            } else {
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    $_SESSION['msg'] = "You Havn't Logged In";
    header("../../login/");
}



mysqli_close($conn);
