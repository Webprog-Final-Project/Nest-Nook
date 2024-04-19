<?php require('functions.php');

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "POST"
	&& !empty($_POST['first_name'])
	&& !empty($_POST['last_name'])
	&& !empty($_POST['email'])
	&& !empty($_POST['password'])
	) {
	
	// Prepare and bind SQL statement
	$insert_query = $conn->prepare(
		"INSERT INTO users (first_name, last_name, email, password, role)
		VALUES (?, ?, ?, ?, 'Seller')" 
	);
	$insert_query->bind_param("ssss", $first_name, $last_name, $email, $password);

	// Retrieve form data
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	// Execute SQL statement
	if ($insert_query->execute()) {
		header("location:Homepage.html");
		exit;
	} else {
    		echo "Error: " . $insert_query->error;
	}
	$insert_query->close();
}
closeConnection($conn);
?>
