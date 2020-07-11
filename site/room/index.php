<?php
session_start();

require "../../db/db_connect.php";
require "../../db/db.php";
$token = $_SESSION['token'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$roomname = $_SESSION['roomname'];
$pass = $_SESSION['pass'];
if ($token) {
    if ($pass) {
        $sql = "SELECT * FROM `rooms2` WHERE roomname='$roomname'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['password'] == $pass) {
            } else {
?>
                <script>
                    alert("Room Password Is Incorect")
                </script>
        <?php
                header("location: ../home/");
            }
        }
    }
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $roomname = $_SESSION['roomname'];
    $token = $_SESSION['token'];
    $sql = "SELECT * FROM `rooms2` WHERE roomname='$roomname';";
    $result = mysqli_query($conn, $sql);
    if ($token == "admin") {
        $warning = false;
    } else {
        $warning = false;
    }
    $msg = "Due to Hit Request Issue, The Chat System Is Closed Temporary but You Can Read Previous Chats. The Chat System will Start Shortly";
    if (mysqli_num_rows($result) == 0) {
        ?>
        <script>
            alert("This room Is not exists.");
            location.href = "../home/"
        </script>
<?php
    } else {
        // if ($token !== "admin") {
        //     $ip = $_SERVER['REMOTE_ADDR'];
        //     $sql = "INSERT INTO `msgs`(`room`, `msg`, `name`, `email`, `ip`, `type`, `token`) VALUES ('$roomname','$username Joined The Room','$username','$email','$ip','join','$token')";
        //     $result = mysqli_query($conn, $sql);
        //     if ($result) {
        //     } else {
        //     }
        // }
    }
    if (isset($_POST['disconnect'])) {
        if ($token == "admin") {
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
            $sql = "INSERT INTO `msgs2`(`room`, `msg`, `name`, `email`, `ip`, `type`, `token`) VALUES ('$roomname','$username Leaved The Room','$username','$email','$ip','leave','$token')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            } else {
            }
            $sql = "UPDATE `emaillogin` SET `currentroom`='' WHERE `token`='$token'";
            $result = mysqli_query($con, $sql);
            header("location: ../home/");
        }
    }


    $sqlofsetting = "SELECT * FROM `settings` WHERE `token`='$token'";
    $resultofsetting = mysqli_query($conn, $sqlofsetting);
    $rowofsetting = mysqli_fetch_assoc($resultofsetting);
    $default_show_message = $rowofsetting['default_show_message'];
    $default_pre_message = $rowofsetting['default_pre_message'];
    $run_time = $rowofsetting['run_time'];
    echo $run_time;
}




?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Chat Room</title>

    <?php require '../../link/links.html'; ?>
    <!-- Favicons -->
    <link rel="icon" href="img/icon1.png" sizes="32x32" type="image/png">
    <link rel="icon" href="img/icon1.png" sizes="16x16" type="image/png">
    <meta name="theme-color" content="#563d7c">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            document.getElementsByClassName("msger-chat")[0].scrollTo(0, 99999999999999999999999);
        }
    </script>

    <link rel="stylesheet" href="../../css/room.css">
</head>


<body>

    <section class="msger">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" style="text-transform: capitalize;"><?php echo $roomname; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <?php
                        if ($warning == true) {
                        ?>
                        <?php
                        } else {
                        ?>
                            <button class="btn btn-warning btn-sm mx-1 text-white my-2 muteButton inactive" id="muteButton" onclick="muteToggle()">Mute</button>
                        <?php
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-warning btn-sm mx-1 my-2 text-white" data-toggle="modal" data-target="#joiners">
                            Joiners
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-info btn-sm mx-1 my-2 text-white" data-toggle="modal" data-target="#info">Info</button>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <form action="" method="POST">
                        <button class="btn btn-warning btn-sm" name="disconnect">Disconnect</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="modal fade" id="joiners" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Joiners</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $sql = "SELECT * FROM `emaillogin` WHERE `currentroom`='$roomname'";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $joinertoken = $row['token'];
                            if ($joinertoken == $token) {
                                echo '
                                    <div style="display: flex;" class="my-2">
                                        <p class="circle-green my-1"></p><p class="mx-2">You</p>
                                    </div>
                                    ';
                            } else {
                                echo '
                                    <div style="display: flex;" class="my-2">
                                        <p class="circle-green my-1"></p><p class="my-2 mx-1">' . $row['Username'] . ' - ' . $row['email'] . '</p>
                                    </div>
                                    ';
                            }
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="info" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $sql = "SELECT * FROM `room` WHERE `roomname`='$roomname'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $roompassword = $row['password'];
                        $roomtype = $row['type'];
                        $roomowner = $row['owner'];
                        $sql = "SELECT * FROM `emaillogin` WHERE `token`='$roomowner'";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $roomownerusername = $row['Username'];
                        $roomowneremail = $row['email'];
                        $roomownerstatus2 = $row['status2'];

                        echo '
                            <h4>Room Information: </h4>
                            <div class="ml-4 text-muted">
                                <h6 style="text-transform: capitalize;">Room Name: ' . $roomname . '<h6>
                                <h6>Room Password: ' . $roompassword . '<h6>
                                <h6 style="text-transform: capitalize;">Room Type : ' . $roomtype . '<h6>
                            </div>
                            <hr>
                            <h4>Owner Information: </h4>
                            <div class="ml-4 text-muted">
                                <h6 style="text-transform: capitalize;">Room Owner: ' . $roomownerusername . '<h6>
                                <h6>Owner Email: ' . $roomowneremail . '<h6>
                                <h6 style="text-transform: capitalize;">Owner Status: ' . $roomownerstatus2 . '<h6>
                            </div>
                        ';
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalDiv"></div>
        <div id="warning">
            <?php
            if ($warning == true) {
                echo '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> Dear ' . $username . ', ' . $msg . '.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
            }
            ?>
        </div>
        <main class="msger-chat"> </main>
        <div class="msger-inputarea">
            <?php
            if ($warning == true) {
            ?>
                <input type="text" class="msger-input form-control" id="usermsg" placeholder="Enter your message..." disabled="">
                <button type="submit" class="msger-send-btn" id="submitmsg" disabled="">Send</button>
            <?php
            } else {
            ?>
                <input type="text" class="msger-input form-control" id="usermsg" placeholder="Enter your message...">
                <button id="emoji-button" style="width: 40px; background-image: url(../../img/emoji.png); background-size: cover;"></button>
                <button type="submit" class="msger-send-btn" id="submitmsg">Send</button>
                <script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.1.1/dist/index.min.js"></script>
                <script>
                    var input = document.getElementById('usermsg');
                    const button = document.querySelector('#emoji-button');
                    var picker = new EmojiButton()

                    picker.on('emoji', emoji => {
                        document.querySelector('#usermsg').value += emoji;
                    });

                    button.addEventListener('click', () => {
                        picker.togglePicker(button);
                    });
                </script>
            <?php
            }
            ?>
        </div>
    </section>
    <!-- <button class="scrollDown" onclick="scrollDown()">
        <i class="fas fa-angle-down" id="arrow"></i>
    </button> -->
    <?php require '../../link/footer.html'; ?>

    <?php
    if ($warning == true) {
    ?>
        <script>
            var minusmsg = <?php echo $default_show_message; ?>;
            runFunction();
            var warningDiv = document.getElementById("warning")
            setTimeout(() => {
                warningDiv.innerHTML = "";
            }, 10000)
            var runTime = 3000;
            $('.msger-chat').animate({
                scrollTop: 99999999999999999999999999
            }, "fast");
            var now = new Date()
            var date = now.getDate()
            var month = now.getMonth()
            var hour = now.getHours()
            var minute = now.getMinutes()
            if (hour > 12) {
                hour = hour - 12
                hour = "0" + hour
            } else if (hour < 10) {
                hour = "0" + hour
            } else {
                hour = hour
            }
            if (minute < 10) {
                minute = "0" + minute
            } else {
                minute = minute
            }
            if (date < 10) {
                date = "0" + date
            } else {
                date = date
            }
            var time = date + "-" + ++month + " " + hour + ":" + minute
            // setInterval(runFunction, runTime)

            function runFunction() {
                var post = $.post("htcont.php?token=<?php echo $token; ?>", {
                        room: '<?php echo $roomname; ?>',
                        ip: '<?php echo $_SERVER['REMOTE_ADDR']; ?>',
                        name: '<?php echo $username; ?>',
                        email: '<?php echo $email; ?>',
                        token: '<?php echo $token; ?>',
                        minusmsg: minusmsg
                    },
                    function(data, status) {
                        document.getElementsByClassName('msger-chat')[0].innerHTML = data;
                    }
                );

            }

            var input = document.getElementById("usermsg");

            input.addEventListener("keyup", function(event) {
                event.preventDefault();
                if (event.keyCode === 13) {
                    document.getElementById("submitmsg").click();
                }
            })
            $("#submitmsg").click(function() {
                warningDiv.innerHTML = `
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Warning!</strong> Dear ` + <?php echo $username; ?> + `,` + <?php echo $msg ?> + `.
                        <button type="button" class="close" id="warning_close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`

                setTimeout(() => {
                    warningDiv.innerHTML = "";
                }, 6000)
            })

            function warning_close() {
                warningDiv.innerHTML = "";
            }

            function minusmsgPlus(val) {
                minusmsg += val;
                runFunction()
                console.log(minusmsg)
            }
        </script>
    <?php
    } else {
    ?>
        <script>
            var minusmsg = <?php echo $default_show_message; ?>;
            runFunction();
            var interval;
            var warningDiv = document.getElementById("warning")
            var runTime = <?php echo $run_time * 1000; ?>;
            $('.msger-chat').animate({
                scrollTop: 99999999999999999999999999
            }, "fast");
            var now = new Date()
            var date = now.getDate()
            var month = now.getMonth()
            var hour = now.getHours()
            var minute = now.getMinutes()
            if (hour > 12) {
                hour = hour - 12
                hour = "0" + hour
            } else if (hour < 10) {
                hour = "0" + hour
            } else {
                hour = hour
            }
            if (minute < 10) {
                minute = "0" + minute
            } else {
                minute = minute
            }
            if (date < 10) {
                date = "0" + date
            } else {
                date = date
            }
            var time = date + "-" + ++month + " " + hour + ":" + minute
            interval = setInterval(runFunction, runTime)

            function runFunction() {
                var post = $.post("htcont.php", {
                        room: '<?php echo $roomname; ?>',
                        ip: '<?php echo $_SERVER['REMOTE_ADDR']; ?>',
                        name: '<?php echo $username; ?>',
                        email: '<?php echo $email; ?>',
                        token: '<?php echo $token; ?>',
                        minusmsg: minusmsg
                    },
                    function(data, status) {
                        document.getElementsByClassName('msger-chat')[0].innerHTML = data;
                    }
                );
            }


            var input = document.getElementById("usermsg");

            input.addEventListener("keyup", function(event) {
                event.preventDefault();
                if (event.keyCode == 13) {
                    document.getElementById("submitmsg").click();
                }
            })

            $("#submitmsg").click(function() {
                var clientmsg = $("#usermsg").val();
                // console.log(clientmsg.length);

                if (!clientmsg == "") {
                    if (clientmsg.length > 1200) {
                        alert("The Message is Too Long. Try To make It Shorter")
                    } else {
                        $.post("postmsg.php", {
                                text: clientmsg,
                                room: '<?php echo $roomname; ?>',
                                ip: '<?php echo $_SERVER['REMOTE_ADDR']; ?>',
                                name: '<?php echo $username; ?>',
                                email: '<?php echo $email; ?>',
                                token: '<?php echo $token; ?>',
                                time: time
                            },
                            function(data, status) {
                                document.getElementsByClassName('msger-chat')[0].innerHTML += data;
                            }
                        )
                        $('.msger-chat').animate({
                            scrollTop: 9999999999999999999999999
                        }, "fast");
                        $("#usermsg").val("");
                    }
                } else {}
            })

            function muteToggle() {
                var muteButton = document.getElementById('muteButton')
                if (muteButton.classList.contains("inactive")) {
                    muteButton.classList.remove("inactive")
                    muteButton.classList.add("active")
                    clearInterval(interval)
                    muteButton.innerHTML = "Muted"
                } else {
                    muteButton.classList.remove("active")
                    muteButton.classList.add("inactive")
                    interval = setInterval(runFunction, runTime)
                    muteButton.innerHTML = "Mute"
                    runFunction()
                }
            }

            var showOptionsModal;

            let showOptions = function(sno) {
                document.getElementById('modalDiv').innerHTML = `
                    <div class="modal fade" tabindex="-1" id="showOptions">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">What Do You Want?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <button type="button" class="btn btn-danger" onclick="deletemsg(` + sno + `)">Delete Message</button>

                                    <br><br>

                                    <button type="button" class="btn btn-info" onclick="msginfo(` + sno + `)">Message Info</button>
                                </div>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    </div>
                `;
                showOptionsModal = new bootstrap.Modal(document.getElementById('showOptions'))
                showOptionsModal.show()
            }

            function deletemsg(sno) {
                $.post("deletemsg.php", {
                        sno: sno,
                    },
                    function(data, status) {
                        runFunction();
                    }
                )
                showOptionsModal.hide()
            }

            function msginfo(sno) {
                showOptionsModal.hide()
                document.getElementById('modalDiv').innerHTML = `
                    <div class="modal fade" tabindex="-1" id="messageinfo">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Message Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4>Seen By:</h4>
                                    <div class="ml-3" id="messageinfobodydiv">
                                        ` +
                    $.post("seenby.php", {
                            sno: sno
                        },
                        function(data, status) {
                            document.getElementById('messageinfobodydiv').innerHTML = data;
                        }
                    ) +
                    `
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    </div>
                `;

                messageinfomodal = new bootstrap.Modal(document.getElementById('messageinfo'))
                messageinfomodal.show()
            }

            function minusmsgPlus(val) {
                minusmsg += val;
                runFunction()
                console.log(minusmsg)
            }
        </script>
    <?php
    }
    ?>
</body>

</html>