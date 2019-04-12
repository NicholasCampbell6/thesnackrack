<?php
include("./inc/header.php");

if ($_SESSION['role'] == 3){
    
    ?>
    
    <h1 class = 'aTHeading'>Users</h1>
    <?php
    $usersTable = mysqli_query($conn, "SELECT users.username, users.email, userRoles.role FROM users, userRoles WHERE users.role = userRoles.id");
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    echo "<div class = 'adminTableContainer'><table border='1' class = 'adminTable'>
    <tr>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    </tr>";
    
    while ($row = mysqli_fetch_array($usersTable)){
        echo "<tr>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "</tr>";
    }
    echo "</table></div>";
}else if ($_SESSION['role'] == 1){
    header("Location: ./index.php");
}



if ($_SESSION['role'] == 2 || $_SESSION['role'] == 3){
    
    ?>
    <h1 class = 'aTHeading'>Ingredients in Stock</h1>
    <?php

    $ingredientsTable = mysqli_query($conn, "SELECT * FROM ingredients2");
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    
    echo "<div class = 'adminTableContainer'><table border='1' class = 'adminTable'>
    
    <tr>
    <th>Flour (Cups)</th>
    <th>Butter (Tablespoons)</th>
    <th>Salt (Teaspoons)</th>
    <th>Sugar (Cups)</th>
    <th>Vanilla Extract (Teaspoons)</th>
    <th>Almond Extract (Teaspoons)</th>
    <th>Baking Powder (Teaspoons)</th>
    <th>Eggs</th>
    <th>Cocoa Powder (Cups)</th>
    <th>Chocolate Chips (Cups)</th>
    <th>Corn Syrup (Cups)</th>
    <th>Lemons</th>
    <th>Yeast (Teaspoons)</th>
    <th>Canola Oil (Tablespoons)</th>
    <th>Cornstarch (Teaspoons)</th>
    </tr>
    
    
    <tr>";
    while ($row = mysqli_fetch_array($ingredientsTable)){
        
        echo "<td>" . $row['flour(cups)'] . "</td>";
        echo "<td>" . $row['butter(tablespoons)'] . "</td>";
        echo "<td>" . $row['salt(teaspoons)'] . "</td>";
        echo "<td>" . $row['sugar(cups)'] . "</td>";
        echo "<td>" . $row['vanillaExtract(teaspoons)'] . "</td>";
        echo "<td>" . $row['almondExtract(teaspoons)'] . "</td>";
        echo "<td>" . $row['bakingPowder(teaspoons)'] . "</td>";
        echo "<td>" . $row['eggs'] . "</td>";
        echo "<td>" . $row['cocoaPowder(cups)'] . "</td>";
        echo "<td>" . $row['chocolateChips(cups)'] . "</td>";
        echo "<td>" . $row['cornSyrup(cups)'] . "</td>";
        echo "<td>" . $row['lemon'] . "</td>";
        echo "<td>" . $row['yeast(teaspoons)'] . "</td>";
        echo "<td>" . $row['canolaOil(tablespoons)'] . "</td>";
        echo "<td>" . $row['cornstarch(teaspoons)'] . "</td>";
    }
    echo "</tr></table></div>";
    
    
    $ordersTable = mysqli_query($conn, "SELECT users.username, products.name 
                                        FROM users, products, orders 
                                        WHERE orders.userID = users.id && orders.productID = products.id");
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    ?>
    <h1 class = 'aTHeading'>Orders</h1>
    <?php
    echo "<div class = 'adminTableContainer'><table border='1' class = 'adminTable'>
    <tr>
    <th>User</th>
    <th>Product Name</th>
    
    </tr>";
    
    while ($row = mysqli_fetch_array($ordersTable)){
        echo "<tr>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "</tr>";
    }
    echo "</table></div>";
}
?>