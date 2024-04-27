<?php require ('functions.php');
session_start();

// For displaying user's properties
$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");
$user_id = $_SESSION['user_id'];

// Welcome message
echo "Welcome " . $_SESSION['first_name'] . " " . $_SESSION['last_name'];

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
</head>
<body>
    <h1>Seller Dashboard</h1>

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
    <form action = "new_property.php" method="post">
        <input type="submit" value="+">
    </form>

    <!--- Display all properties --->
    <div>
        <?php displayPropertyCards($conn, $user_id); ?>
    </div>
</body>
