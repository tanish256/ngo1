<?php
// register.php

// Database connection
$host = "localhost";
$dbname = "hayatu";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $user_name = trim($_POST["user_name"]);
    $password = trim($_POST["password"]);
    $role = trim($_POST["role"]);

    if (!empty($name) && !empty($user_name) && !empty($password) && !empty($role)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user
        $sql = "INSERT INTO users (name, user_name, password, role) VALUES (:name, :user_name, :password, :role)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':user_name' => $user_name,
            ':password' => $hashed_password,
            ':role' => $role
        ]);

        echo "<p style='color:green;'>User registered successfully!</p>";
    } else {
        echo "<p style='color:red;'>Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>Register User</h2>
    <form method="POST" action="">
        <label>Full Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>User Name:</label><br>
        <input type="text" name="user_name" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
