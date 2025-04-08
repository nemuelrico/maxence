<?php
include 'db.php'; // Ensure you're including the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $sale_price = $_POST['sale_price']; // Get the sale price from the form

    // Update the product as 'on sale'
    $sql = "UPDATE products SET is_on_sale = 1, sale_price = :sale_price WHERE id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sale_price', $sale_price);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    header('Location: product_management.php'); // Redirect back to the product management page
    exit;
}
?>
