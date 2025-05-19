<?php
include 'includes/header.php';
require_once dirname( __FILE__ ) . '/../config/db.php';

$id = $_GET['id'] ?? 0;

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

// Lấy danh sách thể tích và giá tương ứng
$volumeStmt = $conn->prepare("
    SELECT v.id, v.value, vp.price
    FROM volume v
    LEFT JOIN volume_product vp ON vp.volume_id = v.id AND vp.product_id = ?
");
$volumeStmt->bind_param("i", $id);
$volumeStmt->execute();
$volumeResult = $volumeStmt->get_result();
$volumes = $volumeResult->fetch_all(MYSQLI_ASSOC);
$volumeStmt->close();

$categoryQuery = $conn->query("SELECT * FROM category ORDER BY id ASC");
$categories = $categoryQuery->fetch_all(MYSQLI_ASSOC);
?>

<div class="container py-5">
    <div class="card shadow rounded-4">
        <div class="card-body p-4">
            <h1 class="mb-4">Chỉnh sửa sản phẩm</h1>
            <form action="update-product.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-select">
                            <?php foreach($categories as $category) {
                                $selected = $category['id'] == $product['category_id'] ? 'selected': '';
                                echo ' <option '.$selected.' value="' .  $category['id'] .'">' . $category['name']. '</option>';
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= $product['status'] == 'active' ? 'selected' : '' ?>>Hiển thị</option>
                            <option value="hidden" <?= $product['status'] == 'hidden' ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Ảnh mới (tối đa 2)</label>
                        <input type="file" name="product_images[]" class="form-control" multiple accept="image/*" onchange="previewImages(event)">

                        <div id="old-image" class="mt-3">
                            <div>Ảnh hiện tại:</div>
                            <?php
                                $imagePath = !empty($product['image_urf']) 
                                    ? '/app/' . ltrim($product['image_urf'], '/')
                                    : '/app/images/no-image.jpg';
                            ?>
                            <img src="<?= htmlspecialchars($imagePath) ?>" width="150" class="rounded mt-2">
                        </div>

                        <div id="preview-container" class="mt-3 d-flex flex-wrap gap-3"></div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Giá theo thể tích (ml)</label>
                        <div class="row g-3">
                            <?php foreach ($volumes as $volume): ?>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><?= $volume['value'] ?>ml</span>
                                        <input type="number" name="volume_price[<?= $volume['id'] ?>]" class="form-control" placeholder="Giá" min="0"
                                            value="<?= $volume['price'] ?? '' ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between">
                        <a href="product-management.php" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-accent">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImages(event) {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';

    const oldImage = document.getElementById('old-image');
    if (oldImage) {
        oldImage.style.display = 'none';
    }

    const files = event.target.files;
    if (files.length > 2) {
        alert("Vui lòng chọn tối đa 2 ảnh.");
        event.target.value = "";
        return;
    }

    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('rounded');
            img.style.width = '150px';
            img.style.height = '150px';
            img.style.objectFit = 'cover';
            container.appendChild(img);
        };
        reader.readAsDataURL(files[i]);
    }
}
</script>

<style>
/* Nguyên bản y như file bạn gửi */
@media (max-width: 1000px) {
  table thead { display: none; }
  table tr { display: block; margin-bottom: 16px; border: 1px solid #dee2e6; border-radius: 12px; padding: 16px; background-color: #ffffff; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05); }
  table td { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; font-size: 14px; border: none; border-bottom: 1px solid #eee; position: relative; }
  table td:last-child { border-bottom: none; }
  table td::before { content: attr(data-label); font-weight: 600; color: #555; flex: 1; text-align: left; }
}
@media (max-width: 680px) {
  .sidebar { transform: translateX(-100%); transition: transform 0.3s ease-in-out; position: absolute; z-index: 999; }
  .sidebar:hover { transform: translateX(0); }
  .sidebar .nav-icon { display: block; padding: 1rem; text-align: center; }
  .sidebar .nav-label { display: none; }
  .sidebar a { display: block; }
  .filter-form, form.row.g-2, .card-body > form, .card-body form, form[action*="edit-product"], form[action*="add-product"], form[action*="update-product"] { flex-direction: column !important; gap: 10px; }
  .filter-form select, .filter-form input, .filter-form button, form.row.g-2 .form-control, form.row.g-2 button, .card-body form .form-control, .card-body form .form-select, .card-body form button, form[action*="edit-product"] .form-control, form[action*="edit-product"] .form-select, form[action*="edit-product"] button, form[action*="add-product"] .form-control, form[action*="add-product"] .form-select, form[action*="add-product"] button, form[action*="update-product"] .form-control, form[action*="update-product"] .form-select, form[action*="update-product"] button { width: 100% !important; }
  form[action*="edit-product"] .d-flex, form[action*="add-product"] .d-flex, form[action*="update-product"] .d-flex { flex-direction: column !important; gap: 10px; }
  form[action*="edit-product"] .d-flex .btn, form[action*="add-product"] .d-flex .btn, form[action*="update-product"] .d-flex .btn { width: 100%; }
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
