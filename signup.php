<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
<h1>Sign up</h1>
<form action = "process_signup.php" method="post">

    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" required><br>

    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" required><br>

    <label for="email">Email</label>
    <input type="text" id="email" name="email" required><br>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Submit">
</form>
</body>
