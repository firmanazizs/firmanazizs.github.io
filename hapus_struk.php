<?php
session_start();
include "config.php"; // Menghubungkan ke database

// Cek apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Proses penghapusan struk
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $struk_id = $_POST['struk_id'];

    $sql = "DELETE FROM transaksi WHERE struk_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $struk_id);

    if ($stmt->execute()) {
        echo "Struk berhasil dihapus!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

header('Location: admin_dashboard.php'); // Kembali ke admin dashboard setelah menghapus