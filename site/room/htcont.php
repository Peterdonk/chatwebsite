<?php

session_start();
require '../../db/db.php';
require '../../db/db_connect.php';
$room = $_POST['room'];
$minusmsg = $_POST['minusmsg'];
if (!isset($minusmsg)) {
    $minusmsg = 50;
}
$r_token = $_SESSION['token'];

// Getting Setting Data
$sql = "SELECT * FROM `settings` WHERE `token`='$r_token'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $default_show_message = $row['default_show_message'];
    $default_pre_message = $row['default_pre_message'];
}

$sql = "SELECT * FROM `msgs2` WHERE `room`='$room'";
$result = mysqli_query($conn, $sql);
$totalrows = mysqli_num_rows($result);
if ($minusmsg >= $totalrows) {
    echo '<div class="time my-3">Room Created.</div>';
    $minusmsg = $totalrows;
} else {
    echo '<div class="time my-3" onclick="minusmsgPlus(' . $default_pre_message . ')">Read Previous ' . $default_pre_message . ' Messages</div> ';
}
// echo $totalrows;
$limitrows = $totalrows - $minusmsg;
// echo $minusmsg;
$sql = "SELECT * FROM `msgs2` WHERE `room`='$room' ORDER BY `sno` LIMIT $limitrows,$totalrows;";
$res = "";
$index = 0;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['token'] == "admin") {
            if ($row['token'] == $r_token) {
                $res = $res . '<div class="msg right-msg">';
                $res = $res . '<div class="msg-bubble">';
                $res = $res . '<div class="msg-info">';
                $res = $res . '<div class="msg-info-name adminYou">You</div>';
                $res = $res . '<div class="msg-info-time">' . $row['stime'] . '</div>';
                $res = $res . ' </div>';
                $res = $res . ' <div class="msg-text">' . $row['msg'] . '</div></div>';
                $res = $res . ' </div>';
            } else {
                $res = $res . '<div class="msg left-msg">';
                $res = $res . '<div class="msg-bubble">';
                $res = $res . '<div class="msg-info">';
                $res = $res . '<div class="msg-info-name admin">ADMIN</div>';
                $res = $res . '<div class="msg-info-time">' . $row['stime'] . '</div>';
                $res = $res . '</div>';
                $res = $res . '<div class="msg-text">' . $row['msg'] . '</div>';
                $res = $res . '</div>';
                $res = $res . '</div>';
            }
        } else if ($row['token'] == $r_token) {
            if ($row['type'] == "join") {
                $res = $res . '<div class="time my-3">You Joined The Room</div>';
            } else if ($row['type'] == "leave") {
                $res = $res . '<div class="time my-3">You Leaved The Room</div>';
            } else if ($row['type'] == "msg") {
                $res = $res . '<div class="msg right-msg" ondblclick="showOptions(this.childNodes[0].childNodes[0].childNodes[1].value)">';
                $res = $res . '<div class="msg-bubble">';
                $res = $res . '<div class="msg-info">';
                $res = $res . '<div class="msg-info-name">You</div>';
                $res = $res . '<input type="hidden" value="' . $row['sno'] . '" id="sno" name="sno">';
                $res = $res . '<div class="msg-info-time">' . $row['stime'] . '</div>';
                $res = $res . ' </div>';
                $res = $res . ' <div class="msg-text">' . $row['msg'] . '</div></div>';
                $res = $res . ' </div>';
            }
        } else {
            if ($row['type'] == "join") {
                $res = $res . '<div class="time my-3">' . $row['msg'] . '</div>';
            } else if ($row['type'] == "leave") {
                $res = $res . '<div class="time my-3">' . $row['msg'] . '</div>';
            } else if ($row['type'] == "msg") {
                $res = $res . '<div class="msg left-msg">';
                $res = $res . '<div class="msg-bubble">';
                $res = $res . '<div class="msg-info">';
                $res = $res . '<div class="msg-info-name"><a href="profile.php?token=' . $r_token . '&ptoken=' . $row['token'] . '&room=' . $room . '">' . $row['name'] . '</a></div>';
                $res = $res . '<div class="msg-info-time">' . $row['stime'] . '</div>';
                $res = $res . '</div>';
                $res = $res . '<div class="msg-text">' . $row['msg'] . '</div>';
                $res = $res . '</div>';
                $res = $res . '</div>';

                $sno = $row['sno'];

                $sqlofmsgseen = "SELECT * FROM `msgseen` WHERE `token`='$r_token' and `msgsno`='$sno';";
                $resultofmsgseen = mysqli_query($conn, $sqlofmsgseen);
                if ($resultofmsgseen) {
                    if (mysqli_num_rows($resultofmsgseen) == 0) {
                        $sqlofinsertmsgseen = "INSERT INTO `msgseen`(`msgsno`, `token`) VALUES ('$sno', '$r_token')";
                        $resultofinsertmsgseen = mysqli_query($conn, $sqlofinsertmsgseen);
                        if ($resultofinsertmsgseen) {
                        } else {
                        }
                    }
                }
            }
        }
    }
}

echo $res;

// echo '
//         <div class="time">' . $row['msg'] . '</div>
//     ';