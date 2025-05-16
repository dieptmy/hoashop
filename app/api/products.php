<?php

require_once dirname( __FILE__ ) . '/../../config/db.php';
header('Content-Type: application/json');

// Nhận tham số từ URL
$categoryId = $_GET['category_id'] ?? null;
$keyword = $_GET['keyword'] ?? null;
$minPrice = $_GET['minPrice'] ?? null;
$maxPrice = $_GET['maxPrice'] ?? null;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 12;
$offset = ($page - 1) * $limit;

// Base SQL
$sqlCount = "SELECT count(*)
        FROM products p
        LEFT JOIN volume_product vp ON p.id = vp.product_id
        LEFT JOIN volume v ON vp.volume_id = v.id
        LEFT JOIN category c ON p.category_id = c.id
        WHERE v.value = 100";

$sql = "SELECT 
            p.*, 
            vp.price, 
            v.value as volume,
            c.name as category
        FROM products p
        LEFT JOIN volume_product vp ON p.id = vp.product_id
        LEFT JOIN volume v ON vp.volume_id = v.id
        LEFT JOIN category c ON p.category_id = c.id
        WHERE v.value = 100";

// Điều kiện lọc
$params = [];
$types = "";
if ($categoryId !== null) {
    $sql .= " AND c.id = ?";
    $sqlCount .= " AND c.id = ?";
    $params[] = (int)$categoryId;
    $types .= "i";
}

if ($keyword !== null) {
    $sql .= " AND p.name like ?";
    $sqlCount .= " AND p.name like ?";
    $params[] = '%' . $keyword . '%';
    $types .= 's';
}

if ($minPrice !== null) {
    $sql .= " AND vp.price >= ?";
    $sqlCount .= " AND vp.price >= ?";
    $params[] = (int)$minPrice;
    $types .= "i";
}

if ($maxPrice !== null) {
    $sql .= " AND vp.price <= ?";
    $sqlCount .= " AND vp.price <= ?";
    $params[] = (int)$maxPrice;
    $types .= "i";
}

// Lấy tổng số bản ghi
$stmt2 = $conn->prepare($sqlCount);
if (!$stmt2) {
    echo json_encode(["success" => false, "error" => $conn->error]);
    exit;
}
if ($types) {
    $stmt2->bind_param($types, ...$params);
}
$stmt2->execute();
$result2 = $stmt2->get_result();
$totalRow = $result2->fetch_row();
$total = $totalRow ? (int)$totalRow[0] : 0;

// Thêm phân trang
$sql .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";
// Truy vấn dữ liệu sản phẩm
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "error" => $conn->error]);
    exit;
}
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result =  $stmt->get_result();

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
        "count" => count($products),
        "total" => $total
    ]
]);

$conn->close();
?>
