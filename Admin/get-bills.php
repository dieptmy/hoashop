<?php
require_once dirname( __FILE__ ) . '/../config/db.php';

// Truy vấn đơn hàng kèm tổng số sản phẩm
$sql = "
    SELECT 
        o.id AS order_id,
        o.created_at,
        o.status,
        o.address,
        o.payment_method,
        o.total_price,
        o.total_qty,
        u.fullname AS customer_name,
        u.number AS customer_phone
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
