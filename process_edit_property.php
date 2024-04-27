<?php require ('functions.php');
session_start();

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_GET['property_id'])) {

    $property_id = $_GET['property_id'];
    $price = $_POST['price'];
    $address = $_POST['address'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $sqft = $_POST['sqft'];
    $year_built = $_POST['year_built'];
    $residence_type = $_POST['residence_type'];
    $description = $_POST['description'];

    if (updateProperty($conn, $property_id, $price, $beds, $baths, $sqft, $residence_type, $description, $address, $year_built)) {
        //Redirect on success
        header('location: seller_dashboard.php?message=Property successfully updated!');
        exit;
    } else {
        // Redirect on error
        header("Location: edit_property.php?error=5");
        exit;
    }
}
closeConnection($conn);
?>