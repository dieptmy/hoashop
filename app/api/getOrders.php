<?php
header('Content-Type: application/json');
require_once dirname( __FILE__ ) . '/../../config/db.php';

try {
    $user_id = $_GET['user_id'] ?? 0;
    
    // Lấy danh sách đơn hàng
    $stmt = $conn->prepare("
        SELECT o.*, 
               oi.volume_product_id,
               oi.quantity,
               oi.price,
               p.name as product_name,
               p.image_urf as product_image,
               v.value as volume_name
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN volume_product vp  ON oi.volume_product_id = vp.id
        JOIN products p ON vp.product_id = p.id
        JOIN volume v ON vp.volume_id = v.id
        WHERE o.user_id = ? AND o.status = 'delivered'
        ORDER BY o.created_at DESC
    ");
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    $current_order = null;
    
    while ($row = $result->fetch_assoc()) {
        if (!$current_order || $current_order['id'] != $row['id']) {
            if ($current_order) {
                $orders[] = $current_order;
            }
            $current_order = [
                'id' => $row['id'],
                'created_at' => $row['created_at'],
                'status' => $row['status'],
                'total_price' => $row['total_price'],
                'items' => []
            ];
        }
        
        $current_order['items'][] = [
            'volume_product_id' => $row['volume_product_id'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
            'product_name' => $row['product_name'],
            'product_image' => $row['product_image'],
            'volume_name' => $row['volume_name']
        ];
    }
    
    if ($current_order) {
        $orders[] = $current_order;
    }
    
    echo json_encode([
        'success' => true,
        'orders' => $orders
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
