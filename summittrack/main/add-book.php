<?php 
//starting the session
session_start();

//including the database connection file
include('../config.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summittrack</title>

    <!-- Font Awesome stylesheet for icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- external stylesheet -->
    <link rel="stylesheet" href="../stylesheets/home.css">
</head>
<body>
    <div class="add-book-start">
        <div class="add-book-main">
            <!--main displayed content-->
            <div class="add-content">
                <!--heading section of the page-->
                <div>
                    <h1>Add a Book!</h1>
                    <img src="../image/pink-hr.png">
                    <a class="hover" href="../home.php"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                </div>
                <p>Upload your book reviews to keep track of your thoughts and organize your reading journey.</p>
                <!--add button-->
                <button type="button" onclick="handleAddbookClick()">ADD</button>
            </div>

            <!-- Hidden upload container -->
            <div class="hidden-upload-container" id="hidden-list-container_8">
                <section id="category_8" style="display: none;">
                    <div class="main-upload">
                        <div class="hidden-upload-head">
                            <!--heading-->
                            <h5 id="addbook"><strong>Add a Book!</strong></h5>
                            <img src="../image/pink-hr.png">
                        </div>
                        <!--main upload section-->
                        <div class="main-body-upload">
                            <!--upload form-->
                            <form id="bookID" action="add-book-logic.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" id="table" name="table" value="tbl_book">

                                <!-- Hidden input for book ID -->
                                <div hidden>
                                    <label for="bookID">book ID</label>
                                    <input type="text" id="bookID" name="tbl_book_id">
                                </div>
                                <!-- promting user to upload book image -->
                                <div>
                                    <label for="bookImage">Book Image</label>
                                    <input type="file" id="bookImage" name="book_image" style="border:none;">
                                </div>
                                <!-- promting user to add a book name -->
                                <div>
                                    <label for="bookName">book Name</label>
                                    <input type="text" id="bookName" name="book_name">
                                </div>
                                <!-- promting user to select a category -->
                                <div>
                                    <label for="bookCategory">Category</label>
                                    <?php 
                                    //getting categories form the database
                                        $stmt = $conn->prepare("SELECT * FROM `tbl_category`");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $book_category = $result->fetch_all(MYSQLI_ASSOC);
                                    ?>
                                    <select name="tbl_category_id" id="bookCategory">
                                        <option value="">- select -</option>
                                        <?php foreach ($book_category as $category): ?>
                                            <option value="<?php echo $category['tbl_category_id']; ?>"><?php echo $category['category_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- promting user to add the book autor/s -->
                                <div>
                                    <label for="bookAuthor">Author</label>
                                    <textarea name="book_author" id="bookAuthor" rows="5"></textarea>
                                </div>
                                <!-- promting user to add the book summary -->
                                <div>
                                    <label for="bookSummary">Summary</label>
                                    <textarea name="book_summary" id="bookSummary" rows="5"></textarea>
                                </div>
                                <!-- buttons to either close or submit the form-->
                                <div>
                                    <a class="btn-dark1" href="add-book.php">Close</a>
                                    <button type="submit" class="btn btn-dark2">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Adding the blur background -->
        <div class="blank-view-book-bg" id="blur-background"></div>

        <!-- Attaching external JS -->
        <script src="../js/script.js"></script>
        <script>
            function handleAddbookClick() {
                <?php if (isset($_SESSION['user_id']) || isset($_SESSION['google_loggedin'])): ?>
                    // User is logged in, show the add book form
                    toggleAction(8);
                <?php else: ?>
                    // User is not logged in, show the login prompt
                    alert("Please log in to add a book.");
                    window.location.href = "../index.php"; // Redirect to the login page
                <?php endif; ?>
            }
        </script>
    <div>  
</body>
</html>