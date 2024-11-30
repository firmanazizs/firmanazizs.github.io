<?php
session_start();
include "config.php";

// Memastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Mengambil semua transaksi dan mengurutkannya berdasarkan user_id dan struk_id
$transaksi_sql = "SELECT * FROM transaksi ORDER BY user_id, struk_id";
$transaksi_result = mysqli_query($conn, $transaksi_sql);

// Penanganan kesalahan jika query gagal
if (!$transaksi_result) {
    die("Error fetching transactions: " . mysqli_error($conn));
}

$transaksi = [];

// Mengisi array transaksi
while ($row = mysqli_fetch_assoc($transaksi_result)) {
    $transaksi[] = $row;
}

// Mengelompokkan transaksi berdasarkan user_id dan struk_id
$grouped_transaksi = [];
foreach ($transaksi as $item) {
    $grouped_transaksi[$item['user_id']][$item['struk_id']][] = $item;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleA.css">
    <title>Data Transaksi - Admin</title>
</head>
<body>
    <div class="header">
        <h1>Cafe-In Admin</h1>
        <div class="nav-contact">
            <a href="logout.php" class="btn">Logout</a>
            <a href="edit_menu.php" class="btn">Edit Menu</a> <!-- Tombol Edit Menu -->
        </div>
    </div>

    <div class="container">
        <h2>Data Transaksi</h2>
        <?php foreach ($grouped_transaksi as $user_id => $user_transaksi): ?>
            <?php foreach ($user_transaksi as $struk_id => $items): ?>
                <div class="struk-container">
                    <h3>
                        User ID: <?php echo htmlspecialchars($user_id); ?><br>
                        Struk ID: <?php echo htmlspecialchars($struk_id); ?><br>
                        Nama: <?php echo htmlspecialchars($items[0]['username'] ?? 'Tidak Diketahui'); ?><br>
                        Nomor Tempat Duduk: <?php echo htmlspecialchars($items[0]['seat_number'] ?? 'Tidak Ada'); ?>
                    </h3>
                    <div class="bukti-container">
                        <?php if (!empty($items[0]['bukti_pembayaran'])): ?>
                            <p><strong>Bukti Pembayaran:</strong></p>
                            <img src="<?php echo htmlspecialchars($items[0]['bukti_pembayaran']); ?>" alt="Bukti Pembayaran" style="max-width: 200px;">
                        <?php else: ?>
                            <p><strong>Tidak ada bukti pembayaran.</strong></p>
                        <?php endif; ?>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Menu</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Pesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $jumlahKeseluruhan = 0;
                                foreach ($items as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['menu_name']); ?></td>
                                        <td><?php echo (int)$item['quantity']; ?></td>
                                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> IDR</td>
                                        <td><?php echo number_format($item['total'], 0, ',', '.'); ?> IDR</td>
                                        <td><?php echo htmlspecialchars($item['pesan']); ?></td>
                                    </tr>
                                    <?php $jumlahKeseluruhan += $item['total']; ?>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3"><strong>Jumlah Keseluruhan</strong></td>
                                    <td><strong><?php echo number_format($jumlahKeseluruhan, 0, ',', '.') . " IDR"; ?></strong></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form action='hapus_struk.php' method='POST'>
                        <input type='hidden' name='struk_id' value='<?php echo htmlspecialchars($struk_id); ?>'>
                        <button type='submit' class='btn' onclick="return confirm('Apakah Anda yakin ingin menghapus struk ini? Semua item dalam struk ini akan dihapus.');">Hapus Struk</button>
                    </form>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</body>
</html>