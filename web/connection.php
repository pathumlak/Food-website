<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbname = "food_db";


//create a connection

$conn = new mysqli($serverName, $username, $password, $dbname);

//check connection
if($conn->connect_error){
    die("connection faied: " . $conn->connect_error);
}

?>