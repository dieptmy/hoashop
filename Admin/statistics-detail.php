<?php
include 'includes/header.php';
require_once dirname( __FILE__ ) . '/../config/db.php';

if (!isset($_GET['user_ID'], $_GET['start'], $_GET['end'])) {
    echo '<div class="container py-5"><div class="alert alert-danger">Thiếu thông tin truy vấn.</div></div>';
    include 'includes/footer.php';
    exit;
}

$user_ID = (int)$_GET['user_ID'];
$start = $_GET['start'];
$end = $_GET['end'];

// Lấy thông tin người dùng
$stmtUser = $conn->prepare("SELECT fullname, email FROM users WHERE id = ?");
$stmtUser->bind_param("i", $user_ID);
$stmtUser->execute();
$userInfo = $stmtUser->get_result()->fetch_assoc();

// Truy vấn chi tiết đơn hàng của người dùng
$sql = "
    SELECT 
        o.id AS order_id,
        o.created_at,
        p.name AS product_name,
        oi.quantity,
        oi.price,
        (oi.quantity * oi.price) AS total
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN volume_product vp ON oi.volume_product_id = vp.id
    JOIN products p ON vp.product_id = p.id
    WHERE o.user_id = ? AND DATE(o.created_at) BETWEEN ? AND ? AND o.status != 'cancel'
    ORDER BY o.created_at DESC, o.id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $user_ID, $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$groupedOrders = [];
while ($row = $result->fetch_assoc()) {
    $orderID = $row['order_id'];
    if (!isset($groupedOrders[$orderID])) {
        $groupedOrders[$orderID] = [
            'created_at' => $row['created_at'],
            'products' => [],
        ];
    }
    $groupedOrders[$orderID]['products'][] = $row;
}
?>

<div class="container py-5">
    <div class="card shadow rounded-4">
        <div class="card-body">
            <h2 class="mb-4">Chi Tiết Mua Hàng: <?= htmlspecialchars($userInfo['fullname']) ?> (<?= htmlspecialchars($userInfo['email']) ?>)</h2>
            <p><strong>Thời gian:</strong> <?= date('d/m/Y', strtotime($start)) ?> - <?= date('d/m/Y', strtotime($end)) ?></p>

            <?php if (!empty($groupedOrders)): ?>
                <?php foreach ($groupedOrders as $orderID => $data): ?>
                    <div class="mb-4">
                        <h5>Đơn hàng #<?= $orderID ?> - Ngày: <?= date('d/m/Y', strtotime($data['created_at'])) ?></h5>
                        <table class="table table-sm table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 0; foreach ($data['products'] as $product): $sum += $product['total']; ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                                        <td><?= number_format($product['price'], 0, ',', '.') ?>đ</td>
                                        <td><?= $product['quantity'] ?></td>
                                        <td><?= number_format($product['total'], 0, ',', '.') ?>đ</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-secondary">
                                    <td colspan="3"><strong>Tổng cộng</strong></td>
                                    <td><strong><?= number_format($sum, 0, ',', '.') ?>đ</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Không có đơn hàng nào trong khoảng thời gian này.</p>
            <?php endif; ?>

            <a href="statistics.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-secondary mt-3">Quay lại</a>
        </div>
    </div>
</div>

<style>
@media (max-width: 1000px) {
  table thead {
      display: none;
  }
  table tr {
      display: block;
      margin-bottom: 16px;
      border: 1px solid #dee2e6;
      border-radius: 12px;
      padding: 16px;
      background-color: #ffffff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  }
  table td {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
      font-size: 14px;
      border: none;
      border-bottom: 1px solid #eee;
      position: relative;
  }
  table td:last-child {
      border-bottom: none;
  }
  table td::before {
      content: attr(data-label);
      font-weight: 600;
      color: #555;
      flex: 1;
      text-align: left;
  }
}

@media (max-width: 680px) {
  .sidebar {
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
    position: absolute;
    z-index: 999;
  }
  .sidebar:hover {
    transform: translateX(0);
  }
  .sidebar .nav-icon {
    display: block;
    padding: 1rem;
    text-align: center;
  }
  .sidebar .nav-label {
    display: none;
  }
  .sidebar a {
    display: block;
  }
  .filter-form,
  form.row.g-2,
  .card-body > form {
    flex-direction: column !important;
    gap: 10px;
  }
  .filter-form select,
  .filter-form input,
  .filter-form button,
  form.row.g-2 .form-control,
  form.row.g-2 button,
  .card-body > form input,
  .card-body > form button {
    width: 100% !important;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tables = document.querySelectorAll("table");
    tables.forEach(table => {
        const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.textContent.trim());
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(row => {
            const cells = row.querySelectorAll("td");
            cells.forEach((cell, index) => {
                if (!cell.hasAttribute("data-label") && headers[index]) {
                    cell.setAttribute("data-label", headers[index]);
                }
            });
        });
    });
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'includes/footer.php'; ?>
