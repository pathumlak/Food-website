<!DOCTYPE html>
<html>
<head>
    <title>Insert Chinese Food</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333333;
        }

        .chinese-food-form label {
            display: block;
            margin-bottom: 8px;
            color: #555555;
        }

        .chinese-food-form input[type="text"],
        .chinese-food-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #cccccc;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .message {
            color: green;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Insert Chinese Food</h2>

    <?php
    include 'connection.php';

    $message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $price = $_POST['price'];

        $sql = "INSERT INTO chinese_food (name, image, price) VALUES ('$name', '$image', '$price')";

        if ($conn->query($sql) === TRUE) {
            $message = "New record created successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class="chinese-food-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>
        <br><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
        <br><br>

        <input type="submit" value="Submit" class="submit-btn">
    </form>

    <?php
    if ($message) {
        echo "<p class='message'>$message</p>";
    }

    // Close the database connection
    $conn->close();
    ?>

</div>

</body>
</html>
