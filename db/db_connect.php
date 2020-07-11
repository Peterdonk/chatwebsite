<?php

$db_servername = "_Server Name_";
$db_username = "_Your Username_";
$db_password = "_Your Database Password_";
$db_database = "chatroom";

$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);

if (!$conn) {
    die("Failed To Connect " . mysqli_connect_error());
}
