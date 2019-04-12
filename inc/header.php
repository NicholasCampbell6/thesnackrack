<?php session_start(); 
require "./inc/dbh.inc.php";


// print the error message if it's set


if(isset($errMsg)) {
    echo "<div id = 'windBack'><div id = 'loginErr'>";
    
    echo "<x onclick = \"closeWindow('windBack')\">&#10007
    <span class = \"tooltip\">Close Window</span>
    </x>";
    
    echo "<h3>Error &#9888</h3>";
    
    echo $errMsg;
    
    echo "</div></div>";
}


// print the success message if it's set


if(isset($successMsg)) {
    echo "<div id = 'windBack'><div id = 'loginSuccess'>";
    
    echo "<x onclick = \"closeWindow('windBack')\">&#10007
    <span class = \"tooltip\">Close Window</span>
    </x>";
    
    echo "<h3>Welcome</h3>";
    
    echo $successMsg;
    
    echo "</div></div>";
}

//remove variables if user clicks log out

if($_POST['logOut'] == 'Log Out'){
    
    $_SESSION['loggedIn'] = FALSE;
    
    $_SESSION['username'] = NULL;
    
    $_SESSION['password'] = NULL;
    
    $_SESSION['userID'] = NULL;
    
    header('Location: ./index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>The Snack Rack</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel = "stylesheet" type = "text/css" href = "./style.css"/>
        <link href="https://fonts.googleapis.com/css?family=Coiny|Permanent+Marker|Bitter" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript" src="/scripts/scripts.js"></script>
    </head>
    <body onload = "showLogin();">
        
        <div class = "navbar">
            <a id = "home" href = 
            <?php 
            if ($_SERVER['PHP_SELF'] == "/index.php") {
                echo "#";
            }else{
                echo "/index.php";
            }?>
            ><div id = "logo">The Snack Rack</div></a>
            <a href = "index.php#bread"><div class = "navButton">Breads <i class="fas fa-bread-slice"></i></div></a>
            <a href = "index.php#Desserts"><div class = "navButton">Desserts <i class="fas fa-cookie-bite"></i></div></a>
            <a href = "./cart.php"><div class = "navButton">Cart <i class="fas fa-shopping-cart"></i></div></a>
            <div onclick = "showLogin()" class = "navButton" id = "login"> 
            
            <?php
            if($_SESSION['loggedIn'] != TRUE) {
                echo "Login <i class='fas fa-sign-in-alt'></i>";
            }else if ($_SESSION['loggedIn'] == TRUE){
                echo $_SESSION['username'] . "<i class='fas fa-user-circle'></i>";
            }
            ?>
            
            </div>
        </div>
        <div id = "loginScreen">
            
            <?php 
            
            
            //If the user is logged in, print the 'Log Out' button.
            
            
            if ($_SESSION['loggedIn'] == true) {
                echo "<h2 style = 'text-align: center;'>Welcome</h2>";
                echo "Welcome, ". $_SESSION['username'];
                if ($_SESSION['role'] == 3){
                    echo "<br /><a href = './adminView.php'><button>Manager's View</button></a>";
                }else if ($_SESSION['role'] == 2) {
                    echo "<br /><a href = './adminView.php'><button>Chef's View</button></a>";
                }
                echo "
                    <form method = 'POST'>
                        <input type = 'submit' value = 'Log Out' name = 'logOut'>
                    </form>
                ";
            }else{
                
                
                
                //If user is not logged in, print the login window.
                
                
                
                echo "
                
                
                <h1 style = \"text-align: center;\">Login</h1>
                <form method = \"POST\">
                    <label for = \"emailUsername\">Email or Username</label>
                    <input type = \"text\" name = \"emailUsername\" id = \"emailUsername\"></input><br />
                    <label for = \"userPass\">Password</label>
                    <input type = \"password\" name = \"userPass\" id = \"userPass\"></input><br />
                    <input type = \"submit\" value = \"Submit\" name = \"submit2\">
                </form>
                
                
                <p>Don't have an account? <a href = \"signup.php\">Make one!</a></p>";
            }
            ?>
        </div>
        
        <?php 
if(isset($_POST["submit2"])){
    
    $emailUsername = $_POST['emailUsername'];
    $password = $_POST['userPass'];
    
    
    if (empty($emailUsername) || empty($password)){
        
        $errMsg = "<p>Please fill out the fields.</p>";
        
    }else{
        
        
        $sql = "SELECT * FROM users WHERE username = ? or email = ?;";
        
        $stmt =  mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            
            header("Location: ./index.php?error=sqlerror");
            
            
            
        }else{
            mysqli_stmt_bind_param($stmt, "ss", $emailUsername, $emailUsername);
            
            mysqli_stmt_execute($stmt);
            
            $results = mysqli_stmt_get_result($stmt);
            
            if($row = mysqli_fetch_assoc($results)){
                
                $pwdCheck = password_verify($password, $row['password']);
                
                if($pwdCheck == FALSE){
                    
                    header("Location: ./index.php?error=wrongPassword");
                    
                    
                    
                }else if($pwdCheck == TRUE){
                     
                     
                     $_SESSION['userID'] = $row['id'];
                     
                     $_SESSION['username'] = $row['username'];
                     
                     $_SESSION['role'] = $row['role'];
                     
                     
                     
                     $_SESSION['loggedIn'] = true;
                     
                     header("Location: ./index.php?login=success");
                     
                     
                     
                }else {
                    
                    header("Location: ./index.php?error=wrongPassword");
                    
                    
                }
            }else{
                
                header("Locaation: ./index.php?error=noUser");
                
                
            }
        }
    }
}
?>
