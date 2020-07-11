<?php
session_start();

$token = $_SESSION['token'];
$peopleName = $_POST['friendName'];
?>




<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <?php require '../../link/links.html'; ?>


    <title>Search For - <?php echo $peopleName; ?></title>

</head>

<body>

    <?php require '../../partials/_header.html' ?>

    <?php

    require "../../db/db.php";
    require "../../db/db_connect.php";

    $token = $_SESSION['token'];
    $tableHtml = '<table class="table">
    <thead class="thead-dark">
    <tr>
    <th scope="col">#</th>
    <th scope="col">Username</th>
    <th scope="col">Email</th>
    <th scope="col">Status</th>
    <th scope="col">Options</th>
    </tr>
    </thead>
    <tbody>
    ';

    echo $tableHtml;
    $html = "";
    $index = 1;
    $match = false;
    $popleName = $_POST['friendName'];
    $sql = "SELECT * FROM emaillogin WHERE Username='$popleName'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $peopletoken = $row['token'];
            $sql2 = "SELECT * FROM `friendreq` WHERE `toreq`='$peopletoken' and `status`='pending'";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                echo '
                    <tr>
                        <th scope="row">' . $index . '</th>
                        <td>' . $row['Username'] . '</td>
                        <td>' . $row['email'] . '</td>
                        <td>' . $row['status2'] . '</td>
                        <td class="text-muted"><i>Friend Request In Pending</i></td>
                    </tr>
                ';
                $index += 1;
            } else {
                $sql3 = "SELECT * FROM `friends` WHERE `token`='$token' and `friendtoken`='$peopletoken'";
                $result3 = mysqli_query($conn, $sql3);
                if (mysqli_num_rows($result3) > 0) {
                    echo '
                        <tr>
                            <th scope="row">' . $index . '</th>
                            <td>' . $row['Username'] . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['status2'] . '</td>
                            <td class="text-muted"><i>You Are Already Friend</i></td>
                        </tr>
                    ';
                    $index += 1;
                } else {
                    echo '
                        <tr>
                            <th scope="row">' . $index . '</th>
                            <td>' . $row['Username'] . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['status2'] . '</td>
                            <form action="addfriend.php?ptoken=' . $row['token'] . '&token=' . $token . '" method="POST">
                                <td><button type="submit" class="btn btn-success btn-sm">Add Friend</button></td>
                            </form>
                        </tr>
                    ';
                    $index += 1;
                }
            }
        }
    } else {
        $html = '
        </tbody>
        </table>
        <h5 class="text-muted text-center">No User Found</h5>
        ';
    }
    echo "
    </tbody>
    </table>
";


    ?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <?php require '../../link/footer.html'; ?>
</body>

</html>




<!-- <tr>
    <th scope="row">' . $index . '</th>
    <td>' . $row['Username'] . '</td>
    <td>' . $row['email'] . '</td>
    <td>' . $row['status2'] . '</td>
    <form action="addfriend.php?ptoken=' . $row['token'] . '&token=' . $token . '" method="POST">
        <td><button type="submit" class="btn btn-success btn-sm">Add Friend</button></td>
    </form>
</tr> -->