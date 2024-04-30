<!DOCTYPE html>
<html>
<head>
    <title>Food Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .items {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            transition: box-shadow 0.3s ease-in-out;
        }

        .items:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .items h3 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .items p {
            margin-top: 10px;
            font-size: 16px;
            color: #777;
        }

        .items img {
            max-width: 200px;
            height: auto;
            margin-left: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .items button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .items button:hover {
            background-color: #0056b3;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .items {
                flex-direction: column;
                align-items: flex-start;
            }

            .items img {
                margin-left: 0;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <?php
        // Database connection
        $servername = "localhost"; // Change this to your database server name
        $username = "root"; // Change this to your database username
        $password = ""; // Change this to your database password
        $dbname = "food_db"; // Change this to your database name

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve all food data from the database
        $sql = "SELECT * FROM Food";
        $result = $conn->query($sql);

        // Check if there are any records
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["name"];
                $description = $row["description"];
                $image = base64_encode($row["image"]); // Convert BLOB data to base64 for displaying images

                // Display food details in a div box
                echo "<div class='items'>";
                echo "<div>";
                echo "<h3>$name</h3>";
                echo "<p>$description</p>";
                echo "<button onclick='editItem($id)'>Edit</button>";
                echo "<button onclick='deleteItem($id)'>Delete</button>";
                echo "</div>";
                echo "<img src='data:image/jpeg;base64,$image'>";
                echo "</div>";
            }
        } else {
            echo "No food items found";
        }

        $conn->close();
    ?>

</div>

<script>
    function editItem(id) {
        // Redirect to edit page with the food item ID
        window.location.href = "update.php?id=" + id;
    }

    function deleteItem(id) {
        // Redirect to delete page with the food item ID
        if (confirm("Are you sure you want to delete this item?")) {
            window.location.href = "delete_item.php?id=" + id;
        }
    }
</script>

</body>
</html>
