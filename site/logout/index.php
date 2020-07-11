<?php
session_start();
require '../../db/db.php';

setcookie('emailcookie', '', time() - 86400);
setcookie('passwordcookie', '', time() - 86400);

$_SESSION['msg'] = "You Logged Out";
$_SESSION['loginTrace'] = null;
$token = $_SESSION['token'];
$updatequery = "UPDATE emaillogin SET `status2`='offline' WHERE token='$token'";
$query = mysqli_query($con, $updatequery);
if ($query) {
    header('location:../../login/');
}
