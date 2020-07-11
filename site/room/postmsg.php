<?php
require '../../db/db_connect.php';
require '../../db/db.php';

$res = "";
$msg = $_POST['text'];
$room = $_POST['room'];
$ip = $_POST['ip'];
$name = $_POST['name'];
$email = $_POST['email'];
$token = $_POST['token'];
$time = $_POST['time'];

$sql = "INSERT INTO `msgs2`(`msg`,`room`,`ip`,`stime`, `name`, `email`, `token`, `type`) VALUES('$msg','$room','$ip', '$time', '$name', '$email', '$token', 'msg');";

mysqli_query($conn, $sql);
mysqli_close($conn);

$res = $res . '<div class="msg right-msg">';
$res = $res . '<div class="msg-bubble">';
$res = $res . '<div class="msg-info">';
$res = $res . '<div class="msg-info-name">You</div>';
$res = $res . '<div class="msg-info-time">' . $time . '</div>';
$res = $res . ' </div>';
$res = $res . ' <div class="msg-text">' . $msg . '</div></div>';
$res = $res . ' </div>';

echo $res;
