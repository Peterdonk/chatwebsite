<?php


session_start();
require '../../db/db.php';
require '../../db/db_connect.php';

$usermailtoken = $_GET['token'];
$useremail = $_GET['email'];
$username = $_GET['username'];
$feedbacksno = $_GET['sno'];

$sql = "UPDATE `contactus` SET `status`='seen' WHERE `sno`='$feedbacksno'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['msg'] = "Updated Successfully";
    header("location: ../feedback_admin/");
} else {
    $_SESSION['msg'] = "Updated Failed";
    header("location: ../feedback_admin/");
}
