<?php
header('Content-Type: application/json');
require_once dirname( __FILE__ ) . '/../../config/db.php';

$product_id = $_GET['product_id'] ?? null;
$volume = $_GET['volume'] ?? null;

if (!$product_id || !$volume) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit;
}

$sql = "SELECT vp.price 
        FROM volume_product vp
        JOIN volume v ON vp.volume_id = v.id
        WHERE vp.product_id = ? AND v.value = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $product_id, $volume);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'price' => $row['price']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Price not found'
    ]);
}

$conn->close();
?>
