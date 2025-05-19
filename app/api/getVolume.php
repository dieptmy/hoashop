<?php
require_once dirname( __FILE__ ) . '/../../config/db.php';
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Thiếu id']);
    exit;
}
$id = (int)$id;
$stmt = $conn->prepare("SELECT * FROM volume_product WHERE product_id =?" );
$stmt->bind_param("i", $id);
$stmt->execute();
$volume = [];
$result = $stmt->get_result();
while($row= $result->fetch_assoc()){
    $volume[] = $row;
}
echo json_encode([
    "success" => true,
    "volume" => $volume
]);

?>