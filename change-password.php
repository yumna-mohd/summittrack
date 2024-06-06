<?php
//initializing a message variable
$msg = "";

//including the database connection file
include 'config.php';

//checking if the reset parameter is set in the url
if (isset($_GET['reset'])) {
    //checking if the user exists in the database
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
        //continue with pass reset in case the user does exist
        if (isset($_POST['submit'])) {
            //hashing the entered password and confiem pass
            $password = mysqli_real_escape_string($conn, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

            //checking if the password and confirm password match
            if ($password === $confirm_password) {
                $query = mysqli_query($conn, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

                //redirection to login form if the password reset was successful
                if ($query) {
                    header("Location: index.php");
                }
            } else {
                //displaying error if the passwords do not match
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
            }
        }
    } else {
        //error msg if the reset code does not match any user
        $msg = "<div class='alert alert-danger'>Reset Link do not match.</div>";
    }
} else {
    //if reset parameter not in url, redirect to forgot password page.
    header("Location: forgot-password.php");
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>summittrack reset pass</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"content="Login Form" />
    <!--linking stylesheet to google fonts-->
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!--linking main external stylesheet -->
    <link rel="stylesheet" href="stylesheets/style.css" type="text/css" media="all" />
    <!--link to font awesome stylesheet for icons -->
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>

<body>
    <section class="user-main">
        <div class="log-container">
            <!--rest pass form - classes for styling-->
            <div class="register-form forgot-pass ">
                <h2>Change Password</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                <?php echo $msg; ?>
                <!--reset pass form-->
                <form action="" method="post">
                    <input type="password" name="password" placeholder="Enter Your Password" required>
                    <input type="password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                    <button class="change-pass" name="submit" type="submit">Change Password</button>
                </form>
                <!--link to login page-->
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