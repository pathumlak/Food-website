<?php

$servername = 'localhost';
$username = 'root';
$dbname = 'food_db';
$password = '';

$conn = new mysqli($servername,$username,$password,$dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




?>