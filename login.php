<?php require ('functions.php');
session_start();

// Check if an error occurred during login
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<form action = "process_login.php" method="get">
    <?php if ($error): ?>
        <p><?php echo displayErrorMessage($error); ?></p>
    <?php endif; ?>

    <label for="email">Email</label>
    <input type="text" id="email" name="email" required><br>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Submit">
</form>
</body>
