<?php
header('Content-Type: application/json');
session_start();
require_once dirname( __FILE__ ) . '/../../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Người dùng chưa đăng nhập"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT cart.*, products.name, products.image_urf, volume_product.price, volume.value
        FROM cart 
        JOIN volume_product ON cart.volume_product_id = volume_product.id
        JOIN products ON volume_product.product_id = products.id
        JOIN volume ON volume_product.volume_id = volume.id
        WHERE cart.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
while ($row = $result->fetch_assoc()) {
    $cart[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $cart
]);

$conn->close();
?>
