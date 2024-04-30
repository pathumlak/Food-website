<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $sql = "UPDATE Pizza SET name='$name', price='$price' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Record updated successfully";
        echo json_encode(['success' => true, 'id' => $id, 'name' => $name, 'price' => $price]);
    } else {
        $message = "Error updating record: " . $conn->error;
        echo json_encode(['success' => false, 'message' => $message]);
    }
}

$conn->close();
?>
