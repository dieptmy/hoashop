<?php
header('Content-Type: application/json');
require_once dirname( __FILE__ ) . '/../../config/db.php';

$order_id = $_GET['order_id'] ?? 0;
if (!$order_id) {
    echo json_encode(['success' => false, 'message' => 'Thiếu mã đơn hàng']);
    exit;
}

// Lấy thông tin đơn hàng
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare order query: ' . $conn->error]);
    exit;
}
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng']);
    exit;
}

// Lấy thông tin user
$stmt = $conn->prepare("SELECT fullname, address, number FROM users WHERE id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare user query: ' . $conn->error]);
    exit;
}
$stmt->bind_param("i", $order['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Lấy sản phẩm trong đơn hàng
$stmt = $conn->prepare("SELECT oi.*, p.name as product_name, p.image_urf, v.value 
    FROM order_items oi
    JOIN volume_product vp ON oi.volume_product_id = vp.id
    JOIN products p ON vp.product_id = p.id
    JOIN volume v ON v.id = vp.volume_id
    WHERE oi.order_id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare items query: ' . $conn->error]);
    exit;
}
$stmt->bind_param("i", $order_id);
$stmt->execute();
$res = $stmt->get_result();
$items = [];
while ($row = $res->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode([
    'success' => true,
    'order' => $order,
    'user' => $user,
    'items' => $items
]);

?>
