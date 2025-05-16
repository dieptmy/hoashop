<?php
require_once 'connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'] ?? null;
$volume_product_id = $data['volume_product_id'] ?? null;
$quantity = $data['quantity'] ?? 1;
$action = $data['action'] ?? null;

if ($user_id && $volume_product_id) {
    if ($action === 'delete') {
        // XÓA SẢN PHẨM KHỎI GIỎ HÀNG
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND volume_product_id = ?");
        $stmt->bind_param("ii", $user_id, $volume_product_id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
        exit;
    }


    // Kiểm tra xem đã có sản phẩm này trong giỏ chưa
    $stmt = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND volume_product_id = ?");
    $stmt->bind_param("ii", $user_id, $volume_product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Đã có, thì cập nhật số lượng
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ?  WHERE user_id = ? AND volume_product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $volume_product_id);
        $stmt->execute();
    } else {
        // Chưa có, thì thêm mới
        $stmt = $conn->prepare("INSERT INTO cart (user_id, volume_product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $volume_product_id, $quantity);
        $stmt->execute();
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
}
?>