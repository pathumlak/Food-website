<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "food_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image']['tmp_name'];

    if (!empty($name) && !empty($image)) {
        // Read image data
        $imgData = addslashes(file_get_contents($image));

        // Insert food details into database
        $sql = "INSERT INTO Food (name, description, image) VALUES ('$name', '$description', '$imgData')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Name and image are required fields";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Food</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .upload-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .upload-container h2 {
            text-align: center;
            color: #333333;
        }
        .upload-container label, .upload-container input, .upload-container textarea {
            width: 100%;
            margin-bottom: 10px;
        }
        .upload-container input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: #ff0000;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2>Upload Food</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea><br><br>
            <label for="image">Image:</label><br>
            <input type="file" id="image" name="image" required><br><br>
            <input type="submit" value="Submit">
        </form>

        <?php if (isset($error)) { echo '<div class="error">' . $error . '</div>'; } ?>
    </div>
</body>
</html>
