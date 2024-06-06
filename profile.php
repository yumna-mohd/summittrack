<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    die();
}

include 'config.php';

$email = $_SESSION['user_email'];

// Check if the user's name is already in the session
if (isset($_SESSION['fullname'])) {
    $name = $_SESSION['fullname'];
} else {
    // Retrieve the user's name from the database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $name = $row['name'];
    } else {
        $name = 'User'; // Default name if not found
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="stylesheets/home.css" type="text/css" media="all" />
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="profile-main">
        <div class="profile-box">
            <img class="profile-icon" src="image/profile-pink.png">
            <p><?php echo $name; ?></p>
            <p><?php echo $email; ?></p>
            <button class="logout"><a href='logout.php' class="logout-btn">Logout</a></button>
            <a class="home-icon" href="home.php"></a>
       

    </div>
</body>
</html>
