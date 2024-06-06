<?php

session_start(); //starting the session
session_unset(); //unsetting all the session variables
session_destroy(); //destroying the session

//redirection to the login page
header("Location: welcome.php");