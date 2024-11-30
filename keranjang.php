<?php
session_start();

// Inisialisasi keranjang
if (!isset($_SESSION["keranjang"])) {
    $_SESSION["keranjang"] = [];
}

// Menyimpan mode cara makan dalam sesi
if (!isset($_SESSION['mode'])) {
    $_SESSION['mode'] = 'dine_in'; // Set default ke Makan Di Sini
}

// Cek jika ada perubahan mode
if (isset($_POST['mode'])) {
    $_SESSION['mode'] = $_POST['mode'];
}

// Cek jika ada item yang ditambahkan
if (isset($_GET['item']) && isset($_GET['harga'])) {
    $item = $_GET['item'];
    $harga = floatval($_GET['harga']);
    $jumlah = isset($_GET['jumlah']) ? intval($_GET['jumlah']) : 1;

    // Cek apakah item sudah ada di keranjang
    $found = false;
    foreach ($_SESSION["keranjang"] as &$keranjangItem) {
        if ($keranjangItem['nama'] === $item) {
            $keranjangItem['jumlah'] = $jumlah;
            $found = true;
            break;
        }
    }

    // Jika item belum ada, tambahkan sebagai item baru
    if (!$found) {
        $_SESSION["keranjang"][] = [
            'nama' => $item,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'pesan' => ''
        ];
    }
}

// Hapus item dari keranjang
if (isset($_GET['hapus'])) {
    $index = intval($_GET['hapus']);
    unset($_SESSION["keranjang"][$index]);
}

// Ambil daftar item yang ada di keranjang
$keranjang = isset($_SESSION["keranjang"]) ? $_SESSION["keranjang"] : [];

// Hitung total harga
$totalHarga = 0;
foreach ($keranjang as $item) {
    if (is_array($item) && isset($item['harga']) && isset($item['jumlah'])) {
        $totalHarga += $item['harga'] * $item['jumlah'];
    }
}

// Cek jika mode sudah diset
$mode = $_SESSION['mode'];

// Cek jika ada perubahan nomor tempat duduk
if ($mode === 'dine_in' && isset($_POST['nomor_tempat_duduk'])) {
    $_SESSION['nomor_tempat_duduk'] = intval($_POST['nomor_tempat_duduk']);
}

// Update pesan jika ada
if (isset($_POST['index']) && isset($_POST['pesan'])) {
    $index = intval($_POST['index']);
    $pesan = trim($_POST['pesan']);

    if (isset($_SESSION["keranjang"][$index])) {
        $_SESSION["keranjang"][$index]['pesan'] = $pesan;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <title>Keranjang Anda</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Event untuk menangani perubahan pada input pesan
        $('.input-pesan').on('change', function() {
            var index = $(this).closest('form').find('input[name="index"]').val();
            var pesan = $(this).val();

            // Mengirim data menggunakan AJAX
            $.ajax({
                url: 'update_cart.php',
                type: 'POST',
                data: {
                    index: index,
                    pesan: pesan
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Event untuk menangani perubahan pada input nomor tempat duduk
        $('.input-nomor-tempat-duduk').on('change', function() {
            var nomor_tempat_duduk = $(this).val();

            // Mengirim data menggunakan AJAX
            $.ajax({
                url: 'update_cart.php',
                type: 'POST',
                data: {
                    nomor_tempat_duduk: nomor_tempat_duduk
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
    </script>
</head>
<body>
    <div class="header">
        <h1>Keranjang Anda</h1>
        <a href="user_dashboard.php" class="btn">Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <h2>Daftar Pesanan Anda</h2>

        <form method="POST" action="keranjang.php">
            <label for="mode">Pilih Cara Makan:</label>
            <select name="mode" id="mode" onchange="this.form.submit()">
                <option value="dine_in" <?php echo ($mode === 'dine_in') ? 'selected' : ''; ?>>Makan Di Sini</option>
                <option value="take_away" <?php echo ($mode === 'take_away') ? 'selected' : ''; ?>>Bawa Pulang</option>
            </select>
        </form>

        <?php if ($mode === 'dine_in'): ?>
            <table class="table-nomor-tempat-duduk">
                <tr>
                    <td>No Tempat Duduk</td>
                    <td>
                        <form method="POST" action="keranjang.php" class="nomor-tempat-duduk-form">
                            <input type="number" name="nomor_tempat_duduk" min="1" required class="input-nomor-tempat-duduk" placeholder="Masukkan Nomor Tempat Duduk">
                        </form>
                    </td>
                </tr>
            </table>
        <?php endif; ?>

        <?php if (empty($keranjang)): ?>
            <p>Keranjang Anda kosong.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Harga per Satuan</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keranjang as $index => $item): ?>
                        <tr class="table-menu-action">
                            <td><?php echo htmlspecialchars($item['nama']); ?></td>
                            <td>
                                <form action="keranjang.php" method="GET">
                                    <input type="number" name="jumlah" value="<?php echo $item['jumlah']; ?>" min="1" onchange="this.form.submit()">
                                    <input type="hidden" name="item" value="<?php echo htmlspecialchars($item['nama']); ?>">
                                    <input type="hidden" name="harga" value="<?php echo $item['harga']; ?>">
                                </form>
                            </td>
                            <td><?php echo number_format($item['harga'], 0, ',', '.'); ?> IDR</td>
                            <td><?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?> IDR</td>
                            <td>
                                <a href="keranjang.php?hapus=<?php echo $index; ?>" class="btn">Hapus</a>
                            </td>
                        </tr>
                        <tr class="table-message">
                            <td colspan="5">
                                <form class="pesan-form" method="POST">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <input type="text" name="pesan" placeholder="Pesan untuk penjual..." class="input-pesan" 
                                    value="<?php echo htmlspecialchars($item['pesan']); ?>" onchange="this.form.submit()">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Total Harga Keseluruhan: <?php echo number_format($totalHarga, 0, ',', '.'); ?> IDR</h3>

            <div class="payment-container">
                <form action="pembayaran.php" method="POST">
                    <input type="hidden" name="total_harga" value="<?php echo $totalHarga; ?>">
                    <h3>Total Pembayaran: <?php echo number_format($totalHarga, 0, ',', '.'); ?> IDR</h3>
                    <button type="submit" class="btn bayar-btn">Bayar Sekarang</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>