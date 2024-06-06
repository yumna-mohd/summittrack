<?php
//starting the session
session_start();

//including the database connection file
include('../config.php');

//checking if the user is logged in
if (isset($_SESSION['user_id']) || isset($_SESSION['google_loggedin'])) {
    //getting book details from the form submission
    $bookName = $_POST['book_name'];
    $bookCategory = $_POST['tbl_category_id'];
    $bookAuthor = $_POST['book_author'];
    $bookSummary = $_POST['book_summary'];

    // getting book image from the form submission
    $bookImageName = $_FILES['book_image']['name'];
    $bookImageTmpName = $_FILES['book_image']['tmp_name'];

    //indicating the directory to upload the book images
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($bookImageName);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists, if yes, rename it
    $counter = 1;
    while (file_exists($target_file)) {
        $filename_parts = pathinfo($bookImageName);
        $new_filename = $filename_parts['filename'] . '_' . $counter . '.' . $filename_parts['extension'];
        $target_file = $target_dir . $new_filename;
        $counter++;
    }

    // Check if the image file is valid
    if (isset($_POST['submit'])) {
        $check = getimagesize($bookImageTmpName);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    /// Setting the maximum file size limit (e.g., 5MB)
    $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

    // Checking file size
    if ($_FILES["book_image"]["size"] > $maxFileSize) {
        $uploadOk = 0;
    }

    // Allowing only certain image formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // Insert image if the $uploadOk is 1
    if ($uploadOk == 0) {
        echo "<script>
        alert('There\'s a problem with your image, try another image');
        window.location.href = 'http://localhost/summittrack/main/add-book.php';
        </script>";
    } else {
        if (move_uploaded_file($bookImageTmpName, $target_file)) {
            //if the image upload is successful, get user id from session
            $bookImage = basename($target_file);
            $user_id = $_SESSION['user_id'];

            // Ensure the user_id exists in the users table
            $check_user = $conn->prepare("SELECT id FROM users WHERE id = ?");
            $check_user->bind_param("i", $user_id);
            $check_user->execute();
            $check_user_result = $check_user->get_result();

            if ($check_user_result->num_rows > 0) {
                // if the ser ID exists continue with inserting the book into database
                $stmt = $conn->prepare("INSERT INTO `tbl_book` (`tbl_book_id`, `tbl_category_id`, `book_image`, `book_name`, `book_author`, `book_summary`, `user_id`) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("issssi", $bookCategory, $bookImage, $bookName, $bookAuthor, $bookSummary, $user_id);

                if ($stmt->execute()) {
                    //display success message if insertion is successful
                    echo "<script>
                    alert('Successfully Added');
                    window.location.href = 'http://localhost/summittrack/main/add-book.php';
                    </script>";
                } else {
                    //display error message, fi insertion fails
                    echo "<script>
                    alert('Failed to insert record');
                    window.location.href = 'http://localhost/summittrack/main/add-book.php';
                    </script>";
                }
            } else {
                //show an error message if user id does not exist
                echo "<script>
                alert('User ID does not exist.');
                window.location.href = 'http://localhost/summittrack/main/add-book.php';
                </script>";
            }
        } else {
            //display error message if image upload fails
            echo "<script>
            alert('Failed to upload image');
            window.location.href = 'http://localhost/summittrack/main/add-book.php';
            </script>";
        }
    }
} else {
    //display error msg if user not logged in
    echo "User is not logged in.";
    // For debugging
    error_log("User not logged in: session = " . print_r($_SESSION, true));
}
?>
