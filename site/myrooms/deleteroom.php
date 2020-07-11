<?php

require 'db.php';
require 'db_connect.php';


if (isset($_GET['token']) && isset($_GET['roomname'])) {
    $token = $_GET['token'];
    $roomname = $_GET['roomname'];
    $sql = "DELETE FROM `rooms2` WHERE roomname='$roomname' and `owner`='$token'";
    $result = mysqli_query($conn, $sql);
    $sql2 = "DELETE FROM `msgs2` WHERE room='$roomname'";
    $result2 = mysqli_query($conn, $sql2);
    if ($result && $result2) {
        header("location: myrooms.php?token=$token");
    } else {
?>
        <script>
            alert("Something Went Wrong Please Try Again");
        </script>
<?php
        header("location: myrooms.php?token=$token");
    }
}
