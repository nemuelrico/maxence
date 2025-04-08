<?php
include 'db.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Optional: Get the image name to delete it from uploads
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete image file if exists
    if ($product && file_exists("../uploads/" . $product['image'])) {
        unlink("../uploads/" . $product['image']);
    }

    // Delete product from database
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();

    // Redirect back to product management
    header("Location: product_management.php");
    exit;
} else {
    echo "Product ID not provided.";
}
?>
