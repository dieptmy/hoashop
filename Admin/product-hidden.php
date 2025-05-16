<?php
include 'includes/header.php';
require_once 'includes/db.php';

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$countSql = "SELECT COUNT(*) as total FROM products WHERE status = 'hidden'";
$countResult = $conn->query($countSql);
$totalRow = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRow / $limit);

$sql = "
    SELECT 
        p.id AS product_ID,
        p.name AS product_name,
        p.image_urf AS image_url,
        p.category_id,
        p.status,
        MIN(vp.price) AS min_price,
        MAX(vp.price) AS max_price
    FROM products p
    LEFT JOIN volume_product vp ON p.id = vp.product_id
    WHERE p.status = 'hidden'
    GROUP BY p.id
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($sql);
?>

<div class="container py-5">
    <h1 class="mb-4">Danh sách sản phẩm đã ẩn</h1>

    <div class="mb-4 text-start">
        <a href="product-management.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại trang quản lý sản phẩm
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Khôi phục</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            Không có sản phẩm nào bị ẩn.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['product_ID'] ?></td>
                            <td>
                                <?php
                                    $imagePath = !empty($row['image_url']) && file_exists('../' . $row['image_url'])
                                        ? '/' . ltrim($row['image_url'], '/')
                                        : '/images/no-image.jpg';
                                ?>
                                <img src="<?= htmlspecialchars($imagePath) ?>" alt="Ảnh sản phẩm" width="80" height="80" class="rounded">
                            </td>
                            <td class="text-start"><?= htmlspecialchars($row['product_name']) ?></td>
                            <td>
                                <?= number_format($row['min_price'], 0, ',', '.') ?>đ
                                <?php if ($row['min_price'] != $row['max_price']): ?>
                                    - <?= number_format($row['max_price'], 0, ',', '.') ?>đ
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                switch ($row['category_id']) {
                                    case 1: echo "Nam"; break;
                                    case 2: echo "Nữ"; break;
                                    case 3: echo "Unisex"; break;
                                    default: echo "Không rõ"; break;
                                }
                                ?>
                            </td>
                            <td>
                                <span class="badge bg-secondary">Ẩn</span>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#restoreModal"
                                    data-id="<?= $row['product_ID'] ?>">
                                    Khôi phục
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- Modal xác nhận khôi phục -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3">
      <div class="modal-header">
        <h5 class="modal-title" id="restoreModalLabel">Xác nhận khôi phục sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn khôi phục sản phẩm này?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <a id="confirmRestoreBtn" href="#" class="btn btn-success">Khôi phục</a>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
  <div id="statusToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMessage">✔️ Thành công</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Đóng"></button>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gán product_ID cho nút khôi phục trong modal
    const restoreModal = document.getElementById('restoreModal');
    const confirmRestoreBtn = document.getElementById('confirmRestoreBtn');
    restoreModal.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        const productId = trigger.getAttribute('data-id');
        confirmRestoreBtn.href = 'restore-product.php?id=' + productId;
    });

    // Hiển thị toast nếu có success=4
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    if (success === '4') {
        document.getElementById('toastMessage').textContent = '✔️ Khôi phục sản phẩm thành công!';
        const toast = new bootstrap.Toast(document.getElementById('statusToast'), { delay: 3000 });
        toast.show();
        history.replaceState(null, "", window.location.pathname);
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
