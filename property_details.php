<?php require ('functions.php');
session_start();
$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");
$property_id = isset($_GET['property_id']) ? $_GET['property_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Property Details</title>
</head>
<body>
<h1>Property Details</h1>
<div>
    <?php if ($property_id) {
        propertyDetails($conn, $property_id);
    } ?>
</div>
</body>
