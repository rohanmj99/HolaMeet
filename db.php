<?php
// Database connection variables
$host = "localhost"; // Change this if your MySQL server is running on a different host
$dbname = "hola_meet_db"; // Your database name
$username = "admin"; // Your database username
$password = "abcd1234"; // Your database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Set character set to UTF-8
    $pdo->exec("SET NAMES utf8");
} catch (PDOException $e) {
    // Display error message
    die("Database connection failed: " . $e->getMessage());
}
?>