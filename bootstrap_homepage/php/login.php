<?php
session_start();
$conn = new mysqli("localhost", "root", "", "maxence");  // Ensure the DB name matches

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Registration
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email already exists
    $check_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already registered. Try logging in!');</script>";
    } else {
        // Hash password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php?register_success=1"); // Redirect after success
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }
    }
}

// Handle Login
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT id, username, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Check if the user is an admin
            if ($row['username'] === "ADMIN" && $row['email'] === "admin@maxence.ph") {
                $_SESSION['role'] = "admin"; // Store role in session
                header("Location: /phpMaxence/admin/admin_home.php"); // Redirect to admin home
            } else {
                $_SESSION['role'] = "user"; // Store regular user role
                header("Location: homepage.php"); // Redirect to user homepage
            }
            exit();
        } else {
            $error = "Invalid email or password. Please try again.";
        }
    } else {
        echo "<script>alert('User not found. Please register first!');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <!-- Display Error Message Here -->
        <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="register">Register</button>
        </form>

        <!-- Back to Homepage Button -->
        <a href="homepage.php" class="back-home-btn">Back to Homepage</a>
    </div>
</body>
</html>
