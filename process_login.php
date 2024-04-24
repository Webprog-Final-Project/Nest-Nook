<?php require('functions.php');

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "POST"
    && !empty($_POST['email'])
    && !empty($_POST['password'])
) {
    $user_id = '';
    $first_name = '';
    $last_name = '';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = '';

    if (findUser($conn, $user_id,$first_name, $last_name, $email, $password, $role)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        switch ($role) {
            case 'Seller':
                header('location: seller_dashboard.php');
                break;
            case 'Buyer':
                header('location: buyer_dashboard.php');
                break;
            case 'Admin':
                header('location: admin_dashboard.php');
                break;
            default:
                header('location: seller_dashboard.php');
        }
    } else {
        // Redirect the user to the login page with an error parameter
        header("Location: login.php?error=1");
    }
    exit;
}
closeConnection($conn);
?>
