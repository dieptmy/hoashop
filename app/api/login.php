<?php
header('Content-Type: application/json');
session_start(); //Khởi tạo session

include 'connect.php'; // Kết nối CSDL, trả về biến $conn

$username = trim($_POST['username']) ?? '';
$password = $_POST['password'] ?? '';
 $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $user = $result->fetch_assoc()) {
     $_SESSION['user_id'] = $user['id'];

    if (!password_verify($password, $user['password'])) {
            echo json_encode([
                "success" => false,
                "message" => "Sai tài khoản hoặc mật khẩu"
            ]);
        } elseif ($user['status'] === 'lock') {
             echo json_encode([
                "success" => false,
                "message" => "Tài khoản của bạn đã bị khóa."
            ]);
        } else {
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
        }


    if (!password_verify($password, $user['password'])) {
    }
} else {
     echo json_encode([
        "success" => false,
        "message" => "Sai tài khoản hoặc mật khẩu"
    ]);
}

?>
