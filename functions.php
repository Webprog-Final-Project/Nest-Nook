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

function addNewUser($conn, $first_name, $last_name, $email, $password, $role) {

	// Prepare and bind SQL statement
	$insert_query = $conn->prepare(
		"INSERT INTO users (first_name, last_name, email, password, role)
		    VALUES (?, ?, ?, ?, ?)"
	);
	$insert_query->bind_param("sssss", $first_name, $last_name, $email, $password, $role);

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

function findUser($conn, &$user_id, &$first_name, &$last_name, $email, $password, &$role) {
    $db_email = '';
    $db_password = '';

	// Prepare and bind SQL statement
	$select_query = $conn->prepare(
		"SELECT user_id, first_name, last_name, email, password, role FROM users WHERE email = ?"
	);
	$select_query->bind_param("s", $email);

	// Execute SQL statement
	if ($select_query->execute()) {
		$select_query->store_result();

		// If credentials are found
		if ($select_query->num_rows === 1) {

            // Assign query result to variables
            $select_query->bind_result($user_id, $first_name, $last_name, $db_email, $db_password, $role);
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

/*--- New Property: Insert property info ---*/

function addProperty($conn, $user_id, &$property_id, $price, $beds, $baths, $sqft, $description, $address, $residence_type, $year_built, $date_listed) {

    // Insert new property
    $insert_query = $conn->prepare(
        "INSERT INTO properties (owner_id, price, beds, baths, sqft, description, address, residence_type, year_built, date_listed)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $insert_query->bind_param("iiiiisssis", $user_id, $price, $beds, $baths, $sqft, $description, $address, $residence_type, $year_built, $date_listed);

    if ($insert_query->execute()) {
        $insert_query->close();

        // Find the new property_id and save it for addPictures()
        $select_query = $conn->prepare(
            "SELECT MAX(property_id) FROM properties"
        );
        $select_query->execute();
        $select_query->bind_result($property_id);
        $select_query->fetch();
        $select_query->close();
        return true;
    }
    else {
        $insert_query->close();
        return false;
    }
}

/*--- New Property: Insert pictures ---*/

function addPictures($conn, $property_id, $exterior, $interior) {
    $insert_query = $conn->prepare("INSERT INTO pictures (property_id, exterior, interior) VALUES (?, ?, ?)");
    $insert_query->bind_param("iss", $property_id, $exterior, $interior);
    if ($insert_query->execute()) {
        $insert_query->close();
        return true;
    } else {
        $insert_query->close();
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
        case 4:
            return "There was a problem adding your property.";
            break;
        default:
            return "An unexpected error occurred. Please try again later.";
    }
}
