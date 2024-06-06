<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--font awesome stylesheet for icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--main external stylesheet-->
    <link rel="stylesheet" href="../stylesheets/books-search.css">
    <!--page title-->
    <title>Google Book Search</title>
</head>
<body>
    <div class="search-main">
        <!--heading section of the page-->
        <div class="search-head">
            <h1>SummitTrack</h1>
            <p><strong>Search your favorite book!</strong></p>
            <img src="../image/pink-hr.png" alt="Pink HR">
            <a class="hover" href="../home.php"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
            <p><strong>“A reader lives a thousand lives before he dies. The man who never reads lives only one.” – George R.R. Martin</strong></p>
        </div>
        <!--search option form-->
        <div id="search">
            <form id="myform">
                <input placeholder="Search..." type="search" id="books">
            </form>
        </div>
        <!--searhc result container-->
        <div class="search-result" id="result"></div> <!-- Move the result container here -->
    </div>
    
    <!--external js ajax library-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--main external js-->
    <script src="../js/book-search.js"></script>
</body>
</html>
