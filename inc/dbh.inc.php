<?php
$severname = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "theSnackRack";

$conn = mysqli_connect($severname, $dbUsername, $dbPassword, $dbName);
if(!$conn) {
    die("Connect Failed: ".mysqli_connect_error());
}


$mysqli = new mysqli("localhost", "root", "", "theSnackRack");