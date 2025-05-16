<?php
require_once dirname( __FILE__ ) . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $description = $_POST['product_about'];
    $status = $_POST['status'];
    $category = $_POST['category_id'];
    $volumePrices = $_POST['volume_price'] ?? [];

    $imageUrf = null;

    // Xử lý ảnh
    $uploadDir = __DIR__ . '/../app/images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!empty($_FILES['product_images']['tmp_name'][0])) {
        $tmpName = $_FILES['product_images']['tmp_name'][0];
        $originalName = basename($_FILES['product_images']['name'][0]);
        $newFileName = time() . '_' . $originalName;
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $imageUrf = 'images/' . $newFileName;
        } else {
            echo "❌ Không thể lưu ảnh vào $targetPath";
            exit;
        }
    }

    // Thêm sản phẩm vào bảng products
    $stmt = $conn->prepare("INSERT INTO products (name, description, category_id, status, image_urf) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $name, $description, $category, $status, $imageUrf);
    $stmt->execute();
    $productId = $stmt->insert_id;
    $stmt->close();

    // Thêm giá theo volume
    foreach ($volumePrices as $volumeId => $price) {
        if (!empty($price)) {
            $price = (int)$price;
            $availableQty = 20; // mặc định
            $stmt = $conn->prepare("INSERT INTO volume_product (product_id, volume_id, available_qty, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $productId, $volumeId, $availableQty, $price);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: product-management.php?success=1");
    exit;
}
?>
