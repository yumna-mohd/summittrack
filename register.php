
<?php
    //importing phpmailer classes into gloval namespaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //starting the session
    session_start();

    //checking if the user is alredy logged in, and directing them to the home page
    if (isset($_SESSION['user_email'])) {
        header("Location: home.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    //attaching the database connection file
    include 'config.php';
    //initialiazing a message variable
    $msg = "";

    //checking if the submission form is submitted
    if (isset($_POST['submit'])) {
        //retrieving the input from the register form
        $fullname = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        //checking if the provided email already exists in the database
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
        } else {
            //checking if the password and confirm password match
            if ($password === $confirm_password) {
                $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$fullname}', '{$email}', '{$password}', '{$code}')";
                $result = mysqli_query($conn, $sql);

                //checking if the user has successfully been inserted
                if ($result) {
                    echo "<div style='display: none;'>";
                    //Creating an instance of phpmailer
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'yumms.m@gmail.com';                     //SMTP username
                        $mail->Password   = 'zasw vmrc yfyx duos';  
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('yumms.m@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'no reply';
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost/summittrack/?verification='.$code.'">http://localhost/summittrack/?verification='.$code.'</a></b>';

                        //seding the email
                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    //displaying the message that the verificatin link has been sent
                    $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
                } else {
                    //displaying the error message in other case
                    $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
                }
            } else {
                //error message in case the passwords do not match
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Registration form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />
    <!--linking stylesheet to google fonts-->
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--linking main external stylesheet -->
    <link rel="stylesheet" href="stylesheets/style.css" type="text/css" media="all" />
    <!--link to font awesome stylesheet for icons -->
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>

<body>
    <section class="user-main">
        <div class="reg-container">
        <!--setting the application name-->
        <div><h1>SummitTrack</h1></div>

            <!--registration form starting here-->
            <div class="register-form ">
                <h2>Register Now</h2>
                <?php echo $msg; ?>
                <!--registration form-->
                <form action="" method="post">
                    <!--prompting user to enter name-->
                    <p>Name<p>
                    <input type="text" name="name" value="<?php if (isset($_POST['submit'])) { echo $fullname; } ?>" required>
                    <!--prompting user to enter email-->
                    <p>Email<p>
                    <input type="email" name="email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                    <!--prompting user to emter pass-->
                    <p>Password<p>
                    <input type="password" name="password" required>
                    <!--promting user to confirm pass-->
                    <p>Confirm Password<p>
                    <input type="password" name="confirm-password"  required>
                    <div class="register-now">
                    <!--direction to login in form in case of existing account-->
                    <p>Have an account! <a href="index.php">Login</a>.</p>
                    <!--main submission button-->
                    </div>
                        <button name="submit" class="log-btn" type="submit">Register</button>
                    </form>  
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