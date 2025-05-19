<?php
require_once dirname( __FILE__ ) . '/../config/db.php';
include 'includes/header.php';

$currentRole = $_SESSION['user_role'] ?? 'user';
$currentUserId = $_SESSION['user_id'] ?? 0;

$errorFields = [];
$userID = intval($_GET['id'] ?? 0);

// Không cho admin hoặc super_admin chỉnh sửa chính mình
if (($currentRole === 'admin' || $currentRole === 'super_admin') && $userID === $currentUserId) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Bạn không được phép chỉnh sửa tài khoản của chính mình.</div></div>";
    include 'includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    if ($currentRole !== 'super_admin' && $role === 'admin') {
        $errorFields['role'] = "Chỉ super admin mới được gán quyền quản trị viên.";
    }

    if (strlen($username) < 5) {
        $errorFields['username'] = "Tên tài khoản phải có ít nhất 5 ký tự.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorFields['email'] = "Địa chỉ email không hợp lệ.";
    } elseif (!preg_match('/^0[0-9]{9}$/', $number)) {
        $errorFields['number'] = "Số điện thoại không hợp lệ (phải bắt đầu bằng 0 và đủ 10 số).";
    } else {
        $check = $conn->prepare("SELECT * FROM users WHERE (username = ? OR email = ? OR number = ?) AND id != ?");
        $check->bind_param("sssi", $username, $email, $number, $userID);
        $check->execute();
        $res = $check->get_result();
        while ($dup = $res->fetch_assoc()) {
            if ($dup['username'] === $username) {
                $errorFields['username'] = "Tên tài khoản đã tồn tại.";
            }
            if ($dup['email'] === $email) {
                $errorFields['email'] = "Email đã tồn tại.";
            }
            if ($dup['number'] === $number) {
                $errorFields['number'] = "Số điện thoại đã tồn tại.";
            }
        }
        $check->close();

        if (empty($errorFields)) {
            $update = $conn->prepare("UPDATE users SET username=?, fullname=?, number=?, email=?, address=?, role=?, status=? WHERE id=?");
            $update->bind_param("sssssssi", $username, $fullname, $number, $email, $address, $role, $status, $userID);
            if ($update->execute()) {
                $_SESSION['success'] = 'Cập nhật người dùng thành công!';
                header('Location: user-management.php?success=2');
                exit;
            } else {
                $errorFields['other'] = "Lỗi cập nhật: " . $update->error;
            }
            $update->close();
        }
    }

    $row = $_POST;
    $row['id'] = $userID;
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
}
?>

<main class="main-content flex-grow-1 p-4">
<div class="container my-5">
    <div class="card shadow rounded-4 mx-auto" style="max-width: 720px;">
        <div class="card-body p-4">
            <h4 class="mb-4 text-center"><i class="bi bi-pencil-square"></i> Sửa Thông Tin Người Dùng</h4>

            <?php if (isset($errorFields['other'])): ?>
                <div class="alert alert-danger"><?= $errorFields['other'] ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">

                <?php
                function field($label, $name, $type = 'text') {
                    global $row, $errorFields;
                    $val = htmlspecialchars($row[$name] ?? '');
                    $err = $errorFields[$name] ?? '';
                    $invalid = $err ? 'is-invalid' : '';
                    echo "<div class='mb-3'>
                        <label class='form-label'>$label</label>
                        <input type='$type' name='$name' class='form-control $invalid' value='$val'>
                        <div class='text-danger small'>$err</div>
                    </div>";
                }

                function select($label, $name, $options) {
                    global $row, $errorFields;
                    $val = $row[$name] ?? '';
                    $err = $errorFields[$name] ?? '';
                    $invalid = $err ? 'is-invalid' : '';
                    echo "<div class='mb-3'>
                        <label class='form-label'>$label</label>
                        <select name='$name' class='form-select $invalid'>";
                    foreach ($options as $v => $text) {
                        $sel = ($val === $v) ? 'selected' : '';
                        echo "<option value='$v' $sel>$text</option>";
                    }
                    echo "</select>
                        <div class='text-danger small'>$err</div>
                    </div>";
                }

                field("Tài khoản", "username");
                field("Họ tên", "fullname");
                field("Số điện thoại", "number");
                field("Email", "email", "email");

                echo "<div class='mb-3'>
                        <label class='form-label'>Địa chỉ</label>
                        <textarea name='address' class='form-control " . (isset($errorFields['address']) ? 'is-invalid' : '') . "'>" . htmlspecialchars($row['address'] ?? '') . "</textarea>
                        <div class='text-danger small'>" . ($errorFields['address'] ?? '') . "</div>
                    </div>";

                $roleOptions = ["user" => "Người dùng"];
                if ($currentRole === 'super_admin') {
                    $roleOptions = ["admin" => "Quản trị viên"] + $roleOptions;
                }
                select("Vai trò", "role", $roleOptions);
                select("Trạng thái", "status", ["active" => "Đang hoạt động", "lock" => "Đã bị khóa"]);
                ?>

                <div class="d-flex justify-content-between mt-4">
                    <a href="user-management.php" class="btn btn-secondary">🔙 Quay lại</a>
                    <button type="submit" class="btn btn-accent">💾 Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'includes/footer.php'; ?>
