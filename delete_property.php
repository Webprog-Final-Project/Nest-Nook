<?php require ('functions.php');
session_start();

$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

if ($_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_GET['property_id'])) {

    $property_id = $_GET['property_id'];

    if (deleteProperty($conn, $property_id)) {
        //Redirect on success
        header('location: seller_dashboard.php?message=5');
        exit;
    } else {
        // Redirect on error
        header("Location: seller_dashboard.php?error=6");
        exit;
    }
}
closeConnection($conn);
?>