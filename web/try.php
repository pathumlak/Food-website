<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User & Admin Selection</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        width: 300px;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    select {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        transition: border-color 0.3s;
    }

    select:focus {
        border-color: #007bff;
        outline: none;
    }

    .button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #0056b3;
    }

    /* Dropdown Animation */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="6"><polygon points="0,0 12,0 6,6" style="fill:#aaa;"/></svg>');
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: 50%;
    }

    select:hover {
        border-color: #007bff;
    }

    select:focus {
        border-color: #007bff;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="6"><polygon points="0,0 12,0 6,6" style="fill:#007bff;"/></svg>');
    }
</style>
</head>
<body>

<div class="container">
    <h2>Select Role</h2>
    <select id="roleSelect">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <button class="button" onclick="submitRole()">Submit</button>
</div>

<script>
    function submitRole() {
        const selectedRole = document.getElementById('roleSelect').value;
        if (selectedRole === 'admin') {
            window.location.href = 'admin_login.php';
        } else {
            window.location.href = 'userlogin.php';
        }
    }
</script>

</body>
</html>
