<?php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "food_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize response array
$response = array();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare data for insertion
    $username = $_POST["username"];
    $email = $_POST["email"];
    $description = $_POST["description"];

    // SQL statement to insert data into the database
    $sql = "INSERT INTO contacts (username, email, description) VALUES ('$username', '$email', '$description')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Set success message in response
        $response["success"] = true;
        $response["message"] = "Thanks for your feedback!";
    } else {
        // Set error message in response
        $response["success"] = false;
        $response["message"] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($response);

?>
