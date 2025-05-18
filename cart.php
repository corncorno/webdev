<?php
include("connectdb.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_all'])) {
    unset($_SESSION['cart']);
    echo "<script>alert('All orders have been canceled.'); window.location.href = 'cart.php';</script>";
    exit();
}

$cart_items = $_SESSION['cart'] ?? [];
$product_ids = array_keys($cart_items);
$result = !empty($product_ids) ? $conn->query("SELECT * FROM products WHERE id IN (" . implode(',', $product_ids) . ")") : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Your Cart</h1>
    </header>
    <main class="cart">
        <h2>Cart Items</h2>
        <?php if ($result && $result->num_rows > 0): ?>
        <form method="POST" action="">
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
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <?php 
                        $quantity = $cart_items[$row['id']];
                        $total = $row['price'] * $quantity;
                        $grand_total += $total;
                    ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td>₱<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td>₱<?php echo number_format($total, 2); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Grand Total</td>
                        <td>₱<?php echo number_format($grand_total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
            <div class="button-group">
                <button type="submit" formaction="checkout.php" class="btn checkout">Checkout</button>
                <button type="submit" name="cancel_all" class="btn cancel">Cancel All Orders</button>
                <a href="index.php" class="btn">Back to Shop</a>
            </div>
        </form>
        <?php else: ?>
        <p>Your cart is empty.</p>
        <div class="button-group">
            <a href="index.php" class="btn">Back to Shop</a>
        </div>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2023 Beer Shop. All rights reserved.</p>
    </footer>
</body>
</html>
