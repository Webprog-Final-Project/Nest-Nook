<?php require ('functions.php');
session_start();
$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");
$property_id = isset($_GET['property_id']) ? $_GET['property_id'] : null;
$error = isset($_GET['error']) ? $_GET['error'] : null;
$message = isset($_GET['message']) ? $_GET['message'] : null;
$price = '';
$address = '';
$beds = '';
$baths = '';
$sqft = '';
$year_built = '';
$description = '';
populateForm($conn, $property_id, $price, $address, $beds, $baths, $sqft, $year_built, $description);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Property</title>
</head>
<body>
    <div class="back_button">
        <a href="seller_dashboard.php">Back</a>
    </div>
    <h1>Edit Property</h1>
    <form action = "process_edit_property.php?property_id=<?=$property_id?>" method="post">

        <?php if ($error): ?>
            <p><?= displayErrorMessage($error); ?></p>
        <?php endif; ?>

        <?php if ($property_id) { ?>
            <div id="edit_property_images">
                <?=displayExterior($conn, $property_id);?>
                <?=displayInterior($conn, $property_id);?>
            </div>
        <?php } ?>

        <label for="price">Price</label>
        <input type="number" id="price" name="price" value="<?=$price?>" required><br>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?=$address?>" required><br>

        <div>
            <p>Residence Type</p>
            <input type="radio" id="house" name="residence_type" value="House" required>
            <label for="house">House</label><br>

            <input type="radio" id="apartment" name="residence_type" value="Apartment" required>
            <label for="apartment">Apartment</label><br>

            <input type="radio" id="condominium" name="residence_type" value="Condominium" required>
            <label for="condominium">Condominium</label>

        </div>

        <label for="beds">Number of bedrooms</label>
        <input type="number" min="1" id="beds" name="beds" value="<?=$beds?>" required><br>

        <label for="baths">Number of bathrooms</label>
        <input type="number" min="1" id="baths" name="baths" value="<?=$baths?>" required><br>

        <label for="sqft">Number of Square feet</label>
        <input type="number" min="1" id="sqft" name="sqft" value="<?=$sqft?>" required><br>

        <label for="year_built">Year built</label>
        <input type="number" min="1900" max="2024" step="1" id="year_built" name="year_built" value="<?=$year_built?>" required><br>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="8" cols="70" required><?=$description?> </textarea>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
