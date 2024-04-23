<?php require ('functions.php');
session_start();
echo "Welcome " . $_SESSION['first_name'] . " " . $_SESSION['last_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
<h1>Seller Dashboard</h1>
<form action = "new_property.php" method="post">
    <input type="submit" value="+">
</form>
</body>
