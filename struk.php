<?php
session_start();
include "config.php";

$payment_method = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : 'DANA';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna';
$tanggal = date("Y-m-d H:i:s");

// Memastikan keranjang tidak kosong
if (!isset($_SESSION["keranjang"]) || empty($_SESSION["keranjang"])) {
    header("Location: keranjang.php");
    exit();
}

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Generate struk_id yang unik
$struk_id = uniqid('struk_', true);

$transaksi = [];
$bukti_pembayaran = isset($_SESSION['bukti_pembayaran']) ? $_SESSION['bukti_pembayaran'] : null;

foreach ($_SESSION["keranjang"] as $item) {
    $menu_name = $item['nama'];
    $quantity = $item['jumlah'];
    $price = $item['harga'];
    $total = $quantity * $price;
    $nomor_tempat_duduk = isset($_SESSION['nomor_tempat_duduk']) ? $_SESSION['nomor_tempat_duduk'] : null; // Perbaikan penamaan
    $pesan = isset($item['pesan']) ? $item['pesan'] : '';

    // Simpan transaksi ke dalam database
    $insert_sql = "INSERT INTO transaksi (user_id, username, menu_name, quantity, price, total, order_date, payment_method, seat_number, struk_id, pesan, bukti_pembayaran) 
                   VALUES ('$user_id', '$username', '$menu_name', '$quantity', '$price', '$total', '$tanggal', '$payment_method', '$nomor_tempat_duduk', '$struk_id', '$pesan', '$bukti_pembayaran')";

    if (mysqli_query($conn, $insert_sql)) {
        $transaksi[] = [
            'menu_name' => $menu_name,
            'quantity' => $quantity,
            'price' => $price,
            'total' => $total,
            'pesan' => $pesan
        ];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Menghapus data dari sesi setelah diproses
unset($_SESSION["keranjang"]);
unset($_SESSION["bukti_pembayaran"]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style5.css">
    <title>Struk Pembayaran DANA</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Cafe-In</h2>
            <p>Jl. Raya Puspitek, Buaran, Kec. Pamulang, Kota Tangerang Selatan, Banten 15310</p>
            <p>085775393164</p>
        </div>
        
        <div class="content">
            <p class="username"><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p class="tanggal"><strong>Tanggal:</strong> <?php echo htmlspecialchars($tanggal); ?></p>
            <p class="nomor-tempat-duduk"><strong>Nomor Tempat Duduk:</strong> <?php echo htmlspecialchars(isset($_SESSION['nomor_tempat_duduk']) ? $_SESSION['nomor_tempat_duduk'] : 'Tidak ada'); ?></p>
            <p class="pembayaran">Pembayaran Via: <strong><?php echo htmlspecialchars($payment_method); ?></strong></p>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $jumlahKeseluruhan = 0;

                foreach ($transaksi as $item) {
                    echo "
                    <tr>
                        <td>" . htmlspecialchars($item['menu_name']) . "</td>
                        <td>" . (int)$item['quantity'] . "</td>
                        <td>" . number_format($item['price'], 0, ',', '.') . " IDR</td>
                        <td>" . number_format($item['total'], 0, ',', '.') . " IDR</td>
                    </tr>";
                    $jumlahKeseluruhan += $item['total'];
                }
                ?>
                <tr>
                    <td colspan="3"><strong>Jumlah Keseluruhan</strong></td>
                    <td><strong><?php echo number_format($jumlahKeseluruhan, 0, ',', '.') . " IDR"; ?></strong></td>
                </tr>
                </tbody>
            </table>
            <hr>
            <p class="terima-kasih">Terima kasih, pesanan anda akan segera di proses!</p>
            <div class="button-container">
                <a href="user_dashboard.php" class="btn">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>