<?php
$host = 'localhost'; // Change if using another host
$dbname = 'maxence'; // Replace with your actual DB name
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password (empty if local with root)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: UTF-8 encoding
    $conn->exec("SET NAMES 'utf8'");
    // echo "Connected successfully"; // Uncomment to test
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
