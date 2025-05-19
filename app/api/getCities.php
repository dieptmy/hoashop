<?php
require_once dirname( __FILE__ ) . '/../../config/db.php';

header('Content-Type: application/json; charset=utf-8');

$city_name = $_GET['city_name'] ?? null;

// Lấy danh sách thành phố
$sql = "SELECT id, name FROM city";
$result = $conn->query($sql);

$cities = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
}

// Nếu có city_name thì lấy id tương ứng
$city_id = null;
if ($city_name) {
    $stmt = $conn->prepare("SELECT id FROM city WHERE name = ?");
    $stmt->bind_param("s", $city_name);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $city_id = $row['id'];
    }
}

echo json_encode([
    'success' => true,
    'data' => $cities,
    'city_id' => $city_id // có thể là null nếu không tìm thấy
]);
?>
