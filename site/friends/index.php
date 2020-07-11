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
    <?php require '../../link/links.html' ?>

    <title>Friends!</title>
</head>

<body>

    <?php require '../../partials/_header.html'; ?>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require "../../db/db.php";
            require "../../db/db_connect.php";
            $html = "";
            $index = 1;
            if (isset($token)) {
                $sql = "SELECT * FROM `friends` WHERE `token`='$token'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $friendtoken = $row['friendtoken'];
                        $sql2 = "SELECT * FROM `emaillogin` WHERE `token`='$friendtoken'";
                        $result2 = mysqli_query($con, $sql2);
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            echo '
                                <tr>
                                    <th scope="row">' . $index . '</th>
                                    <td>' . $row2['Username'] . '</td>
                                    <td>' . $row2['email'] . '</td>
                                    <td>' . $row2['status2'] . '</td>
                                </tr>
                            ';

                            $index += 1;
                        }
                    }

                    echo '
                        </tbody>
                        </table>
                    ';
                } else {
                    echo '
                        </tbody>
                        </table>
                        <h3 class="text-muted text-center">No Friends Found</h3>
                    ';
                }
            }



            ?>






            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <?php require '../../link/footer.html' ?>
</body>

</html>


<!-- <tr>
    <th scope="row">' . $index . '</th>
    <td>' . $row2['Username'] . '</td>
    <td>' . $row2['email'] . '</td>
    <td>' . $row2['status2'] . '</td>
</tr> -->