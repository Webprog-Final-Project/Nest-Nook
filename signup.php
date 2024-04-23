<?php require ('functions.php');
session_start();

// Check if an error occurred during signup
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="./css/login.css"> 
</head>
<body>
<nav class="nav_bar">
    <h2 class="title">Nest Nook</h2>
    <ul class="nav_links">
        <li class="home"><a href="Homepage.html">Home</a></li>
        <li class="buy"><a href="buy.html">Buy</a></li>
        <li class="sell"><a href="sell.html">Sell</a></li>
        <li class="contact"><a href="contact.html">Contact</a></li>
    </ul>
    <ul class="auth_links">
        <li class="signup"><a href="signup.php">Sign up</a></li>
        <li class="login"><a href="login.php">Login</a></li>
    </ul>
</nav>

<div class="login_form">
    <h1>Sign up</h1>
    <form action="process_signup.php" method="post">

        <?php if ($error): ?>
            <p class="error"><?php echo displayErrorMessage($error); ?></p>
        <?php endif; ?>

        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" required><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required><br>

        <div class="radio-group">
            <input type="radio" id="buyer" name="role" value="Buyer">
            <label for="buyer">Buyer</label>
        </div>
        <div class="radio-group">
            <input type="radio" id="seller" name="role" value="Seller">
            <label for="seller">Seller</label>
        </div>
        <div class="radio-group">
            <input type="radio" id="admin" name="role" value="Admin">
            <label for="admin">Admin</label>
        </div>


        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>