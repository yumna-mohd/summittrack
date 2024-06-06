<?php 
//starting the session
session_start();

//including the database connection file
include('../config.php'); 

// checking if the user is logged in
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

    <!-- Font Awesome stylesheet for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- attaching external stylesheet-->
    <link rel="stylesheet" href="../stylesheets/home.css">
</head>
<body>

    <!------------------All book section---------------------------->
    <section>
        <div class="book-list-container">
            <div class="all-list">
                <!--heading section of the page-->
                <h1>SummitTrack</h1>
                <p>All Books</p>
                <img src="../image/pink-hr.png">
                <a class="hover" href="../home.php"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
            </div>
            <div class="table-container">
                <!--search container-->
                <div class="search-container">
                    <input class="search-control" type="text" id="searchInput" placeholder="Search...">
                </div>
                <!--all books table-->
                <div class="table-responsive">
                <table id="bookListTable" class="all-list-table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10%;">Book ID</th>
                                <th scope="col" style="width: 20%;">Book Image</th>
                                <th scope="col" style="width: 25%;">Book Name</th>
                                <th scope="col" style="width: 25%;">Genre</th>
                                <th scope="col" style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            //getting books from database based on user id
                            $stmt = $conn->prepare("
                                SELECT * 
                                FROM 
                                    `tbl_book`
                                LEFT JOIN
                                    `tbl_category` ON
                                    `tbl_book`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                                WHERE
                                    `tbl_book`.`user_id` = ?
                            ");
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows = $result->fetch_all(MYSQLI_ASSOC);
                            
                            // Initialize the counter
                            $counter = 1;

                            //looping thorugh each book and displaying its details
                            foreach ($rows as $row) {
                                $bookID = $row['tbl_book_id'];
                                $categoryID = $row['tbl_category_id'];
                                $categoryName = $row['category_name'];
                                $bookImage = $row['book_image'];
                                $bookName = $row['book_name'];
                                $bookAuthor = $row['book_author'];
                                $bookSummary = $row['book_summary'];
                                ?>
                               <tr id="bookRow-<?php echo $counter;?>"> 
                                    <td class="book-id"><?php echo $counter;?></td>
                                    <td><img id="bookImage-<?php echo $counter;?>" src="http://localhost/summittrack/uploads/<?php echo $bookImage?>" alt="Book Image"></td>
                                    <td id="bookName-<?php echo $counter;?>"><?php echo $bookName?></td>
                                    <td id="categoryName-<?php echo $counter;?>"><?php echo $categoryName?></td>
                                    <td id="bookAuthor-<?php echo $counter;?>" hidden><?php echo $bookAuthor?></td>
                                    <td id="bookSummary-<?php echo $counter;?>" hidden><?php echo $bookSummary?></td>
                                    <td>
                                        <button type="button" onclick="view_book('<?php echo $counter;?>'); toggleAction(7);" title="View"><i class="fa-solid fa-list"></i></button>
                                        <button type="button" onclick="delete_book('<?php echo $row['tbl_book_id'];?>')" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>

                                <?php
                                 // Increment the counter for the next row
                                $counter++;
                            }
                            ?>                     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
  
        <!------------------adding the blur background---------------------------->
        <div class="blank-view-book-bg" id="blur-background"></div>       
    </section>

    <!--hidden container for displaying the book details-->
    <div class="hidden-list-container" id="hidden-list-container_7">
        <div id="category_7" style="display:none">
            <!-- View book template -->
            <div class="view-book-template" id="viewbooktemplate">
                <div class="category-head">
                    <!--jeading section-->
                    <p>Book Details</p>
                    <div class="center-align">
                        <img src="../image/pink-hr.png">
                        <a class="hover white" href="all-books.php"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                    </div>                                   
                </div>
                <!--detail section-->
                <div class="book-detail-body">
                    <!--book image-->
                    <div>
                        <img src="" id="viewbookImage"  alt="book" >
                    </div>
                    <!--book title and category-->
                    <div class="res-title-category">
                        <h6 class="card-title"><strong id="viewbookName"></strong></h6>
                        <p class="text-muted">Genre: <span id="viewCategoryName"></span></p>
                    </div>
                    <!--book author and summary-->
                    <div class="summary">
                        <div class="author">
                            <h5><strong>Author/s:</strong></h5>
                            <p id="viewbookAuthor"></p>
                        </div>
                        <div class="summary">
                            <h5><strong>Summary:</strong></h5>
                            <p id="viewbookSummary"></p>
                        </div>
                    </div>                       
                </div>
            </div>
        </div>
    </div>

    <!--attaching external js-->
    <script src="../js/script.js"></script>

</body>
</html>
