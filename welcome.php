<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Dapatkan peran pengguna dari session
$role = $_SESSION['role'];

// Arahkan berdasarkan peran
if ($role == 'admin') {
    header("Location: admin_dashboard.php");
} else {
    header("Location: user_dashboard.php");
}
exit();
?>