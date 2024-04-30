<!DOCTYPE html>
<html>
<head>
    <title>Insert Pizza</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
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

        .pizza-form label {
            display: block;
            margin-bottom: 8px;
            color: #555555;
        }

        .pizza-form input[type="text"],
        .pizza-form input[type="file"] {
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

        .pizza-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e3e6f0;
            padding: 10px 0;
        }

        .pizza-item img {
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
    <h2>Insert Pizza</h2>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "food_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
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
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fetch pizzas
    $sql = "SELECT * FROM Pizza";
    $result = $conn->query($sql);
    ?>

    <form id="pizza-form" enctype="multipart/form-data" class="pizza-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>
        <br><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
        <br><br>

        <input type="button" value="Submit" class="submit-btn" onclick="addPizza()">
    </form>

    <?php
    if ($message) {
        echo "<p class='message'>$message</p>";
    }

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='pizza-item' id='pizza-item-{$row['id']}'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "'>";
            echo "<div>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<p>Price: $" . $row['price'] . "</p>";
            echo "</div>";
            echo "<div class='btn-group'>";
            echo "<button class='btn btn-update' onclick='editPizza(" . $row['id'] . ")'>Update</button>";
            echo "<button class='btn btn-delete' onclick='deletePizza(" . $row['id'] . ")'>Delete</button>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No pizzas available</p>";
    }

    // Close the database connection
    $conn->close();
    ?>

    <script>
        function addPizza() {
            const formData = new FormData(document.getElementById('pizza-form'));

            fetch('add_pizza.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('pizza-form').reset();
                    const newItem = `
                        <div class='pizza-item' id='pizza-item-${data.id}'>
                            <img src='data:image/jpeg;base64,${data.image}'">
                            <div>
                                <h3>${data.name}</h3>
                                <p>Price: $${data.price}</p>
                            </div>
                            <div class='btn-group'>
                                <button class='btn btn-update' onclick='editPizza(${data.id})'>Update</button>
                                <button class='btn btn-delete' onclick='deletePizza(${data.id})'>Delete</button>
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

        function editPizza(id) {
            const item = document.getElementById(`pizza-item-${id}`);
            const name = item.querySelector('h3').innerText;
            const price = item.querySelector('p').innerText.replace('Price: $', '');
            const imageSrc = item.querySelector('img').src;

            document.getElementById('name').value = name;
            document.getElementById('price').value = price;
          
            document.getElementById('image').value = '';

            document.querySelector('.submit-btn').value = 'Update';
            document.querySelector('.submit-btn').onclick = function() {
                updatePizza(id);
            };
        }

        function updatePizza(id) {
            const formData = new FormData(document.getElementById('pizza-form'));
            formData.append('id', id);

            fetch('update_pizza.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById(`pizza-item-${id}`).querySelector('h3').innerText = data.name;
                    document.getElementById(`pizza-item-${id}`).querySelector('p').innerText = `Price: $${data.price}`;
                    document.querySelector('.submit-btn').value = 'Submit';
                    document.querySelector('.submit-btn').onclick = function() {
                        addPizza();
                    };
                    document.getElementById('pizza-form').reset();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function deletePizza(id) {
            if (confirm('Are you sure you want to delete this pizza?')) {
                fetch(`delete_pizza.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById(`pizza-item-${id}`).remove();
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
