<?php
session_start();
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Registration failed";
    }
}
?>

<?php include '../includes/header.php'; ?>
<h2>Register</h2>
<form method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Register</button>
</form>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
<?php include '../includes/footer.php'; ?>
