<?php require ('functions.php');
session_start();
echo "Welcome " . $_SESSION['first_name'] . " " . $_SESSION['last_name'];