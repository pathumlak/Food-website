<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "tech";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$price = $_POST["price"];

$sql = "SELECT * FROM products WHERE price = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("d", $price);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$conn->close();
?>
