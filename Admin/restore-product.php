<?php
require_once dirname( __FILE__ ) . '/../config/db.php';

$id = $_GET['id'];
if ($id) {
    $stmt = $conn->prepare("UPDATE products SET status = 'active' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: product-hidden.php?success=4");
exit;
?>
