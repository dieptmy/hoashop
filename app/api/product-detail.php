<?php
require_once dirname( __FILE__ ) . '/../../config/db.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Thiếu id']);
    exit;
}
$id = (int)$id;
// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT p.*, c.id AS category, MIN(vp.price) as minPrice, MAX(vp.price) as maxPrice, 
                        CONCAT('[', GROUP_CONCAT(
                                CONCAT(
                                    '{\"volume_id\":', v.id,
                                    ',\"volume_name\":\"', REPLACE(v.value, '\"', '\\\"'),
                                    '\",\"price\":', vp.price,
                                    '}'
                                ) ORDER BY v.id
                            ), ']') AS volumes
                        FROM products p
                        JOIN volume_product vp ON vp.product_id = p.id
                        JOIN category c ON p.category_id = c.id
                        JOIN volume v ON v.id = vp.volume_id
                        WHERE p.id = ? AND status = 'active'
                        LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$product['volumes'] = json_decode($product['volumes']);
if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
    exit;
}

// Lấy các sản phẩm cùng brand (trừ chính nó)
$stmt2 = $conn->prepare("SELECT p.*, MIN(vp.price) as minPrice, MAX(vp.price) as maxPrice, 
                        CONCAT('[', GROUP_CONCAT(
                                CONCAT(
                                    '{\"volume_id\":', v.id,
                                    ',\"volume_name\":\"', REPLACE(v.value, '\"', '\\\"'),
                                    '\",\"price\":', vp.price,
                                    '}'
                                ) ORDER BY v.id
                            ), ']') AS volumes
                        FROM products p
                        JOIN volume_product vp ON vp.product_id = p.id
                        JOIN category c ON c.id = p.category_id
                        JOIN volume v ON vp.volume_id = v.id
                        WHERE category_id = ? AND p.id != ? AND status = 'active'
                        GROUP BY p.id
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
