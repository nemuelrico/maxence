<?php
// Include database connection
 
include 'db.php';

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product data from the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If the product does not exist
    if (!$product) {
        echo "Product not found!";
        exit;
    }
}

// Handle the form submission to update the product
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $sizes = json_encode($_POST['sizes']);
    $colors = json_encode($_POST['colors']);

    // Handle file upload if a new image is provided
    $imageName = $product['image']; // Default to the current image
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $targetDir = "../uploads/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }

    // Update product details in the database
    $sql = "UPDATE products SET name = :name, image = :image, sizes = :sizes, colors = :colors, price = :price WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $imageName);
    $stmt->bindParam(':sizes', $sizes);
    $stmt->bindParam(':colors', $colors);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();

    echo "Product updated successfully!";
    header("Location: product_management.php"); // Redirect to the product management page after update
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="name" value="<?= $product['name'] ?>" required>
        </div>

        <div class="form-group">
            <label>Price:</label>
            <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Sizes (comma separated):</label>
            <input type="text" name="sizes[]" value="<?= implode(', ', json_decode($product['sizes'])) ?>" required>
        </div>

        <div class="form-group">
            <label>Colors (comma separated):</label>
            <input type="text" name="colors[]" value="<?= implode(', ', json_decode($product['colors'])) ?>" required>
        </div>

        <div class="form-group">
            <label>Product Image:</label>
            <input type="file" name="image">
        </div>

        <!-- Update Form -->
        <form method="POST" enctype="multipart/form-data">
            <!-- your existing form inputs here... -->
            <button type="submit">Update Product</button>
        </form>

        <!-- Done Button -->
        <form action="product_management.php" method="get" style="margin-top: 15px;">
            <button type="submit">Done</button>
        </form>

    </form>
</body>
</html>
