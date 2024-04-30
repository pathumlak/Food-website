<?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "food_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // Delete the food item from the database
        $sql = "DELETE FROM Food WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Food item deleted successfully";
            header("Location: update.php"); 
        } else {
            echo "Error deleting food item: " . $conn->error;
        }
    } else {
        echo "Invalid request";
    }

    $conn->close();
?>
