<?php
session_start()
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="stylesheet.css">

    <title>Terms & Conditions</title>
</head>

<body>

    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark" style="width: 100%;">
        <img src="worldNewsLogo3.png" class="d-inline-block align-top" id="worldNewsLogo" alt="World News">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="main.php?token=<?php echo $_SESSION['token'] ?>" onclick="mainHome()">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="termsnConditions.php?token=<?php echo $_SESSION['token'] ?>">Terms &
                        Conditions</a>
                </li>
            </ul>
        </div>
    </nav>
    <br><br><br><br>


    <div class="container text-muted">
        <u>
            <h2>TERMS & CONDITION</h2>
        </u>
        <br>
        <div class="container">
            <div class="container">
                <p>
                    Hi, I am Henil and I am The Owner Of <a href="index.php">wispychat.epizy.com</a>. I
                    made This Website For Poeple Who Are Very Active on Internate So they Can Chat With Friends With Some Extraordinoury UI Degine.We are Providing real Time Chating Experiance.
                </p>

                <u>
                    <h4 class="my-5">What We can Access From Your Device or Account?</h4>
                </u>
                <ul>
                    <li>
                        We are Using Your Email Address For Sending Mail To check that the User Who Filling Sign Up Form Is You.
                    </li>
                    <li>
                        We are Using Your Username For Your Better Experince.
                    </li>
                    <li>
                        We are Using Your Mobile Number in Case of Immergency.
                    </li>
                    <li>
                        We are Using Cookie For Your better Experince.
                    </li>
                    <li>
                        We are Traking Your real Time Status On Wispychat.
                    </li>
                </ul>

                <u id="how-to-use">
                    <h4 class="my-5">How to Use?</h4>
                </u>
                <ul>
                    <li>
                        Simply Open <a href="main.php">wispychat.epizy.com</a> Join To Us With Creating a Account.
                    </li>
                    <li>
                        Now The System will Send You A Email To You Entered email Account To Activate Your Account.
                    </li>
                    <li>
                        In The Email There is a Link To activate Your Account, Just Click On the Link, Your Account Will Automatically Activate Your Account and Redirect to Login Page.
                    </li>
                    <li>
                        Now Login To Your Account It will Redirect To Our Home Page.
                    </li>
                    <li>
                        There You can Create Your Own Room Or Join Your Friend's Room It's Your Choice.
                    </li>
                    <li>
                        Now If Your Are Creating Your Own Room Just Give A Room Name To Your Friend So They Also Can Join You And Chat Togather.
                    </li>
                    <li>
                        And If Your Are Joining Your Friend's Room Just Enter A Room Name Given By Your Friend.
                    </li>
                </ul>

                <u>
                    <h4 class="my-5">FAQ's:</h4>
                </u>
                <ul>
                    <h5>Que 1. Is My Passwords Secure?</h5>
                    <li>
                        Yes, We are store Your Password In Encypted Form Even I also cannot read that password. So Your Password is always secure.
                    </li>
                    <br>

                </ul>
            </div>
        </div>

        <br><br>
    </div>




    <script src="index.js"></script>

</body>


</html>