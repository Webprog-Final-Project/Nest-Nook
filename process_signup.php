<?php require('functions.php');

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "POST"
	&& !empty($_POST['first_name'])
	&& !empty($_POST['last_name'])
	&& !empty($_POST['email'])
	&& !empty($_POST['password'])
	&& !empty($_POST['role'])
	) {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$role = $_POST['role'];

	if (verifyUniqueUser($conn, $email) && verifyEmailFormat($email)) {
		addNewUser($conn,$first_name, $last_name, $email, $password, $role);
	} else {
		// Redirect the user to the signup page with an error parameter
		header("Location: signup.php?error=2");
		exit;
	}
}
closeConnection($conn);
?>
