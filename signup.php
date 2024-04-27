<?php require ('functions.php');
session_start();

// Confirmation for sign up
$message = isset($_GET['message']) ? $_GET['message'] : null;
// Error for sign up
$error = isset($_GET['error']) ? $_GET['error'] : null;

// reset the message and error displays when confirmed is clicked and redirect
if (isset($_POST['message'])) {
    $message = null;
    header('Location:login.php');
    exit();
}
else if (isset($_POST['error'])) {
    $error = null;
    header('Location:signup.php');
    exit();
}
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

<div class="login_form">
    <h1>Sign up</h1>

    <!--- Confirmation for sign up --->
    <?php if ($message) { ?>
        <div class="message">
            <div>
                <?= displayMessage($message) ?>
            </div>
            <form action="signup.php" method="post">
                <input type="submit" name="message" value="Confirm">
            </form>
        </div>
    <?php } ?>

    <!--- Error for sign up --->
    <?php if ($error) { ?>
        <div class="error">
            <div>
                <?= displayError($error) ?>
            </div>
            <form action="signup.php" method="post">
                <input type="submit" name="error" value="Confirm">
            </form>
        </div>
    <?php } ?>

    <form action="process_signup.php" method="post">

        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" required><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required><br>

        <div class="radio-group">
            <input type="radio" id="buyer" name="role" value="Buyer" required>
            <label for="buyer">Buyer</label>
        </div>
        <div class="radio-group">
            <input type="radio" id="seller" name="role" value="Seller" required>
            <label for="seller">Seller</label>
        </div>
        <div class="radio-group">
            <input type="radio" id="admin" name="role" value="Admin" required>
            <label for="admin">Admin</label>
        </div>

        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>
