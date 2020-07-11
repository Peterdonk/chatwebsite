<?php

$token = $_GET['token'];

?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        .type {
            text-transform: capitalize;
        }
    </style>

    <title>My Rooms</title>
</head>

<body>

    <?php require 'partials/_header.html'; ?>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Room Name</th>
                <th scope="col">Type</th>
                <th scope="col">Password</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require "db.php";
            require "db_connect.php";
            $token = $_GET['token'];
            if ($token) {
                $sql = "SELECT * FROM `rooms2` WHERE `owner`='$token'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $index = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['password'] == "") {
                            $pass = "-";
                        } else {
                            $pass = $row['password'];
                        }
                        echo '
                        <tr>
                            <form action="deleteroom.php?roomname=' . $row['roomname'] . '&token=' . $token . '" method="POST">
                                <th scope="row">' . $index . '</th>
                                <td>' . $row['roomname'] . '</td>
                                <td class="type">' . $row['type'] . '</td>
                                <td>' . $pass . '</td>
                                <td class="options">
                                    <input class="btn btn-danger btn-sm" type="submit" value="Delete Room">
                                </td>
                            </form>
                        </tr>
                        ';
                        $index += 1;
                    }
                } else {
                    echo '
                    </tbody>
                    </table>
                    <h5 class="text-muted text-center">No Rooms Created Yet</h5>
                    ';
                }
            }
            ?>

        </tbody>
    </table>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>