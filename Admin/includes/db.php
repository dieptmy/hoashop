<?php
$host = "localhost";       // tên máy chủ CSDL (XAMPP = localhost)
$user = "root";            // tài khoản MySQL mặc định (XAMPP = root)
$password = "";            // mật khẩu thường để trống khi dùng XAMPP
$database = "admin_shop";    // tên cơ sở dữ liệu mà bạn đang dùng

$conn = new mysqli($host, $user, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đảm bảo hỗ trợ tiếng Việt
$conn->set_charset("utf8mb4");
?>
