<!DOCTYPE html>
<html>
<head>
    <title>Insert Fast Food</title>
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

        .fast-food-form label {
            display: block;
            margin-bottom: 8px;
            color: #555555;
        }

        .fast-food-form input[type="text"],
        .fast-food-form input[type="file"] {
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

        .fast-food-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e3e6f0;
            padding: 10px 0;
        }

        .fast-food-item img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 20px;
            border-radius: 5px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-update {
            background-color: #28a745;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Insert Fast Food</h2>

    <?php
    include 'connection.php';

    $message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $price = $_POST['price'];

        $sql = "INSERT INTO fast_food (name, image, price) VALUES ('$name', '$image', '$price')";

        if ($conn->query($sql) === TRUE) {
            $message = "New record created successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

    <form id="fast-food-form" enctype="multipart/form-data" class="fast-food-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>
        <br><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
        <br><br>

        <input type="button" value="Submit" class="submit-btn" onclick="addFastFood()">
    </form>

    <?php
    if ($message) {
        echo "<p class='message'>$message</p>";
    }

    $sql = "SELECT * FROM fast_food";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='fast-food-item' id='fast-food-item-{$row['id']}'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "'>";
            echo "<div>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<p>Price: $" . $row['price'] . "</p>";
            echo "</div>";
            echo "<div class='btn-group'>";
            echo "<button class='btn btn-update' onclick='editFastFood(" . $row['id'] . ")'>Update</button>";
            echo "<button class='btn btn-delete' onclick='deleteFastFood(" . $row['id'] . ")'>Delete</button>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No fast foods available</p>";
    }

    // Close the database connection
    $conn->close();
    ?>

    <script>
        function addFastFood() {
            const formData = new FormData(document.getElementById('fast-food-form'));

            fetch('add_fast_food.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('fast-food-form').reset();
                    const newItem = `
                        <div class='fast-food-item' id='fast-food-item-${data.id}'>
                            <img src='data:image/jpeg;base64,${data.image}'">
                            <div>
                                <h3>${data.name}</h3>
                                <p>Price: $${data.price}</p>
                            </div>
                            <div class='btn-group'>
                                <button class='btn btn-update' onclick='editFastFood(${data.id})'>Update</button>
                                <button class='btn btn-delete' onclick='deleteFastFood(${data.id})'>Delete</button>
                            </div>
                        </div>
                    `;
                    document.querySelector('.container').insertAdjacentHTML('beforeend', newItem);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function editFastFood(id) {
            const item = document.getElementById(`fast-food-item-${id}`);
            const name = item.querySelector('h3').innerText;
            const price = item.querySelector('p').innerText.replace('Price: $', '');
            const imageSrc = item.querySelector('img').src;

            document.getElementById('name').value = name;
            document.getElementById('price').value = price;
          
            document.getElementById('image').value = '';

            document.querySelector('.submit-btn').value = 'Update';
            document.querySelector('.submit-btn').onclick = function() {
                updateFastFood(id);
            };
        }

        function updateFastFood(id) {
            const formData = new FormData(document.getElementById('fast-food-form'));
            formData.append('id', id);

            fetch('update_fast_food.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById(`fast-food-item-${id}`).querySelector('h3').innerText = data.name;
                    document.getElementById(`fast-food-item-${id}`).querySelector('p').innerText = `Price: $${data.price}`;
                    document.querySelector('.submit-btn').value = 'Submit';
                    document.querySelector('.submit-btn').onclick = function() {
                        addFastFood();
                    };
                    document.getElementById('fast-food-form').reset();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function deleteFastFood(id) {
            if (confirm('Are you sure you want to delete this fast food?')) {
                fetch(`delete_fast_food.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById(`fast-food-item-${id}`).remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }
    </script>

</div>

</body>
</html>
