<?php require ('functions.php');
session_start();

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_FILES['interior'])
    && isset($_FILES['exterior'])) {

    $property_id = '';
    $user_id = $_SESSION['user_id'];
    $price = $_POST['price'];
    $address = $_POST['address'];
    $residence_type = $_POST['residence_type'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $sqft = $_POST['sqft'];
    $year_built = $_POST['year_built'];
    $interior = file_get_contents($_FILES['interior']['tmp_name']);
    $interior = $conn->real_escape_string($interior);
    $exterior = file_get_contents($_FILES['exterior']['tmp_name']);
    $exterior = $conn->real_escape_string($exterior);
    $description = $_POST['description'];
    $date_listed = date("Y-m-d");


    if (addProperty($conn, $user_id, $property_id, $price, $beds, $baths, $sqft, $description, $address, $residence_type, $year_built, $date_listed)
            && addPictures($conn, $property_id, $exterior, $interior)) {
        //Redirect on success
        header('location: seller_dashboard.php?message=Data saved successfully');
        exit;
    } else {
        // Redirect on error
        header("Location: seller_dashboard.php?error=4");
        exit;
    }
}
closeConnection($conn);
?>