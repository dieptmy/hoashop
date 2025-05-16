<?php
header('Content-Type: application/json');
require_once 'connect.php';

// Thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $brand_id = $_POST['brand_id'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $image_urf = $_POST['image_urf'] ?? '';
    $description = $_POST['description'] ?? '';

    $stmt = $conn->prepare("INSERT INTO products (name, brand_id, category_id, image_urf, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiss", $name, $brand_id, $category_id, $image_urf, $description);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Thêm sản phẩm thành công!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi thêm sản phẩm!']);
    }
    exit;
}

// Xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $product_id = $_POST['product_id'] ?? 0;
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa sản phẩm!']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ!']);
?>
