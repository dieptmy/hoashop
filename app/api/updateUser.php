<?php
require_once dirname( __FILE__ ) . '/../../config/db.php';
header('Content-Type: application/json');

// Nhận dữ liệu từ client
$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'] ?? null;
$fullname = $data['fullname'] ?? null;
$address = $data['address'] ?? null;
$district_id = $data['districtId'] ?? 0;

if (!$user_id || !$fullname || !$address || !$district_id) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
    exit;
}

// Cập nhật thông tin user
$stmt = $conn->prepare("UPDATE users SET fullname = ?, address = ?, district_id = ? WHERE id = ?");
$stmt->bind_param("ssii", $fullname, $address, $district_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại']);
}
?>
