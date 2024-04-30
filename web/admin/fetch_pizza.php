<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CRUD Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 800px;
        margin: auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

</style>
</head>
<body>

<div class="container">
    <h2>CRUD Dashboard</h2>

    <!-- Form to add new items -->
    <form id="addItemForm">
        <label for="category">Category:</label>
        <select id="category">
            <option value="Pizza">Pizza</option>
            <option value="Fast Food">Fast Food</option>
            <option value="Chinese">Chinese</option>
            <option value="Beverages">Beverages</option>
        </select>
        <label for="itemName">Item Name:</label>
        <input type="text" id="itemName" required>
        <button type="button" onclick="addItem()" class="btn">Add Item</button>
    </form>

    <!-- Table to display items -->
    <table id="itemTable">
        <thead>
            <tr>
                <th>Category</th>
                <th>Item Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Items will be populated here -->
        </tbody>
    </table>
</div>

<script>
    let items = {
        'Pizza': [],
        'Fast Food': [],
        'Chinese': [],
        'Beverages': []
    };

    function addItem() {
        const category = document.getElementById('category').value;
        const itemName = document.getElementById('itemName').value;

        if (itemName && !items[category].includes(itemName)) {
            items[category].push(itemName);
            displayItems();
        }

        document.getElementById('itemName').value = '';
    }

    function deleteItem(category, itemName) {
        const index = items[category].indexOf(itemName);
        if (index > -1) {
            items[category].splice(index, 1);
            displayItems();
        }
    }

    function displayItems() {
        const tableBody = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        for (const [category, itemList] of Object.entries(items)) {
            itemList.forEach(item => {
                const row = `
                    <tr>
                        <td>${category}</td>
                        <td>${item}</td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteItem('${category}', '${item}')">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }
    }

    displayItems();
</script>

</body>
</html>
