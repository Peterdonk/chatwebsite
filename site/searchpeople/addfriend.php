<?php
require "../../db/db.php";
require "../../db/db_connect.php";
$ptoken = $_GET['ptoken'];
$token = $_GET['token'];

$sql = "INSERT INTO `friendreq`(`fromreq`, `toreq`, `status`) VALUES ('$token', '$ptoken', 'pending')";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("location: ../home/");
}
