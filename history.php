<?php
include "config.php"; // Menghubungkan ke database
session_start();

// Mengecek apakah pengguna sudah login dan memiliki role 'user'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

// Ambil data riwayat pemesanan dari database
$user_id = $_SESSION['id']; // Ambil user_id dari session
$sql = "SELECT * FROM transaksi WHERE user_id = '$user_id' ORDER BY order_date DESC"; // Mengambil riwayat berdasarkan user_id
$result = mysqli_query($conn, $sql);

// Cek apakah ada data riwayat pemesanan
$riwayat_pemesanan = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $riwayat_pemesanan[] = $row; // Simpan setiap baris data riwayat pemesanan ke dalam array
    }
} else {
    echo "<script>alert('Gagal mengambil data riwayat pemesanan');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style6.css"> <!-- Menggunakan style6.css -->
    <title>Riwayat Pemesanan</title>
</head>
<body>
    <div class="header">
        <h1>History Cafe-In</h1>
            <div class="logout-container">
            <a href="user_dashboard.php" class="logout-btn">Kembali ke Dashboard</a> <!-- Tombol kembali ke dashboard -->
        </div>
    </div>

    <div class="container">
        <h2>Hai <?php echo htmlspecialchars($_SESSION['username']); ?>, inilah riwayat pembelian kamu</h2>

        <?php if (!empty($riwayat_pemesanan)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Struk ID</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat_pemesanan as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['struk_id']); ?></td>
                            <td><?php echo htmlspecialchars($item['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($item['menu_name']); ?></td>
                            <td><?php echo (int)$item['quantity']; ?></td>
                            <td><?php echo number_format($item['total'], 0, ',', '.') . " IDR"; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada riwayat pemesanan.</p>
        <?php endif; ?>
    </div>

</body>
</html>