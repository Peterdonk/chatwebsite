<?php
session_start();
$token = $_SESSION['token'];

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Friend Requests</title>
    <style>
        .options {
            display: flex;
        }
    </style>
</head>

<body>
    <?php require '../../partials/_header.html'; ?>


    <?php

    require "../../db/db.php";
    require "../../db/db_connect.php";

    $tableHtml = '<table class="table my-1">
    <thead class="thead-dark">
    <tr>
    <th scope="col">#</th>
    <th scope="col">Username</th>
    <th scope="col">Email</th>
    <th scope="col">Options</th>
    </tr>
    </thead>
    <tbody>
    ';

    echo $tableHtml;
    $html = "";
    $index = 1;
    $sql = "SELECT * FROM `friendreq` WHERE toreq='$token' and `status`='pending'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fromtoken = $row['fromreq'];
            $sql2 = "SELECT * FROM `emaillogin` WHERE `token`='$fromtoken'";
            $result2 = mysqli_query($con, $sql2);
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $html = '
                <tr>
                    <th scope="row">' . $index . '</th>
                    <td>' . $row2['Username'] . '</td>
                    <td>' . $row2['email'] . '</td>
                    <td class="options">
                        <form action="acceptreq.php?ptoken=' . $row2['token'] . '&token=' . $token . '" method="POST">
                            <button class="btn btn-success btn-sm mx-1">Accept</button>
                        </form>
                        <form action="declinereq.php?ptoken=' . $row2['token'] . '&token=' . $token . '" method="POST">
                            <button class="btn btn-danger btn-sm mx-1">Decline</button>
                        </form>
                    </td>
                </tr>
            ';
            }
        }
    } else {
        echo '
    </tbody>
    </table>
    <h5 class="text-muted text-center">No Friend Request Yet</h5>
    ';
    }
    echo $html;
    echo '
    </tbody>
    </table>
';

    ?>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>