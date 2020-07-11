<?php
session_start();

if ($_SESSION['token'] == "admin") {
    require '../../db/db_connect.php';
    require '../../db/db.php';
} else {
    header("location: ../home/");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php require '../../link/links.html' ?>

    <!-- <link rel="stylesheet" href="../../css/room.css"> -->
    <style>
        :root {
            --body-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            --msger-bg: #fff;
            --border: 2px solid #ddd;
            --left-msg-bg: #ececec;
            --right-msg-bg: #579ffb;
        }

        .msg {
            display: flex;
            align-items: flex-end;
            margin-bottom: 10px;
        }

        .msg:last-of-type {
            margin: 0;
        }

        .msg-img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            background: #ddd;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            border-radius: 50%;
        }

        .msg-bubble {
            max-width: 100%;
            max-height: 300px;
            overflow-y: scroll;
            padding: 15px;
            border-radius: 15px;
            background: var(--left-msg-bg);
        }

        .msg-info {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
        }

        .msg-info-name {
            margin-right: 10px;
            font-weight: bold;
        }

        .msg-info-time {
            font-size: 0.85em;
        }

        .left-msg .msg-bubble {
            border-bottom-left-radius: 0;
        }

        .right-msg {
            flex-direction: row-reverse;
        }

        .right-msg .msg-bubble {
            background: var(--right-msg-bg);
            color: #fff;
            border-bottom-right-radius: 0;
        }

        .right-msg .msg-img {
            margin: 0 0 0 10px;
        }

        .msg-text {
            word-wrap: break-word;
        }

        .tableinfo {
            display: flex;
        }

        .tableinfoI {
            display: flex;
        }
    </style>

    <title>Public Feedback For Admin Only</title>
</head>

<body>

    <?php require '../../partials/_header.html'; ?>

    <div class="container my-2">

        <div class="tableinfo" id="tableinfo">
            <div class="tableinfoI mx-3 text-muted">
                <h5 class="text-muted">Total Feedback: </h5>
                <h5 class="mx-2"><?php
                                    $sql = "SELECT * FROM `contactus`";
                                    $result = mysqli_query($conn, $sql);
                                    echo mysqli_num_rows($result);

                                    ?></h5>
            </div>

            <div class="tableinfoI mx-3 text-muted">
                <h5 class="text-muted">Pending Feedback: </h5>
                <h5 class="mx-2"><?php
                                    $sql = "SELECT * FROM `contactus` WHERE `status`='pending'";
                                    $result = mysqli_query($conn, $sql);
                                    echo mysqli_num_rows($result);

                                    ?></h5>
            </div>

            <div class="tableinfoI mx-3 text-muted">
                <h5 class="text-muted">Seen Feedback: </h5>
                <h5 class="mx-2"><?php
                                    $sql = "SELECT * FROM `contactus` WHERE `status`='seen'";
                                    $result = mysqli_query($conn, $sql);
                                    echo mysqli_num_rows($result);

                                    ?></h5>
            </div>

            <div class="tableinfoI mx-3 text-muted">
                <h5 class="text-muted">Mailed Feedback: </h5>
                <h5 class="mx-2"><?php
                                    $sql = "SELECT * FROM `contactus` WHERE `status`='mailed'";
                                    $result = mysqli_query($conn, $sql);
                                    echo mysqli_num_rows($result);

                                    ?></h5>
            </div>

            <div class="tableinfoI mx-3 text-muted">
                <h5 class="text-muted">Pending Rate: </h5>
                <h5 class="mx-2"><?php
                                    $sqloftotalfeedback = "SELECT * FROM `contactus`";
                                    $resultoftotalfeedback = mysqli_query($conn, $sqloftotalfeedback);
                                    $rowoftotalfeedback = mysqli_num_rows($resultoftotalfeedback);
                                    // echo mysqli_num_rows($resultoftotalfeedback)
                                    $sqlofpendingfeedback = "SELECT * FROM `contactus` WHERE `status`='pending'";
                                    $resultofpendingfeedback = mysqli_query($conn, $sqlofpendingfeedback);
                                    $rowofpendingfeedback = mysqli_num_rows($resultofpendingfeedback);

                                    // tot -> 100%
                                    // pen -> ?

                                    // echo $rowofpendingfeedback;
                                    // echo "<br>";
                                    // echo $rowoftotalfeedback;
                                    if ($rowofpendingfeedback != "0" || $rowoftotalfeedback != "0") {
                                        $rateofpending = ($rowofpendingfeedback * 100) / ($rowoftotalfeedback);
                                    } else {
                                        $rateofpending = "100";
                                    }
                                    echo $rateofpending . "%"



                                    ?></h5>
            </div>
        </div>


        <!-- <div class="msg right-msg">
            <div class="msg-bubble">
                <div class="msg-info">
                    <div class="msg-info-name"></div>
                    <div class="msg-info-time"></div>
                    <div class="msg-text"></div>
                </div>
            </div>
        </div> -->

        <?php

        $sql = "SELECT * FROM `contactus` WHERE `status`='pending' ORDER BY `sno` DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $sno = $row['sno'];
                $username = $row['username'];
                $email = $row['email'];
                $usertoken = $row['token'];
                $time = $row['time'];
                $query = $row['query'];

                echo '
                    <div class="msg right-msg">
                        <div class="msg-bubble">
                            <div class="msg-info">
                                <div class="msg-info-name">' . $username . '</div>- 
                                <div class="msg-info-name mx-1">' . $email . '</div>-
                                <div class="msg-info-name mx-1">' . $usertoken . '</div>
                                <div class="msg-info-time mx-4">' . $time . '</div>
                                <div>
                                    <a href="sendmail.php?token=' . $usertoken . '&email=' . $email . '&username=' . $username . '&q=' . $query . '&sno=' . $sno . '" class="btn btn-success btn-sm">Send Mail</a>
                                    <a href="seen.php?token=' . $usertoken . '&email=' . $email . '&username=' . $username . '&sno=' . $sno . '" class="btn btn-success btn-sm">Seen</a>
                                </div>
                                </div>
                            <div class="msg-text">' . $query . '</div>
                        </div>
                    </div>
                ';
            }
        } else {
            echo '<h4 class="text-muted text-center my-5">No Feedback Found</h4>';
        }



        ?>
    </div>


    <?php require '../../link/footer.html' ?> </body>


</html>