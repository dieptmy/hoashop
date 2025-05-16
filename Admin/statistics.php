<?php
include 'includes/header.php';
require_once dirname( __FILE__ ) . '/../config/db.php';

$topUsers = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['start']) && isset($_GET['end'])) {
    $start = $_GET['start'];
    $end = $_GET['end'];

    $sql = "
        SELECT 
            u.id AS user_ID,
            u.fullname,
            u.email,
            COUNT(DISTINCT o.id) AS total_orders,
            SUM(oi.price * oi.quantity) AS total_spent
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN users u ON o.user_id = u.id
        WHERE DATE(o.created_at) BETWEEN ? AND ? AND o.status != 'cancel'
        GROUP BY u.id
        ORDER BY total_spent DESC
        LIMIT 5
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $start, $end);
    $stmt->execute();
    $topUsers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="container py-5">
        <!-- Tiêu đề nằm ngoài card -->
    <h1 class="mb-4 text-center"><i class="bi bi-bar-chart-line"></i> Thống Kê</h1>

    <div class="card shadow rounded-4">
        <div class="card-body">

            <form method="GET" class="row g-2 mb-4">
                <div class="col-md-5">
                    <label for="start" class="form-label">Từ ngày</label>
                    <input type="date" id="start" name="start" class="form-control" value="<?= htmlspecialchars($_GET['start'] ?? '') ?>" required>
                </div>
                <div class="col-md-5">
                    <label for="end" class="form-label">Đến ngày</label>
                    <input type="date" id="end" name="end" class="form-control" value="<?= htmlspecialchars($_GET['end'] ?? '') ?>" required>
                </div>
                <div class="col-md-2 d-grid align-self-end">
                    <button type="submit" class="btn btn-primary">Thống kê</button>
                </div>
            </form>

            <?php if (!empty($topUsers)): ?>
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th>Số đơn đã mua</th>
                            <th>Tổng chi tiêu</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topUsers as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['fullname']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= $user['total_orders'] ?></td>
                                <td><?= number_format($user['total_spent'], 0, ',', '.') ?>đ</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary" href="statistics-detail.php?user_ID=<?= $user['user_ID'] ?>&start=<?= $start ?>&end=<?= $end ?>">
                                        Xem
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
                <p class="text-muted">Không tìm thấy dữ liệu trong khoảng thời gian đã chọn.</p>
            <?php endif; ?>
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
  form.row.g-2 {
    flex-direction: column !important;
    gap: 10px;
  }
  .filter-form select,
  .filter-form input,
  .filter-form button,
  form.row.g-2 .form-control,
  form.row.g-2 button {
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
