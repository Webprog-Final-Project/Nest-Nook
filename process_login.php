<?php require('functions.php');

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "GET"
    && !empty($_GET['first_name'])
    && !empty($_GET['last_name'])
    && !empty($_GET['email'])
    && !empty($_GET['password'])
) {
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $email = $_GET['email'];
    $password = password_hash($_GET['password'], PASSWORD_DEFAULT);

    if (findUser($conn, $email, $password)) {
        session_destroy();
        session_start();
        $_SESSION['fist_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        header('location: Homepage.html');
        exit;
    }
    else {
        // Redirect the user to the login page with an error parameter
        header("Location: login.php?error=1");
        exit;
    }
}
closeConnection($conn);
?>