<?php
header('Content-Type: application/json');
session_start();
require_once dirname( __FILE__ ) . '/../../config/db.php';

$city_id = $_GET['city_id'] ?? 0;

$sql = "SELECT id, name FROM district WHERE city_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $city_id);
$stmt->execute();
$result = $stmt->get_result();
$districts = [];
while ($row = $result->fetch_assoc()) {
    $districts[] = $row;
}
echo json_encode(['success' => true, 'data' => $districts]);
?>
