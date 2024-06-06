<?php 
//starting the session
session_start();

//including the database connection file
include('../config.php'); 

// checking if the user is logged in. if not, redireciton to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
//getting the user id from the session
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summittrack</title>

    <!-- Font Awesome stylesheet for icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- main external stylesheet -->
    <link rel="stylesheet" href="../stylesheets/home.css">

</head>
<body>
    <!-- Category Area -->
    <div class="category-container">
        <div class="home-btns">
            <!--main heading section-->
            <div class="home-head1">
                <h1>SummitTrack</h1>
                <p class="category-title">Genres<p><br>
                <img src="../image/pink-hr.png">
            </div>
            <!--button that redirects to home page-->
            <a class="hover" href="../home.php"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
"
            <div>
                <!--Fantasy section-->
                <div class="category-btns">
                    <!--fantasy heading-->
                    <button id="fantasy" onclick="toggleAction(1)">Fantasy</button>
                    <!--list of fantasy book-->              
                    <!--hidden container for the list of books in a category-->
                    <div class="hidden-list-container" id="hidden-list-container_1">
                        <section id="category_1" style="display: none;">
                            <div class="center-box">
                                <div class="category-head">
                                    <!--heading section-->
                                    <p>Fantasy</p>
                                    <div class="center-align">
                                        <img src="../image/pink-hr.png">
                                        <!--button to close the hidden container-->
                                        <i class="fa fa-angle-double-left hover" onclick="closeHiddenListContainer(1)" aria-hidden="true"></i>
                                    </div>                                   
                                </div>
                                <div class="category-book">
                                    <?php 
                                    //selecting books from database based on category and user id
                                    $stmt = $conn->prepare("
                                        SELECT * 
                                        FROM 
                                            `tbl_book`
                                        LEFT JOIN
                                            `tbl_category` ON
                                            `tbl_book`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                                        WHERE
                                            `category_name` = 'Fantasy' AND `user_id` = ?
                                    ");
                                    // Binding user id parameter
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $rows = $result->fetch_all(MYSQLI_ASSOC);

                                    // Looping through each row to display book details
                                    foreach ($rows as $row) {
                                        $bookID = $row['tbl_book_id'];
                                        $categoryName = $row['category_name'];
                                        $bookImage = $row['book_image'];
                                        $bookName = $row['book_name'];
                                        $bookAuthor = $row['book_author'];
                                        $bookSummary = $row['book_summary'];
                                    ?>
                                    <div class="category-book-card">
                                        <!--displaying book image-->
                                        <div class="img-card">
                                            <img src="http://localhost/summittrack/uploads/<?php echo $bookImage ?>" class="card-img-top mt-1" alt="book">
                                        </div>
                                            <!-- Displaying book name and category -->
                                        <h6><strong><?php echo $bookName ?></strong></h6>
                                        <i>Category: </i><i><?php echo $categoryName ?></i><br> 
                                        <h6><strong><?php echo $bookAuthor ?></strong></h6>

                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>                  
                </div>
                
                <!--Horror list-->
                <div class="category-btns">
                    <button onclick="toggleAction(2)">Horror</button>
                    <!--list of Horror book-->
                    <!--hidden container for the list of books in a category-->
                    <div class="hidden-list-container" id="hidden-list-container_2">
                        <section id="category_2" style="display: none;">
                            <div class="center-box">
                                <div class="category-head">
                                    <!--heading section-->
                                    <p>Horror</p>
                                    <div class="center-align">
                                        <img src="../image/pink-hr.png">
                                        <!--button to close the hidden container-->
                                        <i class="fa fa-angle-double-left hover" onclick="closeHiddenListContainer(2)" aria-hidden="true"></i>
                                    </div>                                   
                                </div>
                                <div class="category-book">
                                    <?php 
                                    //selecting books from database based on category and user id
                                    $stmt = $conn->prepare("
                                        SELECT * 
                                        FROM 
                                            `tbl_book`
                                        LEFT JOIN
                                            `tbl_category` ON
                                            `tbl_book`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                                        WHERE
                                            `category_name` = 'Horror' AND `user_id` = ?
                                    ");
                                    // Binding user id parameter
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $rows = $result->fetch_all(MYSQLI_ASSOC);

                                    // Looping through each row to display book details
                                    foreach ($rows as $row) {
                                        $bookID = $row['tbl_book_id'];
                                        $categoryName = $row['category_name'];
                                        $bookImage = $row['book_image'];
                                        $bookName = $row['book_name'];
                                        $bookAuthor = $row['book_author'];
                                        $bookSummary = $row['book_summary'];
                                    ?>
                                    <div class="category-book-card">
                                        <!--displaying book image-->
                                        <div class="img-card">
                                            <img src="http://localhost/summittrack/uploads/<?php echo $bookImage ?>" class="card-img-top mt-1" alt="book">
                                        </div>
                                            <!-- Displaying book name and category -->
                                        <h6><strong><?php echo $bookName ?></strong></h6>
                                        <i>Category: </i><i><?php echo $categoryName ?></i><br> 
                                        <h6><strong><?php echo $bookAuthor ?></strong></h6>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                    
                </div>

                <!--Thriller list-->
                <div class="category-btns">
                    <button onclick="toggleAction(3)">Thriller</button>
                    <!--list of Thriller book-->
                    <!--hidden container for the list of books in a category-->
                    <div class="hidden-list-container" id="hidden-list-container_3">
                        <section id="category_3" style="display: none;">
                            <div class="center-box">
                                <div class="category-head">
                                    <!--heading section-->
                                    <p>Thriller</p>
                                    <div class="center-align">
                                        <img src="../image/pink-hr.png">
                                        <!--button to close the hidden container-->
                                        <i class="fa fa-angle-double-left hover" onclick="closeHiddenListContainer(3)" aria-hidden="true"></i>
                                    </div>                                   
                                </div>
                                <div class="category-book">
                                    <?php 
                                    //selecting books from database based on category and user id
                                    $stmt = $conn->prepare("
                                        SELECT * 
                                        FROM 
                                            `tbl_book`
                                        LEFT JOIN
                                            `tbl_category` ON
                                            `tbl_book`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                                        WHERE
                                            `category_name` = 'Thriller' AND `user_id` = ?
                                    ");
                                    // Binding user id parameter
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $rows = $result->fetch_all(MYSQLI_ASSOC);

                                    // Looping through each row to display book details
                                    foreach ($rows as $row) {
                                        $bookID = $row['tbl_book_id'];
                                        $categoryName = $row['category_name'];
                                        $bookImage = $row['book_image'];
                                        $bookName = $row['book_name'];
                                        $bookAuthor = $row['book_author'];
                                        $bookSummary = $row['book_summary'];
                                    ?>
                                    <div class="category-book-card">
                                        <!--displaying book image-->
                                        <div class="img-card">
                                            <img src="http://localhost/summittrack/uploads/<?php echo $bookImage ?>" alt="book">
                                        </div>
                                            <!-- Displaying book name and category -->
                                        <h6><strong><?php echo $bookName ?></strong></h6>
                                        <i>Category: </i><i><?php echo $categoryName ?></i><br> 
                                        <h6><strong><?php echo $bookAuthor ?></strong></h6>

                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!--fiction list-->
                <div class="category-btns">
                    <button onclick="toggleAction(4)">Fiction</button>
                    <!--list of Fiction book-->
                    <!--hidden container for the list of books in a category-->
                    <div class="hidden-list-container" id="hidden-list-container_4">
                        <section id="category_4" style="display: none;">
                            <div class="center-box">
                                <div class="category-head">
                                    <!--heading section-->
                                    <p>Fiction</p>
                                    <div class="center-align">
                                        <img src="../image/pink-hr.png">
                                        <!--button to close the hidden container-->
                                        <i class="fa fa-angle-double-left hover" onclick="closeHiddenListContainer(4)" aria-hidden="true"></i>
                                    </div>                                   
                                </div>
                                <div class="category-book">
                                    <?php 
                                    //selecting books from database based on category and user id
                                    $stmt = $conn->prepare("
                                        SELECT * 
                                        FROM 
                                            `tbl_book`
                                        LEFT JOIN
                                            `tbl_category` ON
                                            `tbl_book`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                                        WHERE
                                            `category_name` = 'Fiction' AND `user_id` = ?
                                    ");
                                    // Binding user id parameter
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $rows = $result->fetch_all(MYSQLI_ASSOC);

                                    // Looping through each row to display book details
                                    foreach ($rows as $row) {
                                        $bookID = $row['tbl_book_id'];
                                        $categoryName = $row['category_name'];
                                        $bookImage = $row['book_image'];
                                        $bookName = $row['book_name'];
                                        $bookAuthor = $row['book_author'];
                                        $bookSummary = $row['book_summary'];
                                    ?>
                                    <div class="category-book-card">
                                        <!--displaying book image-->
                                        <div class="img-card">
                                            <img src="http://localhost/summittrack/uploads/<?php echo $bookImage ?>" class="card-img-top mt-1" alt="book">
                                        </div>
                                            <!-- Displaying book name and category -->
                                        <h6><strong><?php echo $bookName ?></strong></h6>
                                        <i>Category: </i><i><?php echo $categoryName ?></i><br> 
                                        <h6><strong><?php echo $bookAuthor ?></strong></h6>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!--Non Fiction list-->
                <div class="category-btns">
                    <button onclick="toggleAction(5)">Non Fiction</button>
                    <!--list of non Fiction book-->
                    <!--hidden container for the list of books in a category-->
                    <div class="hidden-list-container" id="hidden-list-container_5">
                        <section id="category_5" style="display: none;">
                            <div class="center-box">
                                <div class="category-head">
                                    <!--heading section-->
                                    <p>Fiction</p>
                                    <div class="center-align">
                                        <img src="../image/pink-hr.png">
                                        <!--button to close the hidden container-->
                                        <i class="fa fa-angle-double-left hover" onclick="closeHiddenListContainer(5)" aria-hidden="true"></i>
                                    </div>                                   
                                </div>
                                <div class="category-book">
                                    <?php 
                                    //selecting books from database based on category and user id
                                    $stmt = $conn->prepare("
                                        SELECT * 
                                        FROM 
                                            `tbl_book`
                                        LEFT JOIN
                                            `tbl_category` ON
                                            `tbl_book`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                                        WHERE
                                            `category_name` = 'Non Fiction' AND `user_id` = ?
                                    ");
                                    // Binding user id parameter
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $rows = $result->fetch_all(MYSQLI_ASSOC);

                                    // Looping through each row to display book details
                                    foreach ($rows as $row) {
                                        $bookID = $row['tbl_book_id'];
                                        $categoryName = $row['category_name'];
                                        $bookImage = $row['book_image'];
                                        $bookName = $row['book_name'];
                                        $bookAuthor = $row['book_author'];
                                        $bookSummary = $row['book_summary'];
                                    ?>
                                    <div class="category-book-card">
                                        <!--displaying book image-->
                                        <div class="img-card">
                                            <img src="http://localhost/summittrack/uploads/<?php echo $bookImage ?>" class="card-img-top mt-1" alt="book" style="max-width: 120px; max-height: 180px;">
                                        </div>
                                            <!-- Displaying book name and category -->
                                        <h6><strong><?php echo $bookName ?></strong></h6>
                                        <i>Category: </i><i><?php echo $categoryName ?></i><br> 
                                        <h6><strong><?php echo $bookAuthor ?></strong></h6>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!--other list-->
                <div class="category-btns">
                    <button onclick="toggleAction(6)">Historical</button> 
                    <!--list of other book-->
                    <!--hidden container for the list of books in a category-->
                    <div class="hidden-list-container" id="hidden-list-container_6">
                        <section id="category_6" style="display: none;">
                            <div class="center-box">
                                <div class="category-head">
                                    <!--heading section-->
                                    <p>Fiction</p>
                                    <div class="center-align">
                                        <img src="../image/pink-hr.png">
                                        <!--button to close the hidden container-->
                                        <i class="fa fa-angle-double-left hover" onclick="closeHiddenListContainer(6)" aria-hidden="true"></i>
                                    </div>                                   
                                </div>
                                <div class="category-book">
                                    <?php 
                                    //selecting books from database based on category and user id
                                    $stmt = $conn->prepare("
                                        SELECT * 
                                        FROM 
                                            `tbl_book`
                                        LEFT JOIN
                                            `tbl_category` ON
                                            `tbl_book`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                                        WHERE
                                            `category_name` = 'Others' AND `user_id` = ?
                                    ");
                                    // Binding user id parameter
                                    $stmt->bind_param("i", $user_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $rows = $result->fetch_all(MYSQLI_ASSOC);

                                    // Looping through each row to display book details
                                    foreach ($rows as $row) {
                                        $bookID = $row['tbl_book_id'];
                                        $categoryName = $row['category_name'];
                                        $bookImage = $row['book_image'];
                                        $bookName = $row['book_name'];
                                        $bookAuthor = $row['book_author'];
                                        $bookSummary = $row['book_summary'];
                                    ?>
                                    <div class="category-book-card">
                                        <!--displaying book image-->
                                        <div class="img-card">
                                            <img src="http://localhost/summittrack/uploads/<?php echo $bookImage ?>" class="card-img-top mt-1" alt="book" >
                                        </div>
                                            <!-- Displaying book name and category -->
                                        <h6><strong><?php echo $bookName ?></strong></h6>
                                        <i>Category: </i><i><?php echo $categoryName ?></i><br> 
                                        <h6><strong><?php echo $bookAuthor ?></strong></h6>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>         
            </div>
        </div>
    </div>

    <!------------------adding the blur background---------------------------->
    <div class="blur-background" id="blur-background"></div>

    <!--attaching external js-->
    <script src="../js/script.js"></script>
</body>
</html>
