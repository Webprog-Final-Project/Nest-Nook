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
		// If not: set error
		else {
			$select_query->close();
            header("Location: signup.php?error=2");
            exit;
		}
	}
	else {
		$select_query->close();
        header("Location: signup.php?error=default");
        exit;
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
        $insert_query->close();
		header("location: signup.php?message=1");
		exit;
	}
	else {
        $insert_query->close();
        header("Location: signup.php?error=$insert_query->error");
        exit;
	}
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

function addPictures($conn, $property_id, $exterior, $exterior_file_type, $interior, $interior_file_type) {
    $insert_query = $conn->prepare("INSERT INTO pictures (property_id, exterior, exterior_file_type, interior, interior_file_type) VALUES (?, ?, ?, ?, ?)");
    $insert_query->bind_param("ibsbs", $property_id, $exterior, $exterior_file_type, $interior, $interior_file_type);
    $insert_query->send_long_data(3, $interior);
    $insert_query->send_long_data(1, $exterior);
    if ($insert_query->execute()) {
        $insert_query->close();
        return true;
    } else {
        $insert_query->close();
        return false;
    }
}

/*--- Used to display all properties of the user ---*/

function displayPropertyCards($conn, $user_id) {
    $property_id = '';
    $price = '';
    $beds = '';
    $baths = '';
    $sqft = '';
    $address = '';
    $select_query = $conn->prepare("SELECT property_id, price, beds, baths, sqft, address FROM properties WHERE owner_id = ?");
    $select_query->bind_param("i", $user_id);

    if ($select_query->execute()) {
        $select_query->store_result();
        $select_query->bind_result($property_id, $price, $beds, $baths, $sqft, $address);

        while ($select_query->fetch()) {
        	echo "<a href='property_details.php?property_id=$property_id' class='property-link'>";
		echo "<div class='exterior_image'>" . displayExterior($conn, $property_id) . "</div>";
	        echo "<div class='price'>$" . number_format($price, 0, '', ',') . "</div>";
	        echo "<div class='property-details'>";
	        echo "<div class='bedrooms'>" . $beds . " Beds" . "</div>";
	        echo "<div class='separator'>|</div>";
	        echo "<div class='baths'>" . $baths . " Baths" . "</div>";
	        echo "<div class='separator'>|</div>";
	        echo "<div class='sqft'>" . number_format($sqft, 0, '', ',') . " sqft" . "</div>";
	        echo "</div>";
	        echo "<div class='address'>" . $address . "</div>";
	        echo "</a>";
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    // Close the prepared statement
    $select_query->close();
}

/*--- Used to display all properties' exterior pictures ---*/

function displayExterior($conn, $property_id) {
    $exterior = '';
    $exterior_file_type = '';
    $select_query = $conn->prepare("SELECT exterior, exterior_file_type FROM pictures WHERE property_id = ?");
    $select_query->bind_param("i", $property_id);
    $select_query->execute();
    $select_query->bind_result($exterior, $exterior_file_type);
    $select_query->fetch();
    $select_query->close();

    // Output the image data as a base64-encoded string
    $imageDataEncoded = base64_encode($exterior);

    return "<img src='data:$exterior_file_type;base64,$imageDataEncoded' alt='Exterior' height='175px'>";
}

/*--- Used to display all properties' interior pictures ---*/

function displayInterior($conn, $property_id) {
    $interior = '';
    $interior_file_type = '';
    $select_query = $conn->prepare("SELECT interior, interior_file_type FROM pictures WHERE property_id = ?");
    $select_query->bind_param("i", $property_id);
    $select_query->execute();
    $select_query->bind_result($interior, $interior_file_type);
    $select_query->fetch();
    $select_query->close();

    // Output the image data as a base64-encoded string
    $imageDataEncoded = base64_encode($interior);

    return "<img src='data:$interior_file_type;base64,$imageDataEncoded' alt='Interior' height='175px'>";
}

/*--- Displays full property details ---*/

function propertyDetails($conn, $property_id) {
    $price = '';
    $beds = '';
    $baths = '';
    $sqft = '';
    $description = '';
    $address = '';
    $residence_type = '';
    $year_built = '';
    $date_listed = '';
    $select_query = $conn->prepare(
        "SELECT price, beds, baths, sqft, description, address, residence_type, year_built, date_listed FROM properties WHERE property_id = ?");
    $select_query->bind_param("i", $property_id);

    if ($select_query->execute()) {
        $select_query->store_result();
        $select_query->bind_result($price, $beds, $baths, $sqft, $description, $address, $residence_type, $year_built, $date_listed);

        $select_query->fetch();
        echo "<div class='property-details'>";
            echo "<div class='property-images'>";
                echo "<div>" . displayExterior($conn, $property_id) . "</div>";
                echo "<div>" . displayInterior($conn, $property_id) . "</div>";
            echo "</div>";
            echo "<div>$" . number_format($price, 0, '', ',') . "</div>";
            echo "<div>" . $address . "</div>";
            echo "<div>" . $residence_type . "</div>";
            echo "<div>" . $beds . " bed" . "</div>";
            echo "<div>" . $baths . " bath" . "</div>";
            echo "<div>" . number_format($sqft, 0, '', ',') . " sqft" . "</div>";
            echo "<div>" . $year_built . "</div>";
            echo "<div>" . $date_listed . "</div>";
            echo "<div>" . $description . "</div>";
        echo "</div>";
    } else {
        echo "Error executing query: " . $conn->error;
    }

    // Close the prepared statement
    $select_query->close();
}

/*--- For edit_property page: fills the forms with the current values so user can edit ---*/

function populateForm($conn, $property_id, &$price, &$address, &$beds, &$baths, &$sqft, &$year_built, &$description) {

    $select_query = $conn->prepare(
        "SELECT price, beds, baths, sqft, description, address, year_built FROM properties WHERE property_id = ?");
    $select_query->bind_param("i", $property_id);

    if ($select_query->execute()) {
        $select_query->store_result();
        $select_query->bind_result($price, $beds, $baths, $sqft, $description, $address, $year_built);
        $select_query->fetch();

    } else {
        echo "Error executing query: " . $conn->error;
    }
    // Close the prepared statement
    $select_query->close();
}

/*--- For process_edit_property: sends new inputs and updates DB ---*/

function updateProperty($conn, $property_id, $price, $beds, $baths, $sqft, $residence_type, $description, $address, $year_built) {

    // Insert new property
    $update_query = $conn->prepare(
        "UPDATE properties
            SET price = ?,
                beds = ?,
                baths = ?,
                sqft = ?,
                description = ?,
                address = ?,
                residence_type = ?,
                year_built = ?
            WHERE property_id = ?"
    );
    $update_query->bind_param("iiiissssi", $price, $beds, $baths, $sqft, $description, $address, $residence_type, $year_built, $property_id);

    if ($update_query->execute()) {
        $update_query->close();
        return true;
    }
    else {
        $update_query->close();
        return false;
    }
}

/*--- Delete Property ---*/

function deleteProperty($conn, $property_id) {
    $delete_query = $conn->prepare("DELETE FROM properties WHERE property_id = ?");
    $delete_query->bind_param("i", $property_id);
    if ($delete_query->execute()) {
        $delete_query->close();
        return true;
    }
    else {
        $delete_query->close();
        return false;
    }
}

/*--- Display error message ---*/

function displayError($error) {
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
        case 5:
            return "There was a problem updating your property.";
            break;
        case 6:
            return "There was a problem deleting your property.";
            break;
        default:
            return "An unexpected error occurred. Please try again later.";
    }
}

/*--- Display message ---*/

function displayMessage($message) {
    switch ($message) {
        case 1:
            return "Thank you for signing up with us!";
            break;
        case 2:
            return "You've logged in successfully!";
            break;
        case 3:
            return "Your new property has been added!";
            break;
        case 4:
            return "Property successfully updated!";
            break;
        case 5:
            return "Property successfully deleted!";
            break;
        default:
            return false;
    }
}

/*--- Get image file type ---*/

function getImageType($image) {
    // Create a FileInfo object
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    // Get the MIME type of the uploaded image
    $mime = finfo_file($finfo, $image);

    // Close the FileInfo object
    finfo_close($finfo);

    // Output the MIME type
    return $mime;
}
