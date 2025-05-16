<?php
include 'includes/header.php';
require_once 'includes/db.php';

$currentRole = $_SESSION['user_role'] ?? 'user';
$userId = $_SESSION['user_id'] ?? 0;

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if ($currentRole === 'admin') {
    $roleCondition = "WHERE LOWER(role) = 'user'";
} elseif ($currentRole === 'super_admin') {
    $roleCondition = "WHERE LOWER(role) IN ('user', 'admin') AND id != $userId";
} else {
    echo "<div class='container py-5'><div class='alert alert-danger'>Bạn không có quyền truy cập trang này.</div></div>";
    include 'includes/footer.php';
    exit;
}

$countSql = "SELECT COUNT(*) as total FROM users $roleCondition";
$countResult = $conn->query($countSql);
$totalRow = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRow / $limit);

$sql = "SELECT * FROM users $roleCondition LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<main class="container py-5">
    <h1 class="mb-4 text-center"><i class="bi bi-person-lines-fill"></i> Quản Lý Người Dùng</h1>

    <div class="card shadow rounded-4">
        <div class="card-body">
            <div class="mb-3 text-end">
                <a href="add-user.php" class="btn btn-success"><i class="bi bi-person-plus"></i> Thêm người dùng</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="userTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tài Khoản</th>
                            <th>Họ Tên</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Vai Trò</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td data-label="ID"><?= $row['id'] ?></td>
                            <td data-label="Tài Khoản"><?= htmlspecialchars($row['username']) ?></td>
                            <td data-label="Họ Tên"><?= htmlspecialchars($row['fullname'] ?? '—') ?></td>
                            <td data-label="SĐT"><?= htmlspecialchars($row['number']) ?></td>
                            <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
                            <td data-label="Địa Chỉ"><?= htmlspecialchars($row['address'] ?? '—') ?></td>
                            <td data-label="Vai Trò">
                                <?php
                                $roleText = match(strtolower($row['role'])) {
                                    'super_admin' => 'Super Admin',
                                    'admin' => 'Quản trị viên',
                                    default => 'Người dùng'
                                };
                                echo $roleText;
                                ?>
                            </td>
                            <td data-label="Trạng Thái">
                                <?= strtolower($row['status']) === 'active'
                                    ? '<span class="badge bg-success">Đang hoạt động</span>'
                                    : '<span class="badge bg-secondary">Đã bị khóa</span>' ?>
                            </td>
                            <td data-label="Hành Động">
                                <?php
                                $targetRole = strtolower($row['role']);
                                $canEdit = false;
                                $canToggle = false;

                                if ($currentRole === 'super_admin') {
                                    $canEdit = true;
                                    $canToggle = true;
                                } elseif ($currentRole === 'admin') {
                                    $canEdit = ($targetRole === 'user');
                                    $canToggle = ($targetRole === 'user');
                                }
                                ?>

                                <?php if ($canEdit): ?>
                                    <a href="edit-user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-accent me-1">✏️ Sửa</a>
                                <?php endif; ?>
                                <?php if ($canToggle): ?>
                                    <button onclick="toggleStatus(<?= $row['id'] ?>)" class="btn btn-sm btn-accent">🔒 Khóa/Mở</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=1">&laquo;</a></li>
                    <?php endif; ?>
                    <?php if ($page > 3): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages - 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $totalPages ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>

<!-- Modal xác nhận -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Xác nhận</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn khóa hoặc mở người dùng này không?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Hủy</button>
        <button type="button" class="btn btn-danger" id="confirmToggleBtn">✅ Xác nhận</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast thông báo -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="statusToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMessage">✔️ Thành công</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Đóng"></button>
    </div>
  </div>
</div>

<style>
@media (max-width: 1000px) {
  #userTable thead {
      display: none;
  }
  #userTable tr {
      display: block;
      margin-bottom: 15px;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 10px;
      background-color: #f8f9fa;
      width: 100%;
      box-sizing: border-box;
  }
  #userTable td {
      display: block;
      text-align: right;
      padding-left: 50%;
      padding-top: 6px;
      padding-bottom: 6px;
      font-size: 14px;
      position: relative;
      border: none;
      border-bottom: 1px solid #dee2e6;
      box-sizing: border-box;
      overflow-wrap: break-word;
  }
  #userTable td::before {
      content: attr(data-label);
      position: absolute;
      left: 10px;
      top: 6px;
      font-weight: bold;
      font-size: 13px;
      color: #333;
      text-align: left;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 45%;
      box-sizing: border-box;
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
}
</style>

<script>
let selectedUserID = null;

function toggleStatus(userID) {
    selectedUserID = userID;
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    confirmModal.show();
}

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('confirmToggleBtn').addEventListener('click', function () {
        if (selectedUserID) {
            fetch('update-user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'user_ID=' + selectedUserID
            })
            .then(res => res.text())
            .then(data => {
                if (data.trim() === 'success') {
                    window.location.href = 'user-management.php?success=3';
                } else {
                    alert('Không thể cập nhật trạng thái người dùng.\n' + data);
                }
            })
            .catch(err => alert('Lỗi kết nối tới máy chủ.'));
        }
    });

    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    if (success) {
        const toastMessage = document.getElementById('toastMessage');
        if (success == '1') toastMessage.textContent = '✔️ Thêm người dùng thành công!';
        else if (success == '2') toastMessage.textContent = '✔️ Cập nhật người dùng thành công!';
        else if (success == '3') toastMessage.textContent = '✔️ Đã thay đổi trạng thái người dùng!';
        else toastMessage.textContent = '✔️ Thao tác thành công!';

        const toast = new bootstrap.Toast(document.getElementById('statusToast'), { delay: 3000 });
        toast.show();

        history.replaceState(null, "", window.location.pathname);
    }
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
