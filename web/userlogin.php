<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the username and password
    if ($username == "user" && $password == "1010") {
        // Set session variables
        $_SESSION["loggedin"] = true;
        
        // Redirect to main.php
        header("location: main.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .login-container {
            max-width: 300px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            text-align: center;
            color: #333333;
        }
        .login-container label, .login-container input {
            width: 100%;
            margin-bottom: 10px;
        }
        .login-container input[type="submit"] {
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
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="post">
            <div>
                <label for="username">Username:(user)</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label for="password">Password:(1010)</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>

        <?php if (isset($error)) { echo '<div class="error">' . $error . '</div>'; } ?>
    </div>
</body>
</html>
