<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
};
if (!isset($_SESSION['admin_logged_in']) || !in_array($_SESSION['admin_role'], ['admin', 'superadmin'])) {
    header('Location: admin-login.php');
    exit;
}
?>
