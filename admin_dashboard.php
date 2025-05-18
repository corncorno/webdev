<?php
include("connectdb.php");
session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Handle CRUD for Users
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        $sql = "INSERT INTO users (username, password, role) VALUES ('{$_POST['username']}', '{$_POST['password']}', '{$_POST['role']}')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        $sql = "UPDATE users SET username = '{$_POST['username']}', role = '{$_POST['role']}' WHERE id = {$_POST['id']}";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $sql = "DELETE FROM users WHERE id = {$_POST['id']}";
        $conn->query($sql);
    }
}

// Handle CRUD for Products
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_product'])) {
        $target_file = handleImageUpload($_FILES['image']);
        if ($target_file) {
            $sql = "INSERT INTO products (name, price, description, quantity, image) 
                    VALUES ('{$_POST['name']}', '{$_POST['price']}', '{$_POST['description']}', '{$_POST['quantity']}', '$target_file')";
            $conn->query($sql);
        }
    } elseif (isset($_POST['update_product'])) {
        $sql = "UPDATE products SET name = '{$_POST['name']}', price = '{$_POST['price']}', 
                description = '{$_POST['description']}', quantity = '{$_POST['quantity']}' WHERE id = {$_POST['id']}";
        $conn->query($sql);
    } elseif (isset($_POST['delete_product'])) {
        $sql = "DELETE FROM products WHERE id = {$_POST['id']}";
        $conn->query($sql);
    }
}

// Function to handle image upload
function handleImageUpload($image) {
    if ($image['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types) && move_uploaded_file($image['tmp_name'], $target_file)) {
            return $target_file;
        }
    }
    return false;
}

// Fetch all users and products
$users = $conn->query("SELECT id, username, role FROM users");
$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Boost in Class</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function confirmAction(action) {
            return confirm(`Do you really want to ${action}?`);
        }
    </script>
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <span class="closebtn" onclick="closeNav()">&times;</span>
        <a href="#manage-users">Manage Users</a>
        <a href="#add-product">Add Product</a>
        <a href="#manage-products">Manage Products</a>
        <a href="?logout=true">Logout</a>
    </div>
    <header>
        <span class="menu-btn" onclick="openNav()">&#9776; Menu</span>
        <h1>Admin Dashboard</h1>
        <p>Manage users, products, and more with ease</p>
    </header>
    <main>
        <!-- Manage Users -->
        <section id="manage-users" class="admin-section">
            <h2>Manage Users</h2>
            <form method="POST" class="admin-form">
                <h3>Create User</h3>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role">
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="create" class="btn">Create</button>
            </form>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <form method="POST" class="inline-form" onsubmit="return confirmAction('update this user');">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
                                <select name="role">
                                    <option value="customer" <?php echo $row['role'] == 'customer' ? 'selected' : ''; ?>>Customer</option>
                                    <option value="admin" <?php echo $row['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                                <button type="submit" name="update" class="btn">Update</button>
                            </form>
                            <form method="POST" class="inline-form" onsubmit="return confirmAction('delete this user');">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Manage Products -->
        <section id="manage-products" class="admin-section">
            <h2>Manage Products</h2>
            <form method="POST" enctype="multipart/form-data" class="admin-form">
                <h3>Add Product</h3>
                <input type="text" name="name" placeholder="Product Name" required>
                <input type="number" name="price" step="0.01" placeholder="Price" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="number" name="quantity" placeholder="Quantity" required>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit" name="add_product" class="btn">Add Product</button>
            </form>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td>₱<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width: 50px; height: auto;"></td>
                        <td>
                            <form method="POST" class="inline-form" onsubmit="return confirmAction('update this product');">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
                                <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
                                <textarea name="description" required><?php echo $product['description']; ?></textarea>
                                <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>
                                <button type="submit" name="update_product" class="btn">Update</button>
                            </form>
                            <form method="POST" class="inline-form" onsubmit="return confirmAction('delete this product');">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Boost in Class. All rights reserved.</p>
    </footer>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
</body>
</html>
