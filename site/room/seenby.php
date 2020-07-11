<?php

require 'db.php';
require 'db_connect.php';

$sno = $_POST['sno'];

$sqlofseenby = "SELECT * FROM `msgseen` WHERE `msgsno`='$sno'";
$resultofseenby = mysqli_query($conn, $sqlofseenby);

if (mysqli_num_rows($resultofseenby) != 0) {
    while ($row = mysqli_fetch_assoc($resultofseenby)) {
        $msgseentoken = $row['token'];

        $sqlofuserdetail = "SELECT * FROM `emaillogin` WHERE `token`='$msgseentoken'";
        $resultofuserdetail = mysqli_query($con, $sqlofuserdetail);

        $rowofuserdetail = mysqli_fetch_assoc($resultofuserdetail);
        $seenbyUsername = $rowofuserdetail['Username'];
        $seenbyEmail = $rowofuserdetail['email'];

        echo '
            ' . $seenbyUsername . ' - ' . $seenbyEmail . '
        ';
    }
} else {
    echo '<h5 class="text-muted text-center">No one Seen Yet</h4>';
}
