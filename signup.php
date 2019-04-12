<?php
include './inc/header.php';
$username = $_POST['username'];
$email = $_POST['email'];
$conEmail = $_POST['conEmail'];
if($_SESSION['signedUp'] == TRUE){
    unset($username);
    unset($email);
    unset($conEmail);
    unset($_SESSION['signedUp']);
}
?>

<div id = "signup">
    
    <form method = "POST" id = "signupForm"></form>
    <h1 class = "title">Sign Up</h1>
        <table id = "SUTable">
            <tr>
                <th><label for = "username">Username</label></th>
                <td><input type = "text" name = "username" id = "username" form = "signupForm" <?php 
                if(isset($username)){
                    echo "value = '" . $username . "'";
                    
                }
                
                ?>></td>
            </tr>
            <tr>
                <th><label for = "email">Email</label></th>
                <td><input type = "text" name = "email" id = "email" form = "signupForm" <?php 
                if(isset($email)){
                    echo "value = '" . $email . "'";
                    
                }
                
                ?>></td>
            </tr>
            <tr>
                <th><label for = "conEmail">Confirm Email</label></th>
                <td><input type = "text" name = "conEmail" id = "conEmail" form = "signupForm" <?php 
                if(isset($conEmail)){
                    echo "value = '" . $conEmail . "'";
                    
                }
                ?>></td>
            </tr>
            <tr>
                <th><label for = "password">Password</label></th>
                <td><input type = "password" name = "password" id = "password" form = "signupForm"></td>
            </tr>
            <tr>
                <th><label for = "conPass">Confirm Password</label></th>
                <td><input type = "password" name = "conPass" id = "conPass" form = "signupForm"></td>
            </tr>
            </table>
            <input id = "submitBtn" type = "submit" value = "Submit" name = "submit" form = "signupForm">
         <?php
         
            if ($_POST['submit'] == "Submit"){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $conEmail = $_POST['conEmail'];
                $password = $_POST['password'];
                $conPass = $_POST['conPass'];
                if (empty($username) || empty($email) || empty($password) || empty($conPass) || empty($conEmail)){
                    $errMsg = "<p>Please fill out all fields.</p>";
                    
                    
                    
                    if (empty($username)){
                        echo "<script>showError('username')</script>";
                    }
                    if (empty($email)){
                        echo "<script>showError('email')</script>";
                    }
                    if (empty($conEmail)){
                        echo "<script>showError('conEmail')</script>";
                    }
                    if (empty($password)){
                        echo "<script>showError('password')</script>";
                    }
                    if (empty($conPass)){
                        echo "<script>showError('conPass')</script>";
                    }
                    
                    
                }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errMsg = "<p>Please enter a valid email.</p>";
                    
                    echo "<script>showError('email')</script>";
                    
                    
                }else if ($email !== $conEmail) {
                    $errMsg = "<p>The emails do not match.</p>";
                    
                    echo "<script>showError('email')</script>";
                    echo "<script>showError('conEmail')</script>";
                    
                    
                    
                }else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                    
                    $errMsg = "<p>The username can only contain letter and numbers.</p>";
                    echo "<script>showError('username')</script>";
                    
                    
                }else if ($password !== $conPass){
                    $errMsg = "<p>The passwords do not match.</p>";
                    
                    echo "<script>showError('password')</script>";
                    echo "<script>showError('conPass')</script>";
                    
                    
                }else{
                    $sql = "SELECT username FROM users WHERE username =?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ./signup.php?signup=sqlerror;");
                        exit;
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        $resultCheck = mysqli_stmt_num_rows($stmt);
                        if($resultCheck > 0){
                            $errMsg = "<p>This username is already in use.</p>";
                            echo "<script>showError('username')</script>";
                        } else {
                            $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                header("Location: ./signup.php?signup=sqlerror;");
                                exit;
                            }else{
                                $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                                
                                
                                mysqli_stmt_bind_param($stmt, "sss", $username, $hashedPass , $email);
                                mysqli_stmt_execute($stmt);
                                
                                header("Location: ./signup.php?signup=success;");
                                exit;
                                
                            }
                        }
                    }
                }
                
            }
            if ($_POST['submit'] == "Submit"){
                if(isset($errMsg)) {
                    echo "<div id = 'windBack'><div id = 'errorMsg'>";
                    echo "<x onclick = \"closeWindow('windBack')\">&#10007
                    <span class = \"tooltip\">Close Window</span>
                    </x>";
                    echo "<h3>Error &#9888</h3>";
                    echo $errMsg;
                    echo "</div></div>";
                }else if (!$errMsg){
                    echo "<div id = 'windBack'><div id = 'thankYou'>";
                    echo "<x onclick = \"closeWindow('thankYou')\">&#10007
                    <span class = \"tooltip\">Close Window</span>
                    </x>";
                    echo "<h3>Thank you for signing up</h3>";
                    echo "</div>";
                    $_SESSION['signedUp'] = TRUE;
                }
            }
            ?>
</div>