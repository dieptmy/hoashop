<?php
include 'includes/header.php';
require_once 'includes/db.php';

$currentRole = $_SESSION['user_role'] ?? 'user';

$errorFields = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $passwordRaw = $_POST['password'];
    $password = password_hash($passwordRaw, PASSWORD_DEFAULT);
    $fullname = $_POST['fullname'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    // Kiểm tra quyền tạo admin
    if ($currentRole !== 'super_admin' && $role === 'admin') {
        $errorFields['role'] = "Chỉ super admin mới được tạo quản trị viên.";
    }

    if (strlen($username) < 5) {
        $errorFields['username'] = "Tên tài khoản phải có ít nhất 5 ký tự.";
    } elseif (strlen($passwordRaw) < 6) {
        $errorFields['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorFields['email'] = "Địa chỉ email không hợp lệ.";
    } elseif (!preg_match('/^0[0-9]{9}$/', $number)) {
        $errorFields['number'] = "Số điện thoại không hợp lệ (phải bắt đầu bằng 0 và đủ 10 số).";
    }

    if (empty($errorFields)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? OR number = ?");
        $stmt->bind_param("sss", $username, $email, $number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['username'] === $username) {
                    $errorFields['username'] = "Tên tài khoản đã tồn tại.";
                }
                if ($row['email'] === $email) {
                    $errorFields['email'] = "Email đã tồn tại.";
                }
                if ($row['number'] === $number) {
                    $errorFields['number'] = "Số điện thoại đã tồn tại.";
                }
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, number, email, address, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $username, $password, $fullname, $number, $email, $address, $role, $status);
            if ($stmt->execute()) {
                header('Location: user-management.php?success=1');
                exit;
            } else {
                $errorFields['other'] = "Lỗi khi thêm người dùng: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<div class="container my-5">
    <div class="card shadow rounded-4 mx-auto" style="max-width: 720px;">
        <div class="card-body p-4">
            <h4 class="mb-4 text-center"><i class="bi bi-person-plus"></i> Thêm Người Dùng Mới</h4>

            <form method="post">
                <?php if (isset($errorFields['other'])): ?>
                    <div class="alert alert-danger"><?= $errorFields['other'] ?></div>
                <?php endif; ?>

                <?php
                function formField($label, $name, $type = 'text') {
                    global $errorFields;
                    $value = htmlspecialchars($_POST[$name] ?? '');
                    $invalid = isset($errorFields[$name]) ? 'is-invalid' : '';
                    $error = $errorFields[$name] ?? '';
                    echo "<div class='mb-3'>
                            <label class='form-label'>$label</label>
                            <input type='$type' name='$name' class='form-control $invalid' value='$value'>
                            <div class='text-danger small'>$error</div>
                          </div>";
                }

                function formSelect($label, $name, $options) {
                    global $errorFields;
                    $selected = $_POST[$name] ?? '';
                    $invalid = isset($errorFields[$name]) ? 'is-invalid' : '';
                    $error = $errorFields[$name] ?? '';
                    echo "<div class='mb-3'>
                            <label class='form-label'>$label</label>
                            <select name='$name' class='form-select $invalid'>";
                    foreach ($options as $value => $text) {
                        $isSel = $value === $selected ? 'selected' : '';
                        echo "<option value='$value' $isSel>$text</option>";
                    }
                    echo "</select>
                          <div class='text-danger small'>$error</div>
                          </div>";
                }

                formField("Tài khoản", "username");
                formField("Mật khẩu", "password", "password");
                formField("Họ tên", "fullname");
                formField("SĐT", "number");
                formField("Email", "email", "email");

                echo "<div class='mb-3'>
                        <label class='form-label'>Địa chỉ</label>
                        <textarea name='address' class='form-control " . (isset($errorFields['address']) ? 'is-invalid' : '') . "'>" . htmlspecialchars($_POST['address'] ?? '') . "</textarea>
                        <div class='text-danger small'>" . ($errorFields['address'] ?? '') . "</div>
                      </div>";

                $roleOptions = ["user" => "Người dùng"];
                if ($currentRole === 'super_admin') {
                    $roleOptions = ["admin" => "Quản trị viên"] + $roleOptions;
                }
                formSelect("Vai trò", "role", $roleOptions);
                formSelect("Trạng thái", "status", ["active" => "Đang hoạt động", "lock" => "Đã bị khóa"]);
                ?>

                <div class="d-flex justify-content-between mt-4">
                    <a href="user-management.php" class="btn btn-secondary">🔙 Quay lại</a>
                    <button type="submit" class="btn btn-accent">➕ Thêm Người Dùng</button>
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
  .card-body form {
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
  .card-body form button {
    width: 100% !important;
  }
  .card-body form .d-flex {
    flex-direction: column !important;
    gap: 10px;
  }
  .card-body form .d-flex .btn {
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
