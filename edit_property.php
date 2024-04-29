<?php require ('functions.php');
session_start();
$conn = openConnection("localhost", "lkinsey2", "lkinsey2", "lkinsey2");

$property_id = isset($_GET['property_id']) ? $_GET['property_id'] : null;
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
    <link rel="stylesheet" type="text/css" href="css/edit_property.css">
</head>
<body>
    <nav class="nav_bar">
        <h2 class="title">Nest Nook</h2>
        <ul class="nav_links">
            <li class="home"><a href="homepage.html">Home</a></li>
            <li class="buy"><a href="buy.html">Buy</a></li>
            <li class="sell"><a hre="sell.html">Sell</a></li>
            <li class="contact"><a hre="contact.html">Contact</a></li>
        </ul>
        <ul class="auth_links">
            <li class="signup"><a href="signup.php">Sign up</a></li>
            <li class="login"><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <div class="back_button">
        <a href="seller_dashboard.php">Back</a>
    </div>
    <div class="content_container">
        <h2 class="title">Edit Property</h2>
        <form action = "process_edit_property.php?property_id=<?=$property_id?>" method="post">

            <?php if ($property_id) { ?>
                <div class="edit_property_images">
                    <div class="exterior_image"><?=displayExterior($conn, $property_id);?></div>
                    <div class="interior_image"><?=displayInterior($conn, $property_id);?></div>
                </div>
            <?php } ?>
            <div class="form_container">
                <div class="left-column">
                <label for="price">Price</label>
                </div>
                <div class="right-column">
                    <input type="number" id="price" name="price" value="<?=$price?>" required><br>
                </div>
                
                <div class="left-column">
                    <label for="address">Address</label>
                </div>
                <div class="right-column">
                    <input type="text" id="address" name="address" value="<?=$address?>" required><br>
                </div>
                
                <div class="left-column">
                    <p>Residence Type</p>
                </div>
                <div class="right-column-residence">
                    
                    <input type="radio" id="house" name="residence_type" value="House" required>
                    <label for="house">House</label><br>
                    
                    <input type="radio" id="apartment" name="residence_type" value="Apartment" required>
                    <label for="apartment">Apartment</label><br>

                    <input type="radio" id="condominium" name="residence_type" value="Condominium" required>
                    <label for="condominium">Condominium</label>
                </div>

                <div class="left-column">
                    <label for="beds">Number of bedrooms</label>
                </div>
                <div class="right-column">
                    <input type="number" min="1" id="beds" name="beds" value="<?=$beds?>" required><br>
                </div>

                <div class="left-column">
                    <label for="baths">Number of bathrooms</label>
                </div>
                <div class="right-column">
                    <input type="number" min="1" id="baths" name="baths" value="<?=$baths?>" required><br>
                </div>
                
                <div class="left-column">
                    <label for="sqft">Number of Square feet</label>
                </div>
                <div class="right-column">
                    <input type="number" min="1" id="sqft" name="sqft" value="<?=$sqft?>" required><br>
                </div>

                <div class="left-column">
                    <label for="year_built">Year built</label>
                </div>
                <div class="right-column">
                    <input type="number" min="1900" max="2024" step="1" id="year_built" name="year_built" value="<?=$year_built?>" required><br>
                </div>
                
                <div class="left-column">
                    <label for="description">Description</label>
                </div>
                <div class="right-column">
                    <textarea id="description" name="description" rows="8" cols="70" required><?=$description?> </textarea>
                </div>
            </div>
            

            <input type="submit" value="Submit">
        </form>
    </div>
    
</body>
</html>
