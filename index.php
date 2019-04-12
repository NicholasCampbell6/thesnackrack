
<?php
include './inc/header.php';

?>


            
                 <div id = 'bread'>
                <h3 id = "breadHeading">Try Our Freshly Baked Breads</h3>
                
                
                <?php
                $breads = mysqli_query($conn, "SELECT * FROM products WHERE type = 'Bread'");
                
                if (mysqli_connect_errno()){
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }else{
                    while($row = mysqli_fetch_array($breads)){
                        echo "<div class = 'item'>
                        <div class = 'itemDesc'>";
                        echo "<h5 class = 'itemName'>" . $row['name'] . "</h5>";
                        echo "<h6 class = 'itemPrice'>$" . $row['price'] ."</h6>
                        <p class = 'includes'>Ingredients:</p>
                        <ul>";
                        
                        
                        $recipeIng = mysqli_query($conn, "SELECT `recipes`.`flour(cups)`, `recipes`.`vanillaExtract(teaspoons)`, `recipes`.`salt(teaspoons)` FROM products, recipes WHERE recipes.id = ".$row['recipeID']);
                        if (mysqli_connect_errno()){
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }else{
                            $ingRow = mysqli_fetch_array($recipeIng);
                        
                            if ($ingRow['flour(cups)'] != 0) {
                                echo "<li>Flour</li>";
                            }
                            if ($ingRow['vanillaExtract(teaspoons)'] != 0) {
                                echo "<li>Vanilla Extract</li>";
                            }
                            if ($ingRow['salt(teaspoons)'] != 0) {
                                echo "<li>Salt</li>";
                              }
                        }
                        echo "
                            <li>etc.</li>
                        </ul>
                        <img class = 'itemImg' src = '". $row['img'] . "'>
                        <form method = 'post' action = 'index.php?action=add&id= ". $row['id'] ."'>
                            <input type = 'hidden' name = 'name' value = ". $row['name'] ."/>
                            <input type = 'hidden' name = 'price' value = ". $row['price'] ."/>
                            <input class = 'addToCart' type = 'submit' value = 'Add to Cart' name = 'addToCart'/>
                        </form>
                        </div>
                        </div>";
                    }
                    
                }
                ?>
                
                
                </div>
            
            
            <div id = "Desserts"> 
                <h4 id = "DessertsHeading">Try Our Fresh, Home-Made Desserts!</h4>
                <?php
                $desserts = mysqli_query($conn, "SELECT * FROM products WHERE type = 'Dessert'");
                
                if (mysqli_connect_errno()){
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }else{
                    while($row = mysqli_fetch_array($desserts)){
                        echo "<div class = 'item'>
                    <div class = 'itemDesc'>";
                        echo "<h5 class = 'itemName'>" . $row['name'] . "</h5>";
                        echo "<h6 class = 'itemPrice'>$" . $row['price'] ."</h6>";
                        echo "<p class = 'includes'>Ingredients:</p>
                        <ul>";
                        
                        $recipeIng = mysqli_query($conn, "SELECT `recipes`.`flour(cups)`, `recipes`.`vanillaExtract(teaspoons)`, `recipes`.`salt(teaspoons)` FROM products, recipes WHERE recipes.id = ".$row['recipeID']);
                        if (mysqli_connect_errno()){
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }else{
                            $ingRow = mysqli_fetch_array($recipeIng);
                        
                            if ($ingRow['flour(cups)'] != 0) {
                                echo "<li>Flour</li>";
                            }
                            if ($ingRow['vanillaExtract(teaspoons)'] != 0) {
                                echo "<li>Vanilla Extract</li>";
                            }
                            if ($ingRow['salt(teaspoons)'] != 0) {
                                echo "<li>Salt</li>";
                              }
                        }
                        echo "
                            <li>etc.</li>
                        </ul>
                        <img class = 'itemImg' src = '". $row['img'] . "'>
                        <form method = 'post' action = 'index.php?action=add&id= ". $row['id'] ."'>
                            <input type = 'hidden' name = 'name' value = ". $row['name'] ."/>
                            <input type = 'hidden' name = 'price' value = ". $row['price'] ."/>
                            <input class = 'addToCart' type = 'submit' value = 'Add to Cart' name = 'addToCart'/>
                        </form>
                        </div>
                        </div>";
                    }
                    if ($_POST['addToCart'] == 'Add to Cart'){
                        if (!isset($_SESSION['userID'])){
                            header("Location: index.php");
                        }else{
                            $productID = filter_input(INPUT_GET, 'id');
                            
                            $mysqli->query("UPDATE  `ingredients2`, `recipes` SET  
                            `ingredients2`.`flour(cups)` = (`ingredients2`.`flour(cups)` - `recipes`.`flour(cups)`),  
                            `ingredients2`.`butter(tablespoons)` = (`ingredients2`.`butter(tablespoons)` - `recipes`.`butter(tablespoons)`),  
                            `ingredients2`.`salt(teaspoons)` = (`ingredients2`.`salt(teaspoons)` - `recipes`.`salt(teaspoons)`), 
                            `ingredients2`.`sugar(cups)` = (`ingredients2`.`sugar(cups)` - `recipes`.`sugar(cups)`), 
                            `ingredients2`.`vanillaExtract(teaspoons)` = (`ingredients2`.`vanillaExtract(teaspoons)` - `recipes`.`vanillaExtract(teaspoons)`), 
                            `ingredients2`.`almondExtract(teaspoons)` = (`ingredients2`.`almondExtract(teaspoons)` - `recipes`.`almondExtract(teaspoons)`), 
                            `ingredients2`.`bakingPowder(teaspoons)` = (`ingredients2`.`bakingPowder(teaspoons)` - `recipes`.`bakingPowder(teaspoons)`), 
                            `ingredients2`.`eggs` = (`ingredients2`.`eggs` - `recipes`.`eggs`), 
                            `ingredients2`.`cocoaPowder(cups)` = (`ingredients2`.`cocoaPowder(cups)` - `recipes`.`cocoaPowder(cups)`), 
                            `ingredients2`.`chocolateChips(cups)` = (`ingredients2`.`chocolateChips(cups)` - `recipes`.`chocolateChips(cups)`), 
                            `ingredients2`.`cornSyrup(cups)` = (`ingredients2`.`cornSyrup(cups)` - `recipes`.`cornSyrup(cups)`), 
                            `ingredients2`.`lemon` = (`ingredients2`.`lemon` - `recipes`.`lemon`), 
                            `ingredients2`.`yeast(teaspoons)` = (`ingredients2`.`yeast(teaspoons)` - `recipes`.`yeast(teaspoons)`), 
                            `ingredients2`.`canolaOil(tablespoons)` = (`ingredients2`.`canolaOil(tablespoons)` - `recipes`.`canolaOil(tablespoons)`), 
                            `ingredients2`.`cornstarch(teaspoons)` = (`ingredients2`.`cornstarch(teaspoons)` - `recipes`.`cornstarch(teaspoons)`)
                            
                            WHERE  recipes.id = ". $productID );
                            
                            $mysqli->query("INSERT INTO `orders` (`productID`, `userID`) VALUES (".$productID.", ".$_SESSION['userID'].");");
                        }
                    }
                }
                ?>
                
                    
            </div>
            </div>
            
            
        

    </body>
</html>