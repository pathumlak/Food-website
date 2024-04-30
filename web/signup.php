<?php
    include 'connection.php';

    $nameErr = $emailErr = $phoneErr = $passwordErr = $confirmPasswordErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm_password"];
        
        if (empty($name)) {
            $nameErr = "Name is required";
        }

        if (empty($email)) {
            $emailErr = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }

        if (empty($phone)) {
            $phoneErr = "Phone number is required";
        } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
            $phoneErr = "Invalid phone number format";
        }

        if (empty($password)) {
            $passwordErr = "Password is required";
        }

        if ($password != $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
        }

        if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
            $sql = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
            $redirect = "main.php";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                header("Location: $redirect");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        h2 {
            color: #333333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #666666;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #cccccc;
        }

        button {
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        p#message {
            margin-top: 20px;
            color: green;
            font-weight: bold;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(event) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm_password').value;

                if (password !== confirmPassword) {
                    event.preventDefault();
                    const errorMessage = document.createElement('p');
                    errorMessage.className = 'error-message';
                    errorMessage.textContent = 'Passwords do not match';
                    form.appendChild(errorMessage);
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <span class="error-message"><?php echo $nameErr; ?></span>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <span class="error-message"><?php echo $emailErr; ?></span>
            <br>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>
            <span class="error-message"><?php echo $phoneErr; ?></span>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span class="error-message"><?php echo $passwordErr; ?></span>
            <br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span class="error-message"><?php echo $confirmPasswordErr; ?></span>
            <br>
            <button type="submit">Signup</button>
        </form>
        <p id="message">
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
                    echo "Signup successful!";
                }
            ?>
        </p>
    </div>
</body>
</html>
