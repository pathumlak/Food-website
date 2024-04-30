<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food mania</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>


    <header class="header">
        <a href="" class="logo"><i class="fa fa-shopping-basket" aria-hidden="true"></i>Food-mania</a>
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#categories">Categories</a>
            <a href="#review">Review</a>
            <a href="#contact">Contact us</a>

        </nav>
        <div class="icons">
            <div class="fas fa-bars" id="menu-btn"></div>
            <div class="fas fa-search" id="search-btn"></div>

            <div class="fas fa-user" id="user-btn" onclick="toggleUserBox()"></div>

            <div id="user-box">
            <!-- Add your logout button here -->
            <a href="index.php"><button onclick="logout()">Logout</button></a>
       
            
        </div>
        

            




        </div>
        <style>
  /* Styles for the user button */
  .fas.fa-user {
    /* Add your desired styles for the user button */
    /* For demonstration, I'll just set the color and cursor */
    color: #333;
    cursor: pointer;
  }

  /* Styles for the user box */
  #user-box {
    /* Add your desired styles for the user box */
    /* For demonstration, I'll set background color, padding, and border */
    background-color: #f9f9f9;
    
    border: 1px solid #ccc;
    position: absolute;
    top: 10rem; /* Adjust as needed */
    right: 3rem; /* Adjust as needed */
    z-index: 1; /* Ensure the box appears above other content */
  }

  /* Styles for the login and register buttons */
  #user-box button {
    /* Add your desired styles for the buttons */
    /* For demonstration, I'll set background color, padding, and margin */
    background-color: #007bff;
    color: #fff;
    padding: 5px 10px;
    margin: 5px;
    border: none;
    cursor: pointer;
  }

  /* Style for the buttons when hovered */
  #user-box button:hover {
    background-color: #0056b3;
  }
</style>


       
    

    <form method="GET" class="searchForm">
    <input type="search" id="searchInput" name="query" placeholder="Search Here...">
    <input type="submit" value="Search">
    
</form>



        
    </header>
    <!-- Home section -->
    <script>
    // Function to shuffle the items
    function shuffleItems() {
        var container = document.getElementById("item-container");
        var items = container.getElementsByClassName("items");
        var randomIndex, temp;

        for (var i = items.length - 1; i > 0; i--) {
            randomIndex = Math.floor(Math.random() * (i + 1));
            temp = items[i].innerHTML;
            items[i].innerHTML = items[randomIndex].innerHTML;
            items[randomIndex].innerHTML = temp;
        }
    }

    // Shuffle items every 2 seconds
    setInterval(shuffleItems, 2000);
</script>



    <section class="home" id="home">

    <div class="container" id="item-container">
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

        // Check if a search query is provided
        if(isset($_GET['query']) && !empty($_GET['query'])) {
            $searchQuery = $_GET['query'];
            
            // Retrieve food data based on the search query
            $sql = "SELECT * FROM Food WHERE name LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";
            $result = $conn->query($sql);

            // Check if there are any records
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $name = $row["name"];
                    $description = $row["description"];
                    $image = base64_encode($row["image"]); // Convert BLOB data to base64 for displaying images

                    // Display food details in a div box
                    echo "<div class='items'>";
                    echo "<h3>$name</h3>";
                    echo "<p>$description</p>";
                    echo "<img src='data:image/jpeg;base64,$image' style='max-width: 200px;'>";
                    echo "</div>";
                }
            } else {
                echo "No food items found";
            }
        } else {
            // If no search query is provided, retrieve all food data from the database
            $sql = "SELECT * FROM Food";
            $result = $conn->query($sql);

            // Check if there are any records
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $name = $row["name"];
                    $description = $row["description"];
                    $image = base64_encode($row["image"]); // Convert BLOB data to base64 for displaying images

                    // Display food details in a div box
                    echo "<div class='items'>";
                    echo "<h3>$name</h3>";
                    echo "<p>$description</p>";
                    echo "<img src='data:image/jpeg;base64,$image' style='max-width: 200px;'>";
                    echo "</div>";
                }
            } else {
                echo "No food items found";
            }
        }

        $conn->close();
        ?>
    </div>
    <style>
        
       .home .container {
    padding-top: 5rem;
    border: 3px solid tomato;
    margin-right: 3rem;
    margin-left: 3rem;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

.home .items {
    width: 200px; /* Changed width to 300px */
    height: 200px; /* Changed height to 300px */
    position: relative;
    background-color: white;
    margin: 1rem;
    border: 2px solid #ccc; /* Added border */
    padding: 1rem; /* Added padding for better appearance */
}

.home .items h3 {
    text-align: center;
    font-size: 2rem;
    margin: 0;
}

.home .items p {
    text-align: center;
    font-size: 1.5rem;
    margin: 0;
}

.home .items img {
    width: 100%; /* Make images responsive to container width */
    height: auto; /* Maintain aspect ratio */
    display: block;
    margin: auto;
}


    </style>
</section>

<style>
    .categories {
        text-align: center; /* Center the content */
    }
    .cat-container {
        display: inline-block;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        padding-left: 2rem;
        margin: 20px; /* Add margin for space between containers */
    }
    .categories h2 {
        text-align: center;
        margin-top: 2rem;
        font-size: 2.5rem;
    }
    .cat-box {
        width: 250px;
        height: 250px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
    }
    .cat-box img {
        width: 150px;
        height: 100px;
        margin-bottom: 20px;
    }
    .read-more {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin-top: 20px;
        border-radius: 5px;
    }
    
</style>
<script>


</script>


<section class="categories" id="categories">
    <h2>Categories</h2>
    <div class="cat-container">
        <div class="cat-box">
            <img src="./src/assets/p2.jpg" alt="Pizza">
            <h3>Pizza</h3>
            <p>Description about pizza goes here.</p>
            <a href="./src/php/view_pizza.php" class="read-more"  >Read More</a>
        </div>
    </div>
    <div class="cat-container">
        <div class="cat-box">
            <img src="./src/assets/fast.jpg" alt="Fast Food">
            <h3>Fast Food</h3>
            <p>Description about fast food goes here.</p>
            <a href="./src/php/view_fastfood.php" class="read-more" >Read More</a>
        </div>
    </div>
    <div class="cat-container">
        <div class="cat-box">
            <img src="./src/assets/bev.jpg" alt="Beverages">
            <h3>Beverages</h3>
            <p>Description about beverages goes here.</p>
            <a href="./src/php/view_bev.php" class="read-more" >Read More</a>
        </div>
    </div>
    <div class="cat-container">
        <div class="cat-box">
            <img src="./src/assets/chinese.jpeg" alt="Chinese Food">
            <h3>Chinese Food</h3>
            <p>Description about Chinese food goes here.</p>
            <a href="./src/php/view_chinese.php" class="read-more" >Read More</a>
        </div>
    </div>
</section>
<style>
    .review-section {
        text-align: center;
        margin-top: 50px;
    }
    .review-section h2{
        color: green;
        font-size: 2.5rem;
        padding: 1rem;
    }
    .review-container {
        display: inline-block; /* Change display to inline-block */
        margin-bottom: 20px;
    }
    .review-box {
        border: 2px solid black;
        width: 400px;
        padding: 20px;
        background-color: #f0f0f0;
        border-radius: 10px;
        text-align: left; /* Align text to left within the box */
        margin: 0 auto; /* Center the review box */
    }
    .review-box p{
        text-align: center;
    }
    .user-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 20px;
        display: block;
        margin: 0 auto; /* Center the image */
    }
    .user-review {
        margin-bottom: 20px;
    }
    .navigation {
        text-align: center;
        margin-top: 20px;
    }
    .arrow-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 20px;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 10px; /* Add margin between the buttons */
    }
</style>


<section class="review-section" id="review">
    <h2>Customer Reviews</h2>
    <div class="review-container">
        <div class="review-box">
            <img src="./src/assets/user1.jpeg" alt="User 1" class="user-image">
            <p class="user-review">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sit amet urna vitae felis vehicula lacinia."</p>
            <p>- John Doe</p>
        </div>
    </div>
    <div class="review-container">
        <div class="review-box">
            <img src="./src/assets/ser2.jpeg" alt="User 2" class="user-image">
            <p class="user-review">"Sed consequat velit nec purus eleifend, ac volutpat justo vehicula. Donec et ante nec nisi scelerisque suscipit."</p>
            <p>- Jane Smith</p>
        </div>
    </div>
    <div class="navigation">
        <button class="arrow-btn" id="prevBtn" onclick="prevReview()">&#10094;</button>
        <button class="arrow-btn" id="nextBtn" onclick="nextReview()">&#10095;</button>
    </div>
</section>

<script>
    let currentReviewIndex = 0;
    const reviews = document.querySelectorAll('.review-container');

    function showReview(index) {
        reviews.forEach(review => {
            review.style.display = 'none';
        });
        reviews[index].style.display = 'block';
    }

    function nextReview() {
        currentReviewIndex++;
        if (currentReviewIndex >= reviews.length) {
            currentReviewIndex = 0;
        }
        showReview(currentReviewIndex);
    }

    function prevReview() {
        currentReviewIndex--;
        if (currentReviewIndex < 0) {
            currentReviewIndex = reviews.length - 1;
        }
        showReview(currentReviewIndex);
    }

    // Show the initial review
    showReview(currentReviewIndex);
</script>
<style>
  .notification {
    position: fixed; /* Position fixed to keep it at the top of the viewport */
    top: -1rem; /* Align to the top */
    left: 50%; /* Center horizontally */
    transform: translateX(-50%); /* Center horizontally */
    margin-top: 20px; /* Adjusted margin-top */
    padding: 10px;
    border-radius: 5px;
    border: 2px solid #4CAF50; /* Added border */
    background-color: #f0f0f0; /* Background color */
    color: #4CAF50; /* Text color */
    text-align: center; /* Center align text */
    z-index: 9999; /* Ensure it appears above other content */
}


    .contact-section {
        text-align: center;
        margin-top: 50px;
    }
    .contact-form {
        max-width: 600px;
        margin: 0 auto;
    }
    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-group textarea {
        height: 150px;
    }
    .form-group button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
</head>
<body>

<section class="contact-section" id="contact">
    <h2>Contact Us</h2>
    <div class="contact-form">
        <form action="./src/php/submit_contact.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const contactForm = document.querySelector("#contact form");

        contactForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission

            // Send form data using fetch API
            fetch(contactForm.action, {
                method: "POST",
                body: new FormData(contactForm),
            })
            .then(response => response.json())
            .then(data => {
                // Display notification message
                const notification = document.createElement("div");
                notification.classList.add("notification");
                if (data.success) {
                    notification.classList.add("success");
                } else {
                    notification.classList.add("error");
                }
                notification.textContent = data.message;
                contactForm.parentNode.insertBefore(notification, contactForm.nextSibling);
                
                // Reset form fields
                contactForm.reset();

                // Remove notification after 2 seconds
                setTimeout(function() {
                    notification.remove();
                }, 2000);
            })
            .catch(error => console.error("Error:", error));
        });
    });
</script>
<style>
    .footer {
        background-color: #333;
        color: #fff;
        padding: 20px 0;
        text-align: center;
    }
    .footer p {
        margin-bottom: 10px;
    }
    .footer a {
        color: #fff;
        text-decoration: none;
    }
</style>
</head>
<body>

<footer class="footer">
    <div class="containers">
        <p>123 Street Name, City, Country</p>
        <p>Phone: +1234567890</p>
        <p>&copy; 2024 Your Company Name. All rights reserved.</p>
    </div>
</footer>
    






    <script src="script.js"></script>
</body>
</html>