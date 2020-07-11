<?php

session_start();

?>


<!--
Author: Colorlib
Author URL: https://colorlib.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<head>

    <?php require '../link/links.html'; ?>
    <link rel="stylesheet" href="../css/style2.css">
    <title>SignUp Form</title>
    <style>
        .tnc {
            color: black;
            font-size: 16px;
        }

        .tnc:hover {
            color: blue;
        }
    </style>
</head>

<body>
    <?php

    if (!isset($_SESSION['msg']) || !isset($_SESSION['msgBg']) || !isset($_SESSION['msgTxt'])) {
        $_SESSION['msg'] = "Fill All Imformation";
        $_SESSION['msgBg'] = "info";
        $_SESSION['msgTxt'] = "white";
    }
    if (isset($_POST['submit'])) {
        require '../db/db.php';
        require '../db/db_connect.php';

        $username = mysqli_real_escape_string($con, $_POST['username']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

        $pass = password_hash($password, PASSWORD_BCRYPT);
        $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

        $token = bin2hex(random_bytes(15));

        $emailquery = "select * from emaillogin where email='$email'";
        $query = mysqli_query($con, $emailquery);

        $emailcount = mysqli_num_rows($query);

        if ($emailcount > 0) {
            $_SESSION['msg'] = "Email Already Exist";
            $_SESSION['msgBg'] = "danger";
            $_SESSION['msgTxt'] = "white";
        } else {
            if ($password === $cpassword) {
require "../phpmailer/class.phpmailer.php";

            $mail = new PHPMailer();
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = '_Your GamilId_';                     // SMTP username
            $mail->Password = '_Your Gmail Password_';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('Your Gmail Id', 'Wispychat');
            $mail->addAddress($email, "$username");     // Add a recipient
            $mail->isHTML(false);

            $mail->Subject = "Wispychat Account Activation";
            $mail->Body = "Hi $username, Click here to Activate Your Wispychat Account - wispychat.epizy.com/signup/activate.php?token=$token";

            if ($mail->send()) {
                $_SESSION['msg'] = "Check Your Mail At $email To Activate Your Wispychat Account Password";
                $sql = "INSERT INTO `settings`(`token`) VALUES('$token');";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $iqueary = mysqli_query($con, $insertquery);
                    if ($iqueary) {
                        header('location:../login/');
                    } else {
                        $_SESSION['msg'] = "Failed to Store Details Please Try Again";
                        $_SESSION['msgBg'] = "danger";
                        $_SESSION['msgTxt'] = "white";
                    }
                } else {
                    $_SESSION['msg'] = "Failed To Save Your Setting Data Please Try Agian";
                }
            } else {
                $_SESSION['msg'] = "Email Sending Failed At $email, Please Try Again";
            }
            } else {
                $_SESSION['msg'] = "Password Are not mathcing";
                $_SESSION['msgBg'] = "danger";
                $_SESSION['msgTxt'] = "white";
            }
        }
    }

    ?>
    <!-- main -->
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Icon -->
            <div class="fadeIn first my-2">
                <div class="bg-<?php echo $_SESSION['msgBg'] ?> text-<?php echo $_SESSION['msgTxt'] ?> fadeIn first">
                    <p class="px-2" style="width: 100%;"><?php if (isset($_SESSION['msg'])) {
                                                                echo $_SESSION['msg'];
                                                            } ?></p>
                </div>
            </div>

            <!-- Login Form -->
            <form action="" method="POST">
                <input type="text" id="username" class="fadeIn second" name="username" placeholder="Choose Username" required="">
                <input type="email" id="email" class="fadeIn third" name="email" placeholder="Email" required="">
                <input type="phone" id="mobile" class="fadeIn fourth" name="mobile" placeholder="Phone Number" required="">
                <input type="password" id="password" class="fadeIn fifth pass" name="password" placeholder="Choose Password" required="">
                <input type="password" id="cpassword" class="fadeIn sixth cpass" name="cpassword" placeholder="Repeat Password" required="">
                <i>
                    <p id="passmsg" class="passmsg"></p>
                </i>
                <br>
                <input type="checkbox" accesskey="m" id="checkbox" class="fadeIn seventh" name="tnc" required="">
                <a href="termsnConditions.php" class="tnc fadeIn seventh">Agree With Terms & Conditions</a>
                <br>
                <input type="submit" name="submit" class="fadeIn eighth" value="SIGN UP">
            </form>

        </div>
    </div>
    <!-- //main -->
    <?php require '../link/footer.html'; ?>

    <script>
        var cpassword = document.getElementById('cpassword')
        cpassword.addEventListener('input', () => {
            cpassword = document.getElementById('cpassword').value
            password = document.getElementById('password').value
            if (password == cpassword) {
                passMsg = "The Password Are Mathing Now";
                document.getElementById('passmsg').innerHTML = passMsg;
                document.getElementsByClassName('pass')[0].style.border = "0.5px solid green";
                document.getElementsByClassName('cpass')[0].style.border = "0.5px solid green";
                document.getElementsByClassName('passmsg')[0].style.color = "green";
                setTimeout(() => {
                    document.getElementsByClassName('pass')[0].style.border = "";
                    document.getElementsByClassName('cpass')[0].style.border = "";
                }, 1000);
            } else {
                passMsg = "The Password is not Matching";
                document.getElementById('passmsg').innerHTML = passMsg;
                document.getElementsByClassName('pass')[0].style.border = "0.5px solid red";
                document.getElementsByClassName('cpass')[0].style.border = "0.5px solid red";
                document.getElementsByClassName('passmsg')[0].style.color = "red";
            }
        })
    </script>
</body>

</html>




<!-- Desciption -->
<!-- 

<ul>
    <li>
        What Is Wispychat?
    </li>
</ul>
​<p>
           Wispychat Chat Is Chat Website Where You Can Chat With Your Friends By Creating a Room Or Join Your Friend's Room.​ 
</p>

<ul>
    <li>
        Why Choose Wispychat?
    </li>
</ul>
<p>
      Because Provides A Lots of Features And Stay Away Users From Security Issues.
</p>

 -->




<!-- Features -->
<!-- ​
<ul>
    <li>​Sign Up Functionality​ With Email Verification</li>
    <li>Sign In Functionality​</li>
    <li>Forgot Password Functionality​​ With Email Verification​</li>
    <li>Remember Me Functionality​</li>
    <li>Create Room Functionality​​</li>
    <li>Join Room Functionality​​</li>
    <li>Live Peoples Already Registered​, Rooms Created​, Massages Sent​, Peoples Are Online​ Functionality​</li>
    <li>Search Friend With Username Functionality​​</li>
    <li>Send a Friend Request Functionality​​</li>
    <li>Accept Or Decline​ Friend Request Functionality​</li>
    <li>Delete Your Room Functionality​</li>
    <li>Setting of Default Showing Message Functionality​</li>
    <li>Setting of Read Previous Message Functionality​</li>
    <li>Setting of Run Time To Get All Messages Frequently ​Functionality​</li>
    <li>Mute Room Functionality​</li>
    <li>Online Users In Room ( Joiners ) Functionality​</li>
    <li>Room And Owner's Information Functionality​</li>
    <li>Disconnect Room Functionality​</li>
    <li>Responsive Room</li>
    <li>Delete Your Messages Functionality</li>
    <li>What's New Page</li>
    <li>Logout System</li>
</ul>
-->


<!-- Requirements -->
<!-- 
​There Is No Any Requirements To Use It. It will Work in Any Device.
-->



<!-- Instruction -->
<!-- 
<ul>
    <li>
        <strong>How To Sign Up in WispyChat?</strong>
    </li>
</ul>
<p>
    First Open a Website Than Go To Sign Up Form. Now simply Fill The Required Fields. Now Click On Sign Up Button. It may Take Less Than 1 Minutes To Save Your Data In Data Base. When the Process Will Complete You Will Receive a Mail On Provided Email Address Now Click On the Link Provided In Mail To Verify Your Account.
</p>

<ul>
    <li>
        <strong>How To Sign In in WispyChat?</strong>
    </li>
</ul>
<p>
    To Login or Sign In In WispyChat Go To Login Page. There You Have To Enter Your Username And Corresponding Password. Now It May Take Less Than 10 Seconds Depending on Your Internet Speed. After That You will Redirect To Home Page.
</p>

<ul>
    <li>
        <strong>How To Create Room in WispyChat?</strong>
    </li>
</ul>
<p>
    To Create a Room In WispyChat First Login In WispyChat. After That It Will Redirect To Home Page. There You Can See Two Buttons: First 'Claim Room', Second 'Join Room'. Now Click On Claim Room. Now You Can See Input Box. Now Type Your decided Room Name. You Can Only Use Alphanumeric Character. When Your Room Will ready you can chat with anyone.
</p>


<ul>
    <li>
        <strong>How To Join Room in WispyChat?</strong>
    </li>
</ul>
<p>
    To Join a Room In WispyChat First Login In WispyChat. After That It Will Redirect To Home Page. There You Can See Two Buttons: First 'Claim Room', Second 'Join Room'. Now Click On Join Room. Now You Can See Input Box. Now Type Room Name. When Your Room Will ready you can chat with anyone.
</p>

<ul>
    <li>
        <strong>How To Send A Friend Request in WispyChat?</strong>
    </li>
</ul>
<p>
    To Send A Friend Request In WispyChat First Login In WispyChat. After That It Will Redirect To Home Page. Now Scroll Down Little. There You Can See Search User Input Box. Now Search The Username Of Your Friend. Now You Can See The List of People Whose Username is Matched with Your Given Search Username. Now Find Your Friend and click On Add Friend.Now The Friend Request Will Send To Your Friend.
</p>


<ul>
    <li>
        <strong>How To Accept Or Decline A Friend Request in WispyChat?</strong>
    </li>
</ul>
<p>
    To Accept or Decline a Friend Request You Have To In go In 'Friend Request' Link Provided In Navigation Bar. There You Can See a List of a Friend Requests Which Are Sent to You. There is Two Option Of Each Friend Request : 'Accept','Decline'. If You Click On Accept That Friend Will Add To Your Friend List. If You Click on Decline That Do Nothing And Friend Request Will Remove to your Friend Request List.
</p>


<ul>
    <li>
        <strong>How To Delete My Made Room in WispyChat?</strong>
    </li>
</ul>
<p>
    To Delete Your Made Room You Have To Go In 'My Rooms' Link Provided in Navigation Bar. There You can See a List of Your Made Rooms. There You Can Delete Your Room. Now Click on 'Delete'.
    <br>
    <strong>Note:</strong> If You Click On 'Delete' Button Your Room Messages Will Delete Permanently. There Is No Way To Recover It.
</p>


<ul>
    <li>
        <strong>How To Mute Chat Room in WispyChat?</strong>
    </li>
</ul>
<p>
    If You Want to Mute The Chat Room First, Connect With Any Room. If You Are in Computer or Laptop ( Big Screen ) You can See Various Option Like: 'Mute', 'Joiners', 'Info' and 'Disconnect'. But If You Are In Mobile Screen ( Small Screen ) You have To Click On Three Line in Navigation Bar. Now Click On 'Mute'. The Chat Will Mute It Means That If Anyone Message in That Room That Message Will Not Come to Your Screen And You Can Save Your Data. If You Want To Unmute The Chat Room Click on 'Muted' Button.
</p>


<ul>
    <li>
        <strong>How To See Online Peoples in WispyChat?</strong>
    </li>
</ul>
<p>
    If You Want to See Online Peoples First Join The Chat Room First, Connect With Any Room. If You Are in Computer or Laptop ( Big Screen ) You can See Various Option Like: 'Mute', 'Joiners', 'Info' and 'Disconnect'. But If You Are In Mobile Screen ( Small Screen ) You have To Click On Three Line in Navigation Bar. Now Click On 'Joiners'. There You Can See Online Peoples Of That Chat Room.
</p>


<ul>
    <li>
        <strong>How To See Room Information in WispyChat?</strong>
    </li>
</ul>
<p>
    If You Want to See Room Information First Join The Chat Room First, Connect With Any Room. If You Are in Computer or Laptop ( Big Screen ) You can See Various Option Like: 'Mute', 'Joiners', 'Info' and 'Disconnect'. But If You Are In Mobile Screen ( Small Screen ) You have To Click On Three Line in Navigation Bar. Now Click On 'Info'. There You Can See Room Information of That Chat Room.
</p>


<ul>
    <li>
        <strong>How To Read Previous Messages in WispyChat?</strong>
    </li>
</ul>
<p>
    To Read Previous Messages Of That Chat Room Scroll Top in Chat Box. The Top You Can See 'Read Previous + _Your Previous Message Setting Value_ + Messages'. Now Click On That. It will Show You More '_Your Previous Message Setting Value_' Messages.
</p>

<ul>
    <li>
        <strong>How To Delete Your Messages in WispyChat?</strong>
    </li>
</ul>
<p>
    To Delete Your Messages Double Click On Your Message. Now You Will See A Dialog Box. Now Click On 'Delete Message' And Your Message Will Delete.
</p>

<ul>
    <li>
        <strong>How To Change Settings in WispyChat?</strong>
    </li>
</ul>
<p>
    To Change Setting Go To Home Page. In The Navigation Bar You Can See 'Settings'. Click On That. Now You Can See Settings.To Change Settings, Change Value After That Make Sure To Save Data.
</p>

<ul>
    <li>
        <strong>How To Recover Password in WispyChat?</strong>
    </li>
</ul>
<p>
    To Recover Your Account Password, Go To Login Page. Now at The Bottom Of The Form You can See 'Forgot Password?'. Now Click On It. Now It will Ask a Email Address. Type a Email. Now Click On Send Mail. Now The System will Send Mail To a Given Account To Confirm That The Owner of Are You.Now Check The Mail And And Open The Latest Mail And Click On the Provide Link. It Will Redirect To Recover Password Page. There You Have To Make Your New Password.
</p> -->
