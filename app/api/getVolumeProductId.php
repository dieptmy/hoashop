<?php
require_once dirname( __FILE__ ) . '/../../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $product_id = $data['product_id'] ?? null;
    $volume_id = $data['volume_id'] ?? null;

    if ($product_id && $volume_id) {
        $stmt = $conn->prepare("SELECT id FROM volume_product WHERE product_id = ? AND volume_id = ?");
        $stmt->bind_param("ii", $product_id, $volume_id); 
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            echo json_encode(['success' => true, 'volume_product_id' => $row['id']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm với dung tích này']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm hoặc dung tích']);
    }
}
?>