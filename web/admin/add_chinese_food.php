<?php
include 'connection.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $sql = "UPDATE chinese_food SET name='$name', price='$price' WHERE id='$id'";

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
