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
    $name = $_POST['name'];
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $price = $_POST['price'];

    $sql = "INSERT INTO Pizza (name, image, price) VALUES ('$name', '$image', '$price')";

    if ($conn->query($sql) === TRUE) {
        $message = "New record created successfully";
        $last_id = $conn->insert_id;
        echo json_encode(['success' => true, 'id' => $last_id, 'name' => $name, 'price' => $price, 'image' => base64_encode($image)]);
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        echo json_encode(['success' => false, 'message' => $message]);
    }
}

$conn->close();
?>
