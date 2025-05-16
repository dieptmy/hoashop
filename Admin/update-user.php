<?php
require_once 'includes/db.php';
session_start();

$currentUserId = $_SESSION['user_id'] ?? 0;
$currentUserRole = $_SESSION['user_role'] ?? 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_ID'])) {
    $userID = intval($_POST['user_ID']);

    // Lấy role và status hiện tại của người bị chỉnh
    $stmt = $conn->prepare("SELECT role, status FROM users WHERE id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $targetRole = strtolower($row['role']);
        $currentStatus = $row['status'];

        // Ngăn super_admin tự khóa chính mình
        if ($currentUserRole === 'super_admin' && $userID === $currentUserId) {
            echo "error:Bạn không thể khóa chính mình.";
            exit;
        }

        // Admin không được khoá admin/super_admin
        if ($currentUserRole === 'admin' && $targetRole !== 'user') {
            echo "error:Bạn không có quyền thay đổi trạng thái tài khoản này.";
            exit;
        }

        // Toggle trạng thái
        $newStatus = ($currentStatus === 'active') ? 'lock' : 'active';

        $update = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $update->bind_param("si", $newStatus, $userID);

        if ($update->execute()) {
            echo "success";
        } else {
            echo "error:Lỗi khi cập nhật: " . $update->error;
        }

        $update->close();
    } else {
        echo "error:Tài khoản không tồn tại.";
    }

    $stmt->close();
} else {
    echo "error:Truy vấn không hợp lệ.";
}

$conn->close();
