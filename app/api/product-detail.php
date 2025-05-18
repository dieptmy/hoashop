<?php
require_once dirname( __FILE__ ) . '/../../config/db.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Thiếu id']);
    exit;
}

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT p.*, vp.price, p.image_urf, v.value AS volume, c.id AS category
                        FROM products p
                        JOIN volume_product vp ON vp.product_id = p.id
                        JOIN product_category pc ON pc.product_id = p.id
                        JOIN category c ON c. id = pc.category_id
                        JOIN volume v ON v.id = vp.volume_id
                        WHERE vp.id = ?
                        LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
    exit;
}

// Lấy các sản phẩm cùng brand (trừ chính nó)
$stmt2 = $conn->prepare("SELECT p.*, v.value AS volume, vp.price, p.image_urf
                        FROM products p
                        JOIN volume_product vp ON vp.product_id = p.id
                        JOIN product_category pc ON pc.product_id = p.id
                        JOIN category c ON c.id = pc.category_id
                        JOIN volume v ON vp.volume_id = v.id
                        WHERE c.id = ? AND vp.id != ?  AND v.value = 100 
                        LIMIT 4");
$stmt2->bind_param("ii", $product['category'], $id);
$stmt2->execute();
$related = [];
$res2 = $stmt2->get_result();
while ($row = $res2->fetch_assoc()) {
    $related[] = $row;
}

echo json_encode([
    'success' => true,
    'product' => $product,
    'related' => $related
]);
?>
