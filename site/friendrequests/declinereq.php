<?php

require "../../db/db.php";
require "../../db/db_connect.php";

$token = $_GET['token'];
$ptoken = $_GET['ptoken'];

if ($token and $ptoken) {
    $sql = "UPDATE `friendreq` SET `status`='decline' WHERE fromreq='$ptoken' and toreq='$token'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: friendrequests.php?token=$token");
    }
}
