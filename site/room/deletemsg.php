<?php

require '../../db/db_connect.php';

$sno = $_POST['sno'];

$sql = "UPDATE `msgs2` SET `msg`=' (Message Deleted) ' WHERE `sno`='$sno'";
$result = mysqli_query($conn, $sql);

header('location: rooms.php');
