<?php
require_once dirname( __FILE__ ) . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderID = (int)$_POST['id'];
    $newStatus = $_POST['status'];
    $newNote = trim($_POST['note']);

    // Trạng thái hợp lệ
    $statuses = ['pending', 'confirmed', 'shipped', 'delivered', 'cancel'];

    // Lấy trạng thái hiện tại
    $stmt = $conn->prepare("SELECT status FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        die("Không tìm thấy đơn hàng.");
    }

    $currentStatus = strtolower($result['status']);
    $currentIndex = array_search($currentStatus, $statuses);
    $newIndex = array_search(strtolower($newStatus), $statuses);

    if ($newIndex === false || $currentIndex === false) {
        die("Trạng thái không hợp lệ.");
    }

    if ($newIndex < $currentIndex) {
        die("Không thể cập nhật lùi trạng thái đơn hàng.");
    }

    // Cập nhật trạng thái + ghi chú
    $update = $conn->prepare("UPDATE orders SET status = ?, note = ? WHERE id = ?");
    $update->bind_param("ssi", $newStatus, $newNote, $orderID);

    if ($update->execute()) {
        header("Location: bills-management.php?success=1");
        exit;
    } else {
        echo "Lỗi cập nhật đơn hàng.";
    }
}
?>
