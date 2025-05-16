<?php
header('Content-Type: application/json');
require_once 'connect.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Lấy thông tin từ request
    $user_id = $data['user_id'];
    $address = $data['address'];
    $payment_method = $data['payment_method'];
    $total_price = $data['total_price'];
    $total_qty = $data['total_qty'];
    $items = $data['items'];
    // $created_at = $data['created_at'];

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Thêm đơn hàng mới
    $stmt = $conn->prepare("INSERT INTO orders (user_id, address, payment_method, total_price, status, total_qty) VALUES (?, ?, ?, ?, 'pending', ?)");
    $stmt->bind_param("issdi", $user_id, $address, $payment_method, $total_price, $total_qty);
    $stmt->execute();
    
    $order_id = $conn->insert_id;

    // Thêm các sản phẩm vào order_items
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, volume_product_id, quantity, price) VALUES (?, ?, ?, ?)");
    
    foreach ($items as $item) {
        $stmt->bind_param("iiid", $order_id, $item['volume_product_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'order_id' => $order_id
    ]);

} catch (Exception $e) {
    // Rollback nếu có lỗi
    if ($conn->inTransaction()) {
        $conn->rollback();
    }
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
