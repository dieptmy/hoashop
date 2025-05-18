<?php
header('Content-Type: application/json');
session_start();
require_once dirname(__FILE__) . '/../../config/db.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Kiểm tra thông tin đầu vào
if (!$username || !$password) {
    echo json_encode([
        "success" => false,
        "message" => "Vui lòng nhập đầy đủ thông tin!"
    ]);
    exit;
}

// Truy vấn người dùng theo username
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra có người dùng hay không
if ($result && $user = $result->fetch_assoc()) {
    // Kiểm tra mật khẩu đúng không
    if (!password_verify($password, $user['password'])) {
        echo json_encode([
            "success" => false,
            "message" => "Sai tài khoản hoặc mật khẩu"
        ]);
        exit;
    }

    // Kiểm tra trạng thái tài khoản
    if (isset($user['status']) && $user['status'] === 'lock') {
        echo json_encode([
            "success" => false,
            "message" => "Tài khoản của bạn đã bị khóa."
        ]);
        exit;
    }

    // Đăng nhập thành công → Lưu session
    $_SESSION['user_id'] = $user['id'];

    // Trả về dữ liệu người dùng
    echo json_encode([
        "success" => true,
        "message" => "Đăng nhập thành công",
        "data" => [
            "id" => $user['id'],
            "username" => $user['username'],
            "fullname" => $user['fullname'] ?? null,
            "email" => $user['email'] ?? null,
            "number" => $user['number'] ?? null,
            "address" => $user['address'] ?? null,
            "district" => $user['district_name'] ?? null,
            "city" => $user['city_name'] ?? null
        ]
    ]);
} else {
    // Không tìm thấy tài khoản
    echo json_encode([
        "success" => false,
        "message" => "Sai tài khoản hoặc mật khẩu"
    ]);
}
?>
