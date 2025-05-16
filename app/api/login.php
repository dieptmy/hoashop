<?php
header('Content-Type: application/json');
session_start(); //Khởi tạo session

include 'connect.php'; // Kết nối CSDL, trả về biến $conn

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Bảo mật: dùng Prepared Statement
$stmt = $conn->prepare(
    "SELECT u.*, d.name as district_name, c.name as city_name
     FROM users u
     LEFT JOIN district d ON u.district_id = d.id
     LEFT JOIN city c ON d.city_id = c.id
     WHERE u.username = ? AND u.password = ?"
);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Lưu user_id vào session
    $_SESSION['user_id'] = $user['id'];

    // Trả về thông tin người dùng dưới dạng JSON
    echo json_encode([
        "success" => true,
        "message" => "Đăng nhập thành công",
        "data" => [
            "id" => $user['id'],
            "username" => $user['username'],
            "fullname" => $user['fullname'],
            "email" => $user['email'] ?? null,
            "number" => $user['number'] ?? null,
            "address" => $user['address'] ?? null,
            "district" => $user['district_name'] ?? null,
            "city" => $user['city_name'] ?? null
        ]
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Sai tài khoản hoặc mật khẩu"
    ]);
}
?>
