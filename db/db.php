<?php


$server = "_Your Server_";
$user = "_Username_";
$dbpassword = "_Your Database Password_";
$db = "emaillogin";

$con = mysqli_connect($server, $user, $dbpassword, $db);


if ($con) {
} else {
    $_SESSION['msg'] = "No Internet Connection";
}
