<?php
include 'includes/header.php';
require_once dirname( __FILE__ ) . '/../config/db.php';

$errorFields = [];

// Lấy danh sách thể tích
$volumeQuery = $conn->query("SELECT * FROM volume ORDER BY value ASC");
$volumes = $volumeQuery->fetch_all(MYSQLI_ASSOC);

$categoryQuery = $conn->query("SELECT * FROM category ORDER BY id ASC");
$categories = $categoryQuery->fetch_all(MYSQLI_ASSOC);


$typeCategories = [];
$brandCategories = [];

foreach ($categories as $category) {
    if ($category['type'] === 'type') {
        $typeCategories[] = $category;
    } elseif ($category['type'] === 'brand') {
        $brandCategories[] = $category;
    }
}


?>

<div class="container py-5">
    <div class="card shadow rounded-4">
        <div class="card-body p-4">
            <h1 class="mb-4">Thêm sản phẩm mới</h1>
            <form action="save-product.php" method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <div class="">

                            <label class="form-label d-block">Phân loại</label>
                            <?php foreach ($typeCategories as $cat): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="category_id" id="type<?= $cat['id'] ?>" value="<?= $cat['id'] ?>" required>
                                    <label class="form-check-label" for="type<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>




                    <div class="col-md-12">
                        <label class="form-label">Mô tả</label>
                        <textarea name="product_about" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select" required>
                            <option value="active">Hiển thị</option>
                            <option value="hidden">Ẩn</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Hình ảnh (chọn tối đa 2)</label>
                        <input type="file" name="product_images[]" class="form-control" multiple accept="image/*" onchange="previewImages(event)">
                        <div id="preview-container" class="mt-3 d-flex flex-wrap gap-3"></div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Giá theo thể tích (ml)</label>
                        <div class="row g-3">
                            <?php foreach ($volumes as $volume): ?>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><?= $volume['value'] ?>ml</span>
                                        <input type="number" name="volume_price[<?= $volume['id'] ?>]" class="form-control" placeholder="Giá" min="0">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <small class="text-muted">Chỉ điền giá cho những thể tích bạn muốn bán.</small>
                    </div>

                    <div class="col-12 d-flex justify-content-between">
                        <a href="product-management.php" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-accent">Lưu sản phẩm</button>
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
  form[action*="add-product"] {
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
  form[action*="add-product"] button {
    width: 100% !important;
  }
  form[action*="edit-product"] .d-flex,
  form[action*="add-product"] .d-flex {
    flex-direction: column !important;
    gap: 10px;
  }
  form[action*="edit-product"] .d-flex .btn,
  form[action*="add-product"] .d-flex .btn {
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
