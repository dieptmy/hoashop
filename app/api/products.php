<?php

require_once dirname( __FILE__ ) . '/../../config/db.php';
header('Content-Type: application/json');

$categoryId = $_GET['category_id'] ?? null;
$keyword = $_GET['keyword'] ?? null;
$minPrice = $_GET['minPrice'] ?? null;
$maxPrice = $_GET['maxPrice'] ?? null;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 12;
$offset = ($page - 1) * $limit;


$params = [];
$types = "";
    
$sqlCount = "SELECT count(*) FROM products p
    WHERE status = 'active'";

$sql = "SELECT p.*, MIN(vp.price) as minPrice, MAX(vp.price) as maxPrice,
    CONCAT('[', GROUP_CONCAT(
        CONCAT(
            '{\"volume_id\":', v.id,
            ',\"volume_name\":\"', REPLACE(v.value, '\"', '\\\"'),
            '\",\"price\":', vp.price,
            '}'
        ) ORDER BY v.id
    ), ']') AS volumes
    FROM products p
    INNER JOIN volume_product vp ON p.id = vp.product_id
    INNER JOIN volume v ON vp.volume_id = v.id
    WHERE status = 'active'";

if(!empty($categoryId)) {
     $sql .= " AND p.category_id = ?";
    $sqlCount .= " AND p.category_id = ?";
    $params[] = $categoryId;
    $types .= "i";
}

if ($keyword !== null) {
    $sql .= " AND p.name LIKE ?";
    $sqlCount .= " AND p.name LIKE ?";
    $params[] = '%' . $keyword . '%';
    $types .= "s";
}

 $sqlCount .= ' AND EXISTS(
        select 1
        from volume_product vp
        where p.id = vp.product_id
    ';

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
$sqlCount .= ')';


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


$sql .= " GROUP BY p.id LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";


$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "error" => $conn->error]);
    exit;
}
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();


$products = [];
while ($row = $result->fetch_assoc()) {
    $row['volumes'] = json_decode($row['volumes']);
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
