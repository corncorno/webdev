<?php
include("connectdb.php");
session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy(); 
    header("Location: login.php"); 
    exit();
}

// Handle Add to Cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1;
    } else {
        $_SESSION['cart'][$product_id]++;
    }

    echo "<script>alert('Product added to cart!');</script>";
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$product_ids = array_keys($cart_items);

$cart_products = [];
if (!empty($product_ids)) {
    $ids = implode(',', $product_ids);
    $cart_sql = "SELECT * FROM products WHERE id IN ($ids)";
    $cart_result = $conn->query($cart_sql);
    while ($row = $cart_result->fetch_assoc()) {
        $cart_products[] = $row;
    }
}

// Fetch the username of the logged-in user
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boost in Class</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <span class="closebtn" onclick="closeNav()">&times;</span>
        <a href="#products">Shop Now!</a>
        <a href="#about">About</a> <!-- Updated link to scroll to About section -->
        <a href="#contact">Contact</a> <!-- Updated link to scroll to Contact section -->
        <a href="cart.php">Cart</a>
        <a href="?logout=true">Logout</a>
    </div>
    <header>
        <span class="menu-btn" onclick="openNav()">&#9776; Menu</span>
        <h1>Boost in Class</h1>
        <p>Your one-stop shop for premium liquor products</p> <!-- Added tagline -->
    </header>
    <div class="cart-dropdown">
        <a href="cart.php" class="cart-icon">
            <img src="images/cart.png" alt="View Cart">
        </a>
        <div class="cart-dropdown-content">
            <?php if (!empty($cart_products)): ?>
                <?php foreach ($cart_products as $product): ?>
                    <p>
                        <span><?php echo $product['name']; ?></span> - 
                        ₱<?php echo number_format($product['price'], 2); ?> x 
                        <?php echo $cart_items[$product['id']]; ?>
                    </p>
                <?php endforeach; ?>
                <p><a href="cart.php" style="color: #007BFF; text-decoration: underline;">Go to Cart</a></p>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
    <main>
        <section class="products" section id = "products">
            
            <h2>Our Products</h2>
            <div class="product-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="width:100%; height:auto;">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>₱<?php echo number_format($row['price'], 2); ?></p>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
    <section id="about" style="padding: 40px 20px; background-color: #f4f4f4; text-align: center;">
        <h2>About Us</h2>
        <p>Boost In Class
       
        Established in 2025, Boost In Class is your go-to destination for premium liquors, offering a carefully curated selection of spirits, wines, and beers to elevate any occasion. We take pride in providing top-quality products, excellent customer service, and a refined shopping experience. Whether you're celebrating a special moment or simply enjoying a drink, we’re here to bring you the best—always with class.</p>
    
        <h2>Mission</h2>
        <p>Mission
        To provide a diverse selection of high-quality liquors at competitive prices, ensuring a convenient and enjoyable shopping experience for all customers while promoting responsible drinking.</p>
    
        <h2>Vision</h2>
        <p>To be the go-to liquor store in the community, recognized for our excellent service, curated selection, and commitment to customer satisfaction.

</p>
    
    </section>

    <section id="contact" style="padding: 40px 20px; background-color: #fff; text-align: center;">
        <h2>Contact Us</h2>
        <p>If you have any questions or feedback, feel free to reach out to us:</p>
        <p>Email: support@boostinclass.com</p>
        <p>Phone: +639122998086</p>
        <p>Address: Laklak St. Cainta, Rizal</p>
    </section>
    <footer>
        <p>&copy; 2025 Boost in Class. All rights reserved.</p>
    </footer>
    <div class="text-cloud">
        Welcome to Boost in Class, <?php echo htmlspecialchars($username); ?>! Explore our premium products and enjoy your shopping experience.
    </div>
</body>
</html>