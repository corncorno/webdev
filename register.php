<?php
include("connectdb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'customer'; // Always register as customer

    // Check if username already exists
    $check_sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $error = "Username already exists. Please choose another.";
    } else {
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql);
        $stmt_insert->bind_param("sss", $username, $password, $role);
        if ($stmt_insert->execute()) {
            $success = "Registration successful!";
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt_insert->close();
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Boost in Class</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <form method="POST">
            <h2>Boost in Class</h2>
            <?php if (isset($success)): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php elseif (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="button-group">
                <button type="submit" class="btn">Register</button>
            </div>
            <div class="register-dialog">
                <p>Already have an account?</p>
                <a href="login.php" class="btn">Login</a>
            </div>
        </form>
    </div>
</body>
</html>