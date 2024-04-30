<?php
include 'connection.php';

$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($email === "admin@gmail.com" && $password === "123") {
        session_start();
        $_SESSION['email'] = $email;
        header("Location: ./admin/admin.html");
    } else {
        $emailErr = "Invalid email or password";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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

        p.error-message {
            color: red;
            margin-top: 10px;
        }

        a.back-to-home {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }

        a.back-to-home:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="">
            <label for="email">Email:(admin@gmail.com)</label>
            <input type="email" id="email" name="email" required>
            <span class="error-message"><?php echo $emailErr; ?></span>
            <br>
            <label for="password">Password:(123)</label>
            <input type="password" id="password" name="password" required>
            <span class="error-message"><?php echo $passwordErr; ?></span>
            <br>
            <button type="submit">Login</button>
        </form>
        <a href="index.php" class="back-to-home">Back to Home</a>
    </div>
</body>
</html>
