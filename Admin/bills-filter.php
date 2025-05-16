<?php
require_once dirname( __FILE__ ) . '/../config/db.php';

$where = [];
$params = [];
$types = "";

// 1. Trạng thái đơn hàng
if (!empty($_GET['status'])) {
    $where[] = "o.status = ?";
    $types .= "s";
    $params[] = $_GET['status'];
}

// 2. Khoảng thời gian (ngày tạo đơn)
if (!empty($_GET['start']) && !empty($_GET['end'])) {
    $where[] = "DATE(o.created_at) BETWEEN ? AND ?";
    $types .= "ss";
    $params[] = $_GET['start'];
    $params[] = $_GET['end'];
}

// 3. Địa chỉ giao hàng
if (!empty($_GET['location'])) {
    $where[] = "o.address LIKE ?";
    $types .= "s";
    $params[] = '%' . $_GET['location'] . '%';
}

// Xây dựng truy vấn
$sql = "
    SELECT 
        o.id AS order_id,
        o.created_at,
        o.status,
        o.address,
        o.payment_method,
        o.total_price,
        o.total_qty,
        o.note,
        u.fullname AS customer_name,
        u.number AS customer_phone
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
";

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY o.created_at DESC";

// Thực thi
$stmt = $conn->prepare($sql);

if ($types !== "") {
    // Tránh lỗi unpacking: gọi bind_param bằng array
    $stmt->bind_param($types, ...array_values($params));
}

$stmt->execute();
$result = $stmt->get_result();

$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

header('Content-Type: application/json');
echo json_encode($rows);
