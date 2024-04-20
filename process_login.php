<?php require('functions.php');

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "POST"
    && !empty($_POST['email'])
    && !empty($_POST['password'])
) {
    $first_name = '';
    $last_name = '';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = '';

    if (findUser($conn, $first_name, $last_name, $email, $password, $role)) {
        session_start();
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        header('location: Homepage.html');
        exit;
    } else {
        // Redirect the user to the login page with an error parameter
        header("Location: login.php?error=1");
        exit;
    }
}
closeConnection($conn);
?>
