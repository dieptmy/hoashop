<?php
include 'includes/header.php';
require_once 'includes/db.php';

// Lấy ID đơn hàng từ URL
$orderID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin đơn hàng từ bảng orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Không tìm thấy đơn hàng.</div></div>";
    include 'includes/footer.php';
    exit;
}

// Danh sách trạng thái hợp lệ theo thứ tự
$statuses = [
    'pending' => 'Chưa xác nhận',
    'confirmed' => 'Đã xác nhận',
    'shipped' => 'Đang giao',
    'delivered' => 'Đã giao thành công',
    'cancel' => 'Đã huỷ'
];

$currentStatusKey = strtolower($order['status']);
$currentStatusIndex = array_search($currentStatusKey, array_keys($statuses));
?>

<div class="container py-5">
    <div class="card shadow rounded-4">
        <div class="card-body">
            <h2 class="mb-4">Chỉnh sửa đơn hàng #<?= $order['id'] ?></h2>

            <form method="POST" action="bills-update.php">
                <input type="hidden" name="id" value="<?= $order['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Địa chỉ giao hàng</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($order['address']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái đơn hàng</label>
                    <select name="status" class="form-select">
                        <?php
                        $statusKeys = array_keys($statuses);
                        for ($i = $currentStatusIndex; $i < count($statuses); $i++):
                            $key = $statusKeys[$i];
                        ?>
                            <option value="<?= $key ?>" <?= $key === $currentStatusKey ? 'selected' : '' ?>>
                                <?= $statuses[$key] ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú đơn hàng</label>
                    <textarea name="note" class="form-control" rows="4" placeholder="Nhập ghi chú nếu có..."><?= htmlspecialchars($order['note'] ?? '') ?></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="bills-management.php" class="btn btn-secondary">Quay lại danh sách</a>
                    <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
                </div>
            </form>
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
  .card-body > form,
  .card-body form,
  form[action*="edit-product"],
  form[action*="add-product"],
  form[action*="update-product"],
  form[action*="bills-update"] {
    flex-direction: column !important;
    gap: 10px;
  }
  .filter-form select,
  .filter-form input,
  .filter-form button,
  form.row.g-2 .form-control,
  form.row.g-2 button,
  .card-body form .form-control,
  .card-body form .form-select,
  .card-body form button,
  form[action*="edit-product"] .form-control,
  form[action*="edit-product"] .form-select,
  form[action*="edit-product"] button,
  form[action*="add-product"] .form-control,
  form[action*="add-product"] .form-select,
  form[action*="add-product"] button,
  form[action*="update-product"] .form-control,
  form[action*="update-product"] .form-select,
  form[action*="update-product"] button,
  form[action*="bills-update"] .form-control,
  form[action*="bills-update"] .form-select,
  form[action*="bills-update"] button {
    width: 100% !important;
  }
  form[action*="edit-product"] .d-flex,
  form[action*="add-product"] .d-flex,
  form[action*="update-product"] .d-flex,
  form[action*="bills-update"] .d-flex {
    flex-direction: column !important;
    gap: 10px;
  }
  form[action*="edit-product"] .d-flex .btn,
  form[action*="add-product"] .d-flex .btn,
  form[action*="update-product"] .d-flex .btn,
  form[action*="bills-update"] .d-flex .btn {
    width: 100%;
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
