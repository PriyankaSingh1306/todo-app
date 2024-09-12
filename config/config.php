<?php
$host = 'localhost';
$dbname = 'todo_app';
$user = 'root'; // replace with your database username
$pass = ''; // replace with your database password

try {
    //$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
