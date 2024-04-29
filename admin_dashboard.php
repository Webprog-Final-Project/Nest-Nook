<?php require ('functions.php');
session_start();

// For displaying user's properties
$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");
$user_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/admin_dashboard.css">
</head>
<body>
    <nav class="nav_bar">
        <h2 class="title">Nest Nook</h2>
        <ul class="nav_links">
            <li class="home"><a href="homepage.html">Home</a></li>
            <li class="buy"><a href="buy.html">Buy</a></li>
            <li class="sell"><a href="sell.html">Sell</a></li>
            <li class="contact"><a href="contact.html">Contact</a></li>
        </ul>
        <ul class="auth_links">
            <li class="signup"><a href="signup.php">Sign up</a></li>
            <li class="login"><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <?php
        echo "<h2 class='welcome_message'>Welcome to the admin dashboard, ".$_SESSION['first_name']. " ". $_SESSION['last_name']." !</h2>";
    ?>
</body>
</html>