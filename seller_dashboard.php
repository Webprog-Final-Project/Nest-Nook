<?php require ('functions.php');
session_start();

// For displaying user's properties
$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");
$user_id = $_SESSION['user_id'];

// Welcome message
echo "Welcome " . $_SESSION['first_name'] . " " . $_SESSION['last_name'];

// Message to display when new property is added
$message = isset($_GET['message']) ? $_GET['message'] : null;

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
    <div>
        <?php if ($message) { ?>
            <p><?=$message?></p>
        <?php } ?>
    </div>
    <div>
        <?php displayPropertyCards($conn, $user_id); ?>
    </div>
</body>
