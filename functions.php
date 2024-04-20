<?php

/*--- Connecting and disconnecting to the database ---*/

function openConnection($servername, $username, $password, $dbname) {

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}
function closeConnection($conn) {
	$conn->close();
}

/*--- Verify the new user from Signup page is not already in the DB ---*/

function verifyUniqueUser($conn, $email) {
	// Prepare and bind SQL statement
	$select_query = $conn->prepare(
		"SELECT email FROM users WHERE email = ?"
	);
	$select_query->bind_param("s", $email);

	// Execute SQL statement
	if ($select_query->execute()) {
		$select_query->store_result();

		// If email is unique: return true
		if ($select_query->num_rows === 0) {
			$select_query->close();
			return true;
		}
		// If not: return false
		else {
			$select_query->close();
			return false;
		}
	}
	else {
		$select_query->close();
		return false;
	}
}

/*--- Verify email is correctly formatted ---*/

function verifyEmailFormat($email) {
    if (preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        return true;
    } else {
        header("Location: signup.php?error=3");
        exit;
    }
}

/*--- Add new user from Signup page after verifying ---*/

function addNewUser($conn, $first_name, $last_name, $email, $password) {

	// Prepare and bind SQL statement
	$insert_query = $conn->prepare(
		"INSERT INTO users (first_name, last_name, email, password, role)
		VALUES (?, ?, ?, ?, 'Seller')"
	);
	$insert_query->bind_param("ssss", $first_name, $last_name, $email, $password);

	// Execute SQL statement
	if ($insert_query->execute()) {
		header("location:Homepage.html");
		exit;
	}
	else {
		echo "Error: " . $insert_query->error;
	}
	$insert_query->close();
}

/*--- Login: Check if credentials correct / User is in the Database ---*/

function findUser($conn, &$first_name, &$last_name, $email, $password, &$role) {
    $db_email = '';
    $db_password = '';

	// Prepare and bind SQL statement
	$select_query = $conn->prepare(
		"SELECT first_name, last_name, email, password, role FROM users WHERE email = ?"
	);
	$select_query->bind_param("s", $email);

	// Execute SQL statement
	if ($select_query->execute()) {
		$select_query->store_result();

		// If credentials are found
		if ($select_query->num_rows === 1) {

            // Assign query result to variables
            $select_query->bind_result($first_name, $last_name, $db_email, $db_password, $role);
            $select_query->fetch();
            $select_query->close();

            // Compare password hashes
            if (password_verify($password, $db_password)) {
                return true;
            }
            else {
                return false;
            }
		}
		else {
			$select_query->close();
			return false;
		}
	}
	else {
		$select_query->close();
		return false;
	}
}

/*--- Login: Display error message when login fails ---*/

function displayErrorMessage($error) {
    switch ($error) {
        case 1:
            return "Invalid email or password. Please try again.";
            break;
	case 2:
            return "This email is already registered to an account. Please go to the login page.";
            break;
	case 3:
            return "Please enter a valid email address.";
            break;
        default:
            return "An unexpected error occurred. Please try again later.";
    }
}
