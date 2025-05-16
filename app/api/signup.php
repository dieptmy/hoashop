<?php
header('Content-Type: application/json');
require_once dirname( __FILE__ ) . '/../../config/db.php';

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$number = $_POST['number'] ?? '';

if (!$username || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin!']);
    exit;
}

// Kiểm tra username hoặc email đã tồn tại
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Tên đăng nhập hoặc email đã tồn tại!']);
    exit;
}

// Thêm user mới
$stmt = $conn->prepare("INSERT INTO users (username, email, password, number, role) VALUES (?, ?, ?, ?, 'user')");
$stmt->bind_param("ssss", $username, $email, $password, $number);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Đăng ký thành công!']);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi đăng ký!']);
    exit;
}
?>
