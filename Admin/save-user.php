<?php
include 'admin-session.php';
require_once 'includes/db.php';
session_start();

$currentUserId = $_SESSION['user_id'] ?? 0;
$currentUserRole = $_SESSION['user_role'] ?? 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetId = (int)$_POST['id'];
    $targetRole = $_POST['role'];

    // Ngăn super_admin tự thay đổi vai trò chính mình
    if ($currentUserRole === 'super_admin' && $targetId === $currentUserId && $targetRole !== 'super_admin') {
        echo "❌ Không thể thay đổi vai trò của chính bạn.";
        exit;
    }

    // Ngăn admin thay đổi role của admin hoặc super_admin
    if ($currentUserRole === 'admin') {
        $check = $conn->prepare("SELECT role FROM users WHERE id = ?");
        $check->bind_param("i", $targetId);
        $check->execute();
        $res = $check->get_result();
        $row = $res->fetch_assoc();
        $check->close();

        if (!$row || strtolower($row['role']) !== 'user' || $targetRole !== 'user') {
            echo "❌ Không có quyền chỉnh sửa người dùng này.";
            exit;
        }
    }

    // Thực hiện cập nhật
    $stmt = $conn->prepare("UPDATE users SET username=?, fullname=?, number=?, email=?, address=?, role=?, status=? WHERE id=?");
    $stmt->bind_param(
        "sssssssi",
        $_POST['username'],
        $_POST['fullname'],
        $_POST['number'],
        $_POST['email'],
        $_POST['address'],
        $_POST['role'],
        $_POST['status'],
        $targetId
    );

    if ($stmt->execute()) {
        header("Location: user-management.php?success=2");
        exit();
    } else {
        echo "Lỗi cập nhật: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Phương thức không hợp lệ.";
}

$conn->close();
