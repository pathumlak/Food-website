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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Pizza WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully";
        echo json_encode(['success' => true]);
    } else {
        $message = "Error deleting record: " . $conn->error;
        echo json_encode(['success' => false, 'message' => $message]);
    }
}

$conn->close();
?>
