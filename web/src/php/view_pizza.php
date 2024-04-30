<!DOCTYPE html>
<html>
<head>
  
    <style>
        button{
            color: red;
            background-color: yellow;
        }
        body{
            background-color: #0ef;
        }
        h2{
            text-align: center;
            font-family: sans-serif;
            font-size: 2rem;
            color: red;
        }
     
        .pizza-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 200px;
            height: 300px;
            float: left;
            text-align: center;
            background-color: whitesmoke;
        }

        #cart {
            position: fixed;
            top: 10px;
            right: 10px;
            
            color: black;
            padding: 5px 10px;
            
            cursor: pointer;
        }

        #cart-items {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
            min-width: 300px;
            z-index: 1;
        }

        .cart-item {
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            font-size: 16px;
        }

        .cart-item span {
            font-weight: bold;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .cart-item .quantity {
            margin-left: 10px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Your favourites Pizza in here..</h2>

<div id="pizza-container">
    <?php
    include 'connection.php';

    $sql_select = "SELECT * FROM Pizza";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="pizza-item">';
            echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" width="150" />';
            echo '<p>'.$row['name'].'</p>';
            echo '<p>Price: $'.$row['price'].'</p>';
            echo '<button onclick="addToCart('.$row['id'].', \''.$row['name'].'\', \'' . base64_encode($row['image']) . '\', '.$row['price'].')">Add to Cart</button>';
            echo '</div>';
        }
    } else {
        echo "No pizza items found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

<div id="cart" onclick="toggleCart()">
    🛒Cart <span id="cart-count">0</span>
    <div id="cart-items"></div>
    <button onclick="clearCart()">Clear Cart</button>
</div>

<script>
    let cart = [];
    let cartCount = 0;

    function addToCart(id, name, image, price) {
        let existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            existingItem.quantity++;
            existingItem.totalPrice = existingItem.quantity * price;
        } else {
            cart.push({ id, name, image, price, quantity: 1, totalPrice: price });
        }

        cartCount++;
        document.getElementById('cart-count').innerText = cartCount;
        saveCart();
        renderCart();
    }

    function decreaseQuantity(id) {
        let index = cart.findIndex(item => item.id === id);

        if (cart[index].quantity > 1) {
            cart[index].quantity--;
            cart[index].totalPrice = cart[index].quantity * cart[index].price;
        } else {
            cart.splice(index, 1);
        }

        cartCount--;
        document.getElementById('cart-count').innerText = cartCount;
        saveCart();
        renderCart();
    }

    function increaseQuantity(id) {
        let index = cart.findIndex(item => item.id === id);

        cart[index].quantity++;
        cart[index].totalPrice = cart[index].quantity * cart[index].price;

        saveCart();
        renderCart();
    }

    function clearCart() {
        cart = [];
        cartCount = 0;
        document.getElementById('cart-count').innerText = cartCount;
        saveCart();
        renderCart();
    }

    function saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function loadCart() {
        let savedCart = localStorage.getItem('cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
            cartCount = cart.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('cart-count').innerText = cartCount;
        }
    }

    function toggleCart() {
        let cartItemsDiv = document.getElementById('cart-items');

        if (cartItemsDiv.style.display === 'none' || cartItemsDiv.style.display === '') {
            loadCart();
            renderCart();
            cartItemsDiv.style.display = 'block';
        } else {
            cartItemsDiv.style.display = 'none';
        }
    }

    function renderCart() {
        let cartItemsDiv = document.getElementById('cart-items');
        cartItemsDiv.innerHTML = '';

        if (cart.length === 0) {
            cartItemsDiv.innerHTML = '<p>No items in cart</p>';
        } else {
            let totalCartPrice = 0;
            cart.forEach(item => {
                totalCartPrice += item.totalPrice;
                cartItemsDiv.innerHTML += `
                    <div class="cart-item">
                        <img src="data:image/jpeg;base64,${item.image}" alt="${item.name}" />
                        <span>Name:</span> ${item.name}<br>
                        <span>Price:</span> $${item.price}<br>
                        <span>Quantity:</span> 
                        <button class="quantity" onclick="decreaseQuantity(${item.id})">-</button>
                        ${item.quantity}
                        <button class="quantity" onclick="increaseQuantity(${item.id})">+</button>
                    </div>`;
            });
            cartItemsDiv.innerHTML += `<p>Total Price: $${totalCartPrice}</p>`;
        }
    }

    window.onload = function() {
        loadCart();
    };
</script>

</body>
</html>
