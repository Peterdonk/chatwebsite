<?php

require '../../db/db.php';
require '../../db/db_connect.php';

if (isset($_COOKIE['tokenwispy'])) {
    $token = $_COOKIE['tokenwispy'];
    $sql = "SELECT * FROM `emailogin` WHERE `token`='$token'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $_SESSION['username'] = $row['Username'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['mobile'] = $row['mobile'];
    $_SESSION['token'] = $row['token'];
    $_SESSION['status2'] = $row['status2'];

    if ($_SESSION['token'] == $row['token']) {
        $updatequery = "UPDATE emaillogin SET `status2`='online' WHERE token='$db_token'";
        $query = mysqli_query($con, $updatequery);

        $_SESSION['loginTrace'] = "Loginned";

        header("location: ../../site/home/");
    }
} else {
    $_SESSION['msg'] = "No Last Data Found First Login Once Here to Use My Account System";
    header("location: ../../login/");
}
