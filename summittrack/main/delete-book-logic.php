<?php
//starting the session
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

//incluidng the database connection file
include('../config.php');

// Check if the book ID is set in the query string
if (isset($_GET['book'])) {
    $bookID = $_GET['book'];

    // Retrieve the book image filename
    $stmt = $conn->prepare("SELECT `book_image` FROM `tbl_book` WHERE `tbl_book_id` = ?");
    $stmt->bind_param("i", $bookID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $bookImage = $row['book_image'];

        // Delete the book from the database
        $stmt = $conn->prepare("DELETE FROM `tbl_book` WHERE `tbl_book_id` = ?");
        $stmt->bind_param("i", $bookID);
        $stmt->execute();

        // Delete the associated image file if it exists
        if (!empty($bookImage)) {
            $imagePath = "../uploads/" . $bookImage;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Redirect to the page where you want to display the updated book list
        echo "<script>
            alert('Deleted Successfully');
            window.location.href = 'all-books.php';
            </script>";
    } else {
        // Redirect with an error message if the book ID is invalid
        echo "<script>
            alert('book not found');
            window.location.href = 'all-books.php';
            </script>";
    }
    exit();
} else {
    // Redirect with an error message if the book ID is not provided
    echo "<script>
        alert('Invalid Request');
        window.location.href = 'all-books.php';
        </script>";
    exit();
}
?>
