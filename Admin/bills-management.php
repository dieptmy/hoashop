<?php
include 'includes/header.php';
require_once 'includes/db.php';

// ✅ Toast: Cập nhật đơn hàng thành công
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<script>
        window.onload = () => {
            const toast = document.createElement("div");
            toast.className = "alert alert-success position-fixed top-0 end-0 m-4 shadow";
            toast.style.zIndex = 9999;
            toast.textContent = "Cập nhật đơn hàng thành công!";
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.remove();
                const url = new URL(window.location);
                url.searchParams.delete("success");
                window.history.replaceState({}, document.title, url);
            }, 3000);
        };
    </script>';
}

// ✅ Toast: Lọc đơn hàng thành công
if (
    $_SERVER['REQUEST_METHOD'] === 'GET' &&
    (!empty($_GET['status']) || !empty($_GET['start']) || !empty($_GET['end']) || !empty($_GET['location'])) &&
    !isset($_GET['success']) // tránh hiển thị cùng lúc với cập nhật
) {
    echo '<script>
        window.onload = () => {
            const toast = document.createElement("div");
            toast.className = "alert alert-info position-fixed top-0 end-0 m-4 shadow";
            toast.style.zIndex = 9999;
            toast.textContent = "Lọc đơn hàng thành công!";
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        };
    </script>';
}

$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$where = [];
$params = [];
$types = "";

// Lọc theo trạng thái
if (!empty($_GET['status'])) {
    $where[] = "o.status = ?";
    $types .= "s";
    $params[] = $_GET['status'];
}

// Lọc theo khoảng ngày
if (!empty($_GET['start']) && !empty($_GET['end'])) {
    $where[] = "DATE(o.created_at) BETWEEN ? AND ?";
    $types .= "ss";
    $params[] = $_GET['start'];
    $params[] = $_GET['end'];
}

$cities = $conn->query("SELECT * FROM city ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
$districts = $conn->query("SELECT * FROM district ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

// Lọc theo district_id
if (!empty($_GET['district_id'])) {
    $districtName = $conn->prepare("SELECT name FROM district WHERE id = ?");
    $districtName->bind_param("i", $_GET['district_id']);
    $districtName->execute();
    $dResult = $districtName->get_result()->fetch_assoc();
    if ($dResult) {
        $where[] = "o.address LIKE ?";
        $types .= "s";
        $params[] = '%' . $dResult['name'] . '%';
    }
}

// Lọc theo city_id
if (!empty($_GET['city_id'])) {
    $cityName = $conn->prepare("SELECT name FROM city WHERE id = ?");
    $cityName->bind_param("i", $_GET['city_id']);
    $cityName->execute();
    $cResult = $cityName->get_result()->fetch_assoc();
    if ($cResult) {
        $where[] = "o.address LIKE ?";
        $types .= "s";
        $params[] = '%' . $cResult['name'] . '%';
    }
}

$filterSql = " FROM orders o LEFT JOIN users u ON o.user_id = u.id";
if ($where) {
    $filterSql .= " WHERE " . implode(" AND ", $where);
}

// Đếm tổng số dòng
$countSql = "SELECT COUNT(*) as total" . $filterSql;
$countStmt = $conn->prepare($countSql);
if ($types !== "") {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// Truy vấn dữ liệu
$sql = "
    SELECT 
        o.id,
        o.created_at,
        o.status,
        o.address,
        o.payment_method,
        o.total_price,
        o.total_qty,
        u.fullname,
        u.number
    " . $filterSql . "
    ORDER BY o.created_at DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);
if ($types !== "") {
    $bindValues = array_merge($params, [$limit, $offset]);
    $stmt->bind_param($types . "ii", ...$bindValues);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container py-5">
    <!-- Tiêu đề nằm ngoài card -->
    <h1 class="mb-4 text-center"><i class="bi bi-receipt-cutoff"></i> Quản Lý Đơn Hàng</h1>

    <div class="card shadow rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form class="d-flex gap-2" method="GET" action="">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending">Chưa xác nhận</option>
                        <option value="confirmed">Đã xác nhận</option>
                        <option value="shipped">Đang giao</option>
                        <option value="delivered">Thành công</option>
                        <option value="cancel">Đã huỷ</option>
                    </select>
                    <input type="date" name="start" class="form-control" />
                    <input type="date" name="end" class="form-control" />
                    <select name="city_id" id="citySelect" class="form-select">
                        <option value="">Tất cả Tỉnh/Thành phố</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= $city['id'] ?>" <?= ($_GET['city_id'] ?? '') == $city['id'] ? 'selected' : '' ?>><?= htmlspecialchars($city['name']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select name="district_id" id="districtSelect" class="form-select">
                        <option value="">Tất cả Quận/Huyện</option>
                        <?php foreach ($districts as $district): ?>
                            <option value="<?= $district['id'] ?>" data-city="<?= $district['city_id'] ?>" <?= ($_GET['district_id'] ?? '') == $district['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($district['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary">Lọc</button>
                </form>
            </div>

            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Ngày đặt</th>
                        <th>Sản phẩm</th>
                        <th>Phương thức</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['fullname'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['number'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                        <td><?= $row['total_qty'] ?> sản phẩm</td>
                        <td>
                            <?php
                            $paymentText = match (strtolower($row['payment_method'])) {
                                'credit_card' => 'Thẻ tín dụng',
                                'cod' => 'Thanh toán khi nhận hàng',
                                'bank_transfer' => 'Chuyển khoản ngân hàng',
                                default => ucfirst($row['payment_method']),
                            };
                            echo $paymentText;
                            ?>
                        </td>
                        <td><?= number_format($row['total_price'], 0, ',', '.') ?>₫</td>
                        <td>
                            <?php
                            $badgeClass = match (strtolower($row['status'])) {
                                'pending' => 'secondary',
                                'confirmed' => 'warning',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancel' => 'danger',
                                default => 'light',
                            };
                            $statusText = match (strtolower($row['status'])) {
                                'pending' => 'Chưa xác nhận',
                                'confirmed' => 'Đã xác nhận',
                                'shipped' => 'Đang giao',
                                'delivered' => 'Thành công',
                                'cancel' => 'Đã huỷ',
                                default => $row['status'],
                            };
                            ?>
                            <span class="badge bg-<?= $badgeClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>
                            <a href="bills-edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                        </td>
                    </tr>
                <?php endwhile ?>
                </tbody>
            </table>

            <?php if ($totalPages > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php
                            $queryParams = $_GET;
                            $queryParams['page'] = $i;
                            $queryString = http_build_query($queryParams);
                            ?>
                            <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= $queryString ?>"><?= $i ?></a>
                            </li>
                        <?php endfor ?>
                    </ul>
                </nav>
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
  .filter-form {
    flex-wrap: wrap !important;
    gap: 10px;
  }
  .filter-form select,
  .filter-form input {
    flex: 1 1 48%;
    min-width: 140px;
  }
  .filter-form button {
    flex: 1 1 100%;
    max-width: 120px;
    align-self: center;
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

document.getElementById('citySelect').addEventListener('change', function() {
    const cityId = this.value;
    const districtSelect = document.getElementById('districtSelect');
    const options = districtSelect.querySelectorAll('option[data-city]');

    options.forEach(option => {
        option.style.display = (cityId === "" || option.getAttribute('data-city') === cityId) ? 'block' : 'none';
    });

    districtSelect.value = "";
});

window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('citySelect').dispatchEvent(new Event('change'));
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'includes/footer.php'; ?>
