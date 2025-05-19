<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['admin', 'super_admin'])) {
    header("Location: /Admin/admin-login.php");
    exit;
}

// Ngăn lưu cache khi quay lại
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin VND</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/user-management.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { overflow-x: hidden; }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 70px;
            background-color: #212529;
            transition: width 0.3s;
            z-index: 1000;
        }
        .sidebar:hover { width: 230px; }
        .sidebar .nav-link {
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar .nav-link:hover { background-color: #343a40; }
        .sidebar:hover .nav-text { display: inline; }
        .nav-text { display: none; margin-left: 10px; }
        .main-content {
            margin-left: 70px;
            transition: margin-left 0.3s;
        }
        .sidebar:hover ~ .main-content { margin-left: 230px; }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-2">
    <div class="text-white text-center mb-4">
        <img src="/Admin/IMG/logo.png" alt="Logo" class="img-fluid" style="width:40px;">
        <span class="nav-text fw-bold"> Admin VND</span>
    </div>
    <ul class="nav nav-pills flex-column mb-auto">
        <li><a href="user-management.php" class="nav-link" data-bs-toggle="tooltip" title="Quản lý người dùng"><i class="bi bi-people"></i><span class="nav-text"> Quản Lý Người Dùng</span></a></li>
        <li><a href="product-management.php" class="nav-link" data-bs-toggle="tooltip" title="Quản lý sản phẩm"><i class="bi bi-box-seam"></i><span class="nav-text"> Quản Lý Sản Phẩm</span></a></li>
        <li><a href="bills-management.php" class="nav-link" data-bs-toggle="tooltip" title="Quản lý đơn hàng"><i class="bi bi-receipt"></i><span class="nav-text"> Quản Lý Đơn Hàng</span></a></li>
        <li><a href="statistics.php" class="nav-link" data-bs-toggle="tooltip" title="Xem thống kê"><i class="bi bi-graph-up"></i><span class="nav-text"> Thống Kê</span></a></li>
    </ul>

    <div class="dropdown mt-auto text-center text-white">
        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <span class="nav-text"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="adminDropdown">
            <li><h6 class="dropdown-header">Tài khoản: <?= $_SESSION['user_role'] ?></h6></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/Admin/logout.php">Đăng xuất</a></li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
  form[action*="update-product"] {
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
  form[action*="update-product"] button {
    width: 100% !important;
  }
  form[action*="edit-product"] .d-flex,
  form[action*="add-product"] .d-flex,
  form[action*="update-product"] .d-flex {
    flex-direction: column !important;
    gap: 10px;
  }
  form[action*="edit-product"] .d-flex .btn,
  form[action*="add-product"] .d-flex .btn,
  form[action*="update-product"] .d-flex .btn {
    width: 100%;
  }
}

body.sidebar-open {
  padding-left: 230px;
  transition: padding-left 0.3s ease;
}

@media (max-width: 680px) {
  body.sidebar-open {
    padding-left: 0;
  }
}

.sidebar {
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  width: 70px;
  background-color: #212529;
  transition: width 0.3s ease;
  z-index: 1000;
}
.sidebar:hover {
  width: 230px;
}
.sidebar .nav-link {
  color: white;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.sidebar .nav-link:hover {
  background-color: #343a40;
}
.sidebar:hover .nav-text {
  display: inline;
}
.nav-text {
  display: none;
  margin-left: 10px;
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

    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.addEventListener('mouseenter', () => document.body.classList.add('sidebar-open'));
        sidebar.addEventListener('mouseleave', () => document.body.classList.remove('sidebar-open'));
    }

    // Ngăn back hiển thị trang sau logout
    window.addEventListener('pageshow', function (event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
            window.location.reload();
        }
    });
});
</script>

