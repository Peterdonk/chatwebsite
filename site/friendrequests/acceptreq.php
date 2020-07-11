<?php

require "../../db/db.php";
require "../../db/db_connect.php";

$ptoken = $_GET['ptoken'];
$token = $_GET['token'];

// echo $ptoken;
// echo "<br>";
// echo $token;

if ($ptoken && $token) {
    $sql = "UPDATE `friendreq` SET `status`='accept' WHERE fromreq='$ptoken' and toreq='$token'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql = "INSERT INTO `friends`(`friendtoken`, `token`)  VALUES('$ptoken','$token')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sql = "INSERT INTO `friends`(`friendtoken`, `token`)  VALUES('$token','$ptoken')";
            $result = mysqli_query($conn, $sql);

            header("location: ../home/");
        }
    }
}
