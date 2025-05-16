<?php
header('Content-Type: application/json');
require_once 'connect.php';

// Nhận tham số từ URL (nếu có)
$category = $_GET['category'] ?? null;
$brand = $_GET['brand'] ?? null;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 12;
$offset = ($page - 1) * $limit;

// Base SQL
$sql = "SELECT 
            p.*, 
            vp.price, 
            v.value as volume,
            b.name as brand,
            c.name as category
        FROM products p
        LEFT JOIN volume_product vp ON p.id = vp.product_id
        LEFT JOIN volume v ON vp.volume_id = v.id
        LEFT JOIN brand b ON p.brand_id = b.id
        LEFT JOIN category c ON p.category_id = c.id
        WHERE v.value = 100";

// Điều kiện lọc
$params = [];
$types = "";

if ($category !== null) {
    $sql .= " AND c.name = ?";
    $params[] = $category;
    $types .= "s";
}

if ($brand !== null) {
    $sql .= " AND b.name = ?";
    $params[] = $brand;
    $types .= "s";
}

// Thêm phân trang
$sql .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";

// Chuẩn bị và thực thi
$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Trả kết quả
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $products,
    "pagination" => [
        "page" => $page,
        "limit" => $limit,
        "count" => count($products)
    ]
]);

$conn->close();
?>
