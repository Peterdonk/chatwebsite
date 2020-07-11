<?php

$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "chatroom";

$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);

if (!$conn) {
    die("Failed To Connect " . mysqli_connect_error());
}
