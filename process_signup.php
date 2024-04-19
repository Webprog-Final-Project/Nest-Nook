<?php require('functions.php');

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "POST"
	&& !empty($_POST['first_name'])
	&& !empty($_POST['last_name'])
	&& !empty($_POST['email'])
	&& !empty($_POST['password'])
	) {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	if (verifyUniqueUser($conn, $email)) {
		addNewUser($conn,$first_name, $last_name, $email, $password);
	} else {
		// User already registered
	}
}
closeConnection($conn);
?>
