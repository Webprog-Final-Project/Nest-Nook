<?php require ('functions.php');
session_start();

// Check if an error occurred when adding property
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Property</title>
    </head>
    <body>
        <h1>Add Property</h1>
        <form action = "process_new_property.php" method="post" enctype="multipart/form-data">
        
            <?php if ($error): ?>
                <p><?php echo displayErrorMessage($error); ?></p>
            <?php endif; ?>
        
            <label for="price">Price</label>
            <input type="number" id="price" name="price" required><br>
        
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required><br>
        
            <div>
                <p>Residence Type</p>
                <input type="radio" id="house" name="residence_type" value="House">
                <label for="house">House</label><br>
        
                <input type="radio" id="apartment" name="residence_type" value="Apartment">
                <label for="apartment">Apartment</label><br>
        
                <input type="radio" id="condominium" name="residence_type" value="Condominium">
                <label for="condominium">Condominium</label>
        
            </div>
        
            <label for="beds">Number of bedrooms</label>
            <input type="number" id="beds" name="beds" required><br>
        
            <label for="baths">Number of bathrooms</label>
            <input type="number" id="baths" name="baths" required><br>
        
            <label for="sqft">Number of Square feet</label>
            <input type="number" id="sqft" name="sqft" required><br>
        
            <label for="year_built">Year built</label>
            <input type="number" min="1900" max="2024" step="1" id="year_built" name="year_built" required><br>
        
            <label for="interior">Interior pictures:</label>
            <input type="file" id="interior" name="interior" required>
        <br>
            <label for="exterior">Exterior pictures:</label>
            <input type="file" id="exterior" name="exterior" required>
        <br>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="8" cols="70" required></textarea>
        
            <input type="submit" value="Submit">
        </form>
    </body>
</html>
