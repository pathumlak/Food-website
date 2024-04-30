<!DOCTYPE html>
<html>
<head>
    <title>Edit Food Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        form input[type="text"],
        form textarea,
        form input[type="file"],
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        img {
            max-width: 200px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

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

        // Fetch the food item details based on the ID
        $sql = "SELECT * FROM Food WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row["name"];
            $description = $row["description"];
            $image = base64_encode($row["image"]);

            // Check if the update form is submitted
            if(isset($_POST['update'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];

                if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
                    $image = $_FILES['image']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));
                } else {
                    $imgContent = null;
                }

                // Update the food item details in the database
                $update_sql = "UPDATE Food SET name='$name', description='$description'";

                if($imgContent) {
                    $update_sql .= ", image='$imgContent'";
                }

                $update_sql .= " WHERE id=$id";

                if ($conn->query($update_sql) === TRUE) {
                    echo "Food item updated successfully";
                } else {
                    echo "Error updating food item: " . $conn->error;
                }
            }

            // Display edit form
            echo "<h2>Edit Food Item</h2>";
            echo "<form action='' method='post' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='id' value='$id'>";
            echo "Name: <input type='text' name='name' value='$name'><br><br>";
            echo "Description: <textarea name='description'>$description</textarea><br><br>";
            echo "Image: <img src='data:image/jpeg;base64,$image'><br>";
            echo "<input type='file' name='image'><br><br>";
            echo "<input type='submit' name='update' value='Update'>";
            echo "</form>";
        } else {
            echo "Food item not found";
        }
    } else {
        echo "Invalid request";
    }

    $conn->close();
?>

</body>
</html>
