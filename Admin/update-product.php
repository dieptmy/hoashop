<?php
require_once dirname( __FILE__ ) . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['product_id'];
    $name = $_POST['product_name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $category = (int)$_POST['category_id'];
    $volumePrices = $_POST['volume_price'] ?? [];

    // Xử lý ảnh nếu có ảnh mới
    $imageUrf = null;
    if (!empty($_FILES['product_images']['tmp_name'][0])) {
        $uploadDir = __DIR__ . '/../app/images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpName = $_FILES['product_images']['tmp_name'][0];
        $originalName = basename($_FILES['product_images']['name'][0]);
        $newFileName = time() . '_' . $originalName;
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $imageUrf = 'app/images/' . $newFileName;
        } else {
            echo "❌ Không thể lưu ảnh mới.";
            exit;
        }
    }

    // Cập nhật bảng products
    if ($imageUrf) {
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, status = ?, category_id = ?, image_urf = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $description, $status, $category, $imageUrf, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, status = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $description, $status, $category, $id);
    }

    $stmt->execute();
    $stmt->close();

    // Cập nhật bảng volume_product
    foreach ($volumePrices as $volumeId => $price) {

        if (empty($price)) continue;
        $price = (int)$price;
        // Kiểm tra xem đã tồn tại dòng này chưa
            $check = $conn->prepare("SELECT id FROM volume_product WHERE product_id = ? AND volume_id = ?");
            $check->bind_param("ii", $id, $volumeId);
            $check->execute();
            $checkResult = $check->get_result();

        if ($checkResult->num_rows > 0) {
            // Update
            $stmt = $conn->prepare("UPDATE volume_product SET price = ? WHERE product_id = ? AND volume_id = ?");
            $stmt->bind_param("iii", $price, $id, $volumeId);
        } else {
            // Insert mới
            $qty = 20;
            $stmt = $conn->prepare("INSERT INTO volume_product (product_id, volume_id, available_qty, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $id, $volumeId, $qty, $price);
        }
        $stmt->execute();
        $stmt->close();
        $check->close();
    }

    // ✅ Chuyển hướng kèm thông báo cập nhật thành công
    header("Location: product-management.php?success=2");
    exit;
}
?>
