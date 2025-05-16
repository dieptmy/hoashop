<?php
$host = 'localhost';
$user = 'root'; // thay đổi nếu cần
$pass = '';     // thay đổi nếu có mật khẩu
$db   = 'admin_shop'; // thay tên database của bạn

$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}   
// echo "Kết nối thành công!";
?>
