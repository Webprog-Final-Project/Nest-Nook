<?php require ('functions.php');
session_start();

// Check if an error occurred during login
$error = isset($_GET['error']) ? $_GET['error'] : null;

// reset error display when confirmed is clicked
if (isset($_POST['error'])) {
    $error = null;
    header('Location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
   <link rel="stylesheet" type="text/css" href="css/login.css">
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
        <h1>Login</h1>

        <!--- Error for login --->
        <?php if ($error) { ?>
            <div class="error">
                <div>
                    <?= displayError($error) ?>
                </div>
                <form action="login.php" method="post">
                    <input type="submit" name="error" value="Confirm">
                </form>
            </div>
        <?php } ?>

        <form action="process_login.php" method="post">

            <label for="email">Email</label>
            <input type="text" id="email" name="email" required><br>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
