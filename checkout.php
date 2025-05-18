<?php
include("connectdb.php");
session_start();

if (empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty.'); window.location.href = 'cart.php';</script>";
    exit();
}

$product_ids = implode(',', array_keys($_SESSION['cart']));
$products = $conn->query("SELECT * FROM products WHERE id IN ($product_ids)")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_checkout'])) {
    unset($_SESSION['cart']);
    echo "<script>alert('Checkout successful! Thank you for your order.'); window.location.href = 'index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Checkout</h1>
    </header>
    <main class="checkout">
        <h2>Order Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $grand_total = 0; ?>
                <?php foreach ($products as $product): ?>
                <?php 
                    $quantity = $_SESSION['cart'][$product['id']];
                    $total = $product['price'] * $quantity;
                    $grand_total += $total;
                ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td>₱<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>₱<?php echo number_format($total, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Grand Total</td>
                    <td>₱<?php echo number_format($grand_total, 2); ?></td>
                </tr>
            </tfoot>
        </table>
        <form method="POST">
            <p>Are you sure you want to confirm this order?</p>
            <button type="submit" name="confirm_checkout" class="btn">Yes, Confirm Checkout</button>
            <button type="button" onclick="window.location.href='cart.php';" class="btn">No, Go Back to Cart</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Boost in Class. All rights reserved.</p>
    </footer>
</body>
</html>
