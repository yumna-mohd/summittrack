<?php
//starting the session
session_start();

//condition to check if the user is already logged in and redirecting them to the home page
if (isset($_SESSION['user_email'])) {
    header("Location: home.php");
    die();
}

//including the database connection file
include 'config.php';
//initializing a variable
$msg = "";

//verification check
if (isset($_GET['verification'])) {
    //condition to check if the user with verification code exist
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {
       //inserting the users code to an empty string that will indicate successful verification
        $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");
        
        //displaying the success message
        if ($query) {
            $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
        }
    } else {
        header("Location: index.php");
    }
}

//login submission check
if (isset($_POST['submit'])) {
    //getting the email and pass from the form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    //querying the database for the user
    $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
    $result = mysqli_query($conn, $sql);

    //check if the matching user is found
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (empty($row['code'])) {
            //using session to store the user's email and ID
            $_SESSION['user_email'] = $email;
            $_SESSION['user_id'] = $row['id']; // Store user ID in session

            //redirecting to the home page
            header("Location: home.php");
            exit;
        } else {
            //displaying the following message if the user is not verified
            $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
        }
    } else {
        //displaying the following message if the user is not found
        $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Summittrack Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />

    <!--linking the google fonts stylesheet-->
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!--attaching the main external stylesheet-->
    <link rel="stylesheet" href="stylesheets/style.css" type="text/css" media="all" />
    <!--attaching the stylesheet to font awesome for icons-->
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>

<body>
    <section class="user-main">
        <div class="log-container">
        <div><h1>SummitTrack</h1></div>

            <div class="register-form">
                <h2>Welcome Back</h2>
                <h3>Fill your Login details</h3>
                <?php echo $msg; ?>
                <!--login form-->
                <form action="" method="post">
                    <!--prompting the user to input their email-->
                    <p>Email<p>
                    <input type="email" name="email" required>
                    <!--prompting the user to input thier password-->
                    <p>Password<p>
                    <input type="password" name="password" style="margin-bottom: 2px;" required>
                    <!--link to register form if the user does not have an account-->
                    <div class="reg-forgot">
                        <div class="register-now">
                            <p>Create Account! <a href="register.php">Register</a>.</p>
                        </div>
                        <!--link to forgot password file in case the user want to reset the password-->
                        <p><a href="forgot-password.php" style="display: block; text-align: right;">Forgot Password?</a></p>
                    </div>
                    <!--main login form submission button-->
                    <button name="submit" class="log-btn" type="submit">Login</button>
                    <!--allowing user to login using google-->
                    <div class="google-log">
                        <a href="google-oauth.php">Continue with google</a>
                    </div>
                </form>
                
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
