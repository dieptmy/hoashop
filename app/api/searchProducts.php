<?php
require_once 'connect.php';
header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);

$where = [];
$params = [];
$types = '';


if (!empty($data['keyword'])) {
    $where[] = "p.name LIKE ?";
    $params[] = '%' . $data['keyword'] . '%';
    $types .= 's';
}


if (!empty($data['category'])) {
    $where[] = "c.name = ?";
    $params[] = $data['category'];
    $types .= 's';
}


if (!empty($data['brand'])) {
    $where[] = "b.name = ?";
    $params[] = $data['brand'];
    $types .= 's';
}


if (!empty($data['minPrice'])) {
    $where[] = "vp.price >= ?";
    $params[] = $data['minPrice'];
    $types .= 'i';
}
if (!empty($data['maxPrice'])) {
    $where[] = "vp.price <= ?";
    $params[] = $data['maxPrice'];
    $types .= 'i';
}

// Nếu không có minPrice và maxPrice thì mặc định v.value = 100
if (empty($data['minPrice']) && empty($data['maxPrice'])) {
    $where[] = "v.value = ?";
    $params[] = 100;
    $types .= 'i';
}

$sql = "SELECT 
            p.id, 
            p.name, 
            b.name AS brand, 
            p.image_urf, 
            vp.price, 
            c.name AS category,
            v.value AS volume
        FROM products p
        JOIN volume_product vp ON p.id = vp.product_id
        JOIN volume v ON vp.volume_id = v.id
        JOIN brand b ON p.brand_id = b.id
        JOIN category c ON p.category_id = c.id
        WHERE " . (count($where) ? implode(' AND ', $where) : '1');


error_log($sql);
error_log(print_r($params, true));


$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();


$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode(['success' => true, 'products' => $products]);
?>
