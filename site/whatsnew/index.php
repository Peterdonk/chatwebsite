<?php
session_start();
$token = $_SESSION['token'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <?php require '../../link/links.html' ?>

    <title>What's New - Wispy Chat</title>

    <!-- styleSheet -->
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
    <?php require '../../partials/_header.html'; ?>

    <br><br><br>
    <div class="container">

        <div class="newDiv my-3">
            <hr style="height: 2px; background-color: lightgrey;">

            <h4><strong>Updated at:</strong> 12 June 2020</h4>
            <br>

            <ul>
                <li> Now User Have Option to Make his Room Private or Public.</li>
                <li> Now You Can Delete Your Made Rooms.</li>
                <li> Added The List of Top Public Room At 'Join Room' Page.</li>
            </ul>

            <br>
            <h6 class="card-subtitle mb-2 text-muted">New Update Comming Soon... <span style="color: lightseagreen;">Stay
                    Conected...</span>
            </h6>
            <hr style="height: 2px; background-color: lightgrey;">
        </div>



    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <?php require '../../link/footer.html' ?>

</body>

</html>