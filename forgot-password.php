<!-- Code by Brave Coder - https://youtube.com/BraveCoder -->

<?php

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: home.php");
    die();
}

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET code='{$code}' WHERE email='{$email}'");

        if ($query) {        
            echo "<div style='display: none;'>";
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'yumms.m@gmail.com';                     //SMTP username
                $mail->Password   = 'zasw vmrc yfyx duos';                           //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('yumms.m@gmail.com');
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'no reply';
                $mail->Body    = 'Here is the verification link <b><a href="http://localhost/summittrack/change-password.php?reset='.$code.'">http://localhost/summittrack/change-password.php?reset='.$code.'</a></b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";        
            $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>$email - This email address do not found.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Summittrack forgot password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"content="Login Form" />
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--attaching the main external stylesheet-->
    <link rel="stylesheet" href="stylesheets/style.css" type="text/css" media="all" />
    <!--link to font awesome stylesheet for icons-->
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>
    <section class="user-main">
        <div class="log-container">
            <!--forgot password form-->
            <div class="register-form forgot-pass">
                <h2>Forgot Password</h2>
                <p>Forgot password? Enter your email to recover it!</p>
                <?php echo $msg; ?>
                <form action="" method="post">
                    <!--prompting users to enter their email-->
                    <input type="email" name="email" placeholder="Enter Your Email" required>
                    <!--submission button-->
                    <button name="submit" class="forgot-btn" type="submit">Send Reset Link</button>
                </form>
                <!--redirection to login form in case the user wants to go back-->
                <div class="register-now">
                    <p>Back to! <a href="index.php">Login</a>.</p>
                </div>
            </div>
        </div>
    </section>

    <!--attaching the kQuery library-->
    <script src="js/jquery.min.js"></script>
    <script>
        //jquery to close the alert message
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.log-main').fadeOut('slow', function (c) {
                    $('.log-main').remove();
                });
            });
        });
    </script>
</body>
</html>