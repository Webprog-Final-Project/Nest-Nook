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
    <link rel="stylesheet" type="text/css" href="css/property_details.css">
</head>
<body>
    <nav class="nav_bar">
        <h2 class="title">Nest Nook</h2>
        <ul class="nav_links">
            <li class="home"><a href="homepage.html">Home</a></li>
            <li class="buy"><a href="buy.html">Buy</a></li>
            <li class="sell"><a hre="sell.html">Sell</a></li>
            <li class="contac"><a hre="contact.html">Contact</a></li>
        </ul>
        <ul class="auth_links">
            <li class="signup"><a href="signup.php">Sign up</a></li>
            <li class="login"><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <div class="content_container">
        <div class="title">
            <h2>Property Details</h2> 
        </div>

        <div class="properties_container">
            <?php if ($property_id) {
                propertyDetails($conn, $property_id);
            } ?>
        </div>

        <div class="buttons">
            <a href="edit_property.php?property_id=<?=$property_id?>" class="edit_button">Edit Property</a>

            <?php
                if (!isset($_POST['delete?'])) { ?>
                    <form action="property_details.php?property_id=<?=$property_id?>" method="post">
                        <input type="submit" name="delete?" value="Delete Property" class="delete_button">
                    </form>
            <?php }

                else { ?>
                    <form action="delete_property.php?property_id=<?=$property_id?>" method="post">
                        <input type="submit" name="deletion_confirmed" value="Confirm Deletion">
                    </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
