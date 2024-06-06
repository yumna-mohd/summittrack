<?php
//connection to the database using mysqli
$conn = mysqli_connect("localhost", "root", "", "track");

//checking if the connection was successful
if (!$conn) {
    //displaying "connection failed" incase of unsuccessful connection
    echo "Connection Failed";
}