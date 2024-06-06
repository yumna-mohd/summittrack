<?php

session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    die();
}
include 'config.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summittrack</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="stylesheets/home.css">
    <link rel="sylesheet" href="stylesheets/template.css">

    
</head>
<body>
    <div class="home-btns">
        

        <div class="home-head1">
            <h1>SummitTrack</h1>
            <a href="profile.php"><i class="fa-solid fa-user"></i></a>
            <p><strong>My Track</strong><p>
            <img src="image/pink-hr.png">
        </div>
        <div class="three-btns">
            <button><a href="main/category.php">Categories</a></button>
            <button><a href="main/all-books.php">All Books</a></button>
            <button><a href="main/add-book.php">Add a book</a></button>
        </div>
        <div class="home-head1">
        <p>Others<p>
            <img src="image/pink-hr.png">
        </div>
        <div class="two-btns">
            <button><a href="main/book-search.php">Google Books</a></button>
        </div>
    </div>

<!--attaching external js-->
<script src="js/script.js"></script>
</body>
</html>
