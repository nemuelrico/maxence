<?php
// Include database connection
include 'db.php'; // This now uses PDO for the connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sale_price = $_POST['sale_price'] ?? NULL; // Handle sale price if provided, or leave as NULL

    // Insert query including the sale price
    $sql = "INSERT INTO products (name, image, sizes, colors, price, sale_price) 
            VALUES (:name, :image, :sizes, :colors, :price, :sale_price)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $imageName);
    $stmt->bindParam(':sizes', $sizes);
    $stmt->bindParam(':colors', $colors);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':sale_price', $sale_price);
    $stmt->execute();

    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $sizes = json_encode($_POST['sizes']);  // Converting sizes array into JSON format
    $colors = json_encode($_POST['colors']);  // Converting colors array into JSON format

    // Handle file upload
    $targetDir = "../uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageName;
    
    // Move the uploaded image to the target directory
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

    // Insert into database using PDO
    $sql = "INSERT INTO products (name, image, sizes, colors, price) 
            VALUES (:name, :image, :sizes, :colors, :price)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $imageName);
    $stmt->bindParam(':sizes', $sizes);
    $stmt->bindParam(':colors', $colors);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <link rel="stylesheet" href="../your-styles.css"> <!-- update this path -->
    <style>
        .container { padding: 20px; max-width: 800px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; }
        .form-group input[type="text"], 
        .form-group input[type="number"], 
        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
        }
        .upload-section, .uploaded-products-section {
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Upload Form -->
        <div class="upload-section">
            <h2>Upload Product:</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Price:</label>
                    <input type="number" name="price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Sizes (comma separated):</label>
                    <input type="text" name="sizes[]" placeholder="e.g. S,M,L" required>
                </div>

                <div class="form-group">
                    <label>Colors (comma separated):</label>
                    <input type="text" name="colors[]" placeholder="e.g. Red,Black" required>
                </div>

                <div class="form-group">
                    <label>Product Image:</label>
                    <input type="file" name="image" required>
                </div>
                <div class="form-group">
                    <label>Sale Price (optional):</label>
                    <input type="number" name="sale_price" step="0.01">
                </div>

                <!-- Upload Form -->
                <form method="POST" enctype="multipart/form-data">
                    <!-- ...upload inputs here... -->
                    <button type="submit">Upload Product</button>
                </form> <!-- END OF THIS FORM -->

                <!-- Done Button to Return to Dashboard -->
                <div style="text-align: center; margin-top: 30px;">
                    <form action="../index.php" method="get">
                        <button type="submit" style="padding: 10px 20px; font-size: 16px;">Done</button>
                    </form>
                </div>

            </form>
        </div>

        <!-- Uploaded Products Container -->
        <div class="uploaded-products-section">
            <h2>Uploaded Products:</h2>
            
            <?php
            // Fetch products from the database and display them
            $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($products) > 0) {
                echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">';
                foreach ($products as $row) {
                    $imagePath = "../uploads/" . $row['image'];
                    $sizes = implode(', ', json_decode($row['sizes']));
                    $colors = implode(', ', json_decode($row['colors']));
                    $price = number_format($row['price'], 2);
                    $onSale = $row['is_on_sale'];
                    $saleLabel = $onSale ? "<span style='color: red;'>On Sale</span>" : "";

                    echo "
                    <div style='border: 1px solid #ccc; border-radius: 10px; padding: 10px; text-align: center;'>
                        <img src='$imagePath' alt='{$row['name']}' style='max-width: 100%; height: 150px; object-fit: cover; border-radius: 8px;'><br>
                        <strong>{$row['name']}</strong><br>
                        <small>Sizes: $sizes</small><br>
                        <small>Colors: $colors</small><br>
                        <div style='margin-top: 5px;'>
                            ";
                    if ($onSale) {
                        echo "<span style='text-decoration: line-through; color: gray;'>₱{$price}</span> ";
                        echo "<span style='color: red;'>₱" . number_format($row['sale_price'], 2) . "</span>";
                    } else {
                        echo "₱{$price}";
                    }

                    echo "
                        </div>
                        <div style='margin-top: 10px; display: flex; flex-direction: column; gap: 5px;'>

                            <form action='mark_sale.php' method='POST'>
                                <input type='hidden' name='product_id' value='<?={$row['id']} ?>'>
                                <label>Sale Price:</label>
                                <input type='number' name='sale_price' step='0.01' required>
                                <button type='submit'>Mark as Sale</button>
                            </form>

                            
                            <form action='mark_soldout.php' method='POST'>
                                <input type='hidden' name='product_id' value='{$row['id']}'>
                                <button type='submit'>" . ($row['is_sold_out'] ? "Mark as Available" : "Mark as Sold Out") . "</button>
                            </form>

                            <form action='edit_product.php' method='GET'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit'>Edit</button>
                            </form>

                            <form action='delete_product.php' method='GET'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit'>Delete</button>
                            </form>

                        </div>
                    </div>";
                }
                echo '</div>';
            } else {
                echo "<p>No products uploaded yet.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
