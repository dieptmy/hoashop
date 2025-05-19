<?php
include 'includes/header.php';
require_once dirname(__FILE__) . '/../config/db.php';

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$countSql = "SELECT COUNT(DISTINCT p.id) as total FROM products p WHERE p.status = 'active'";
$countResult = $conn->query($countSql);
$totalRow = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRow / $limit);

$sql = "
    SELECT 
        p.id AS product_ID,
        p.name AS product_name,
        p.image_urf AS image_url,
        p.status,
        MIN(vp.price) AS min_price,
        MAX(vp.price) AS max_price,
        c.name as category_name
    FROM products p
    LEFT JOIN category c ON c.id = p.category_id
    LEFT JOIN volume_product vp ON p.id = vp.product_id
    WHERE p.status = 'active'
    GROUP BY p.id
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($sql);
?>

<div class="container py-5">
    <h1 class="mb-4 text-center"><i class="bi bi-box-seam"></i> Sản phẩm đang hiển thị</h1>

    <div class="card shadow rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="add-product.php" class="btn btn-primary me-2">
                        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                    </a>
                    <a href="product-hidden.php" class="btn btn-secondary">
                        <i class="bi bi-eye-slash"></i> Sản phẩm đã ẩn
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="productTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows === 0): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    Không có sản phẩm nào đang hiển thị.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                    $imagePath = (!empty($row['image_url']))
                                        ? '/app/' . ltrim($row['image_url'], '/')
                                        : '/app/images/no-image.jpg';
                                ?>
                                <tr>
                                    <td><?= $row['product_ID'] ?></td>
                                    <td>
                                        <img src="<?= htmlspecialchars($imagePath) ?>" alt="Ảnh sản phẩm" width="80" height="80" class="rounded">
                                    </td>
                                    <td class="text-start"><?= htmlspecialchars($row['product_name']) ?></td>
                                    <td>
                                        <?= number_format($row['min_price'], 0, ',', '.') ?>đ
                                        <?php if ($row['min_price'] != $row['max_price']): ?>
                                            - <?= number_format($row['max_price'], 0, ',', '.') ?>đ
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row['category_name']?></td>
                                     <td>
                                        <span class="badge bg-success">Hiển thị</span>
                                    </td>
                                    <td>
                                        <a href="edit-product.php?id=<?= $row['product_ID'] ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal" data-id="<?= $row['product_ID'] ?>">
                                            <i class="bi bi-eye-slash-fill"></i>
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
                    <?php
                    $range = 1;
                    $start = max(1, $page - $range);
                    $end = min($totalPages, $page + $range);

                    if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">&laquo;</a></li>
                    <?php endif;

                    if ($start > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                        if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }

                    for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor;

                    if ($end < $totalPages) {
                        if ($end < $totalPages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '">' . $totalPages . '</a></li>';
                    }

                    if ($page < $totalPages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal xác nhận ẩn -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Xác nhận ẩn sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn ẩn sản phẩm này không?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <a id="confirmHideBtn" href="#" class="btn btn-danger">Ẩn</a>
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
    const rows = document.querySelectorAll('#productTable tbody tr');
    const headers = Array.from(document.querySelectorAll('#productTable thead th')).map(th => th.textContent.trim());
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, index) => {
            if (!cell.hasAttribute('data-label') && headers[index]) {
                cell.setAttribute('data-label', headers[index]);
            }
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    if (success) {
        const toastMessage = document.getElementById('toastMessage');
        if (success === '1') toastMessage.textContent = '✔️ Thêm sản phẩm thành công!';
        else if (success === '2') toastMessage.textContent = '✔️ Cập nhật sản phẩm thành công!';
        else if (success === '3') toastMessage.textContent = '✔️ Ẩn sản phẩm thành công!';
        else if (success === '4') toastMessage.textContent = '✔️ Khôi phục sản phẩm thành công!';
        else toastMessage.textContent = '✔️ Thao tác thành công!';

        const toast = new bootstrap.Toast(document.getElementById('statusToast'), { delay: 3000 });
        toast.show();
        history.replaceState(null, "", window.location.pathname);
    }

    const modal = document.getElementById('confirmModal');
    const confirmBtn = document.getElementById('confirmHideBtn');
    modal.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        const productId = trigger.getAttribute('data-id');
        confirmBtn.href = 'hidden-product.php?id=' + productId;
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
