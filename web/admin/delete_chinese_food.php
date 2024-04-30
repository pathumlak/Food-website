<?php
include 'connection.php';

$message = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM chinese_food WHERE id='$id'";

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
