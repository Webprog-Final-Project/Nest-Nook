<?php require ('functions.php');
session_start();

// For displaying user's properties
$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");
$user_id = $_SESSION['user_id'];

// Confirmation for update, delete, add
$message = isset($_GET['message']) ? $_GET['message'] : null;
// Error for update, delete, add
$error = isset($_GET['error']) ? $_GET['error'] : null;

// reset the message and error displays when confirmed is clicked
if (isset($_POST['confirm'])) {
    $message = null;
    $error = null;
    header('Location:seller_dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/seller_dashboard.css">
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
        echo "<h2 class='welcome_message'>Welcome to the seller dashboard, ".$_SESSION['first_name']. " ". $_SESSION['last_name']." !</h2>";
    ?>

    <!--- Confirmation for update, delete, add --->
    <?php if ($message) { ?>
        <div class="message">
            <div>
                <?= displayMessage($message) ?>
            </div>
            <form action="seller_dashboard.php" method="post">
                <input type="submit" value="Confirm">
            </form>
        </div>
    <?php } ?>

    <!--- Error for update, delete, add --->
    <?php if ($error) { ?>
        <div class="error_message">
            <div>
                <?= displayError($error) ?>
            </div>
            <form action="seller_dashboard.php" method="post">
                <input type="submit" value="Confirm">
            </form>
        </div>
    <?php } ?>

    <!--- Add new property button --->
    <form action = "new_property.php" method="post" >
        <div class=add_new_property_container>
            <input type="submit" value="+" class="add_new_property">
            <p>Click to add a property listing</p> 
        </div>
    </form>

    <!--- Display all properties --->
    <div class="property-row">
        <?php displayPropertyCards($conn, $user_id); ?>
    </div>
</body>
</html>
