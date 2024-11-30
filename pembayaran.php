<?php
session_start();
include "config.php"; // Menghubungkan ke database

// Cek apakah keranjang ada
if (!isset($_SESSION["keranjang"]) || empty($_SESSION["keranjang"])) {
    header("Location: keranjang.php"); // Kembali ke keranjang jika kosong
    exit();
}

// Hitung total harga dari keranjang
$totalHarga = 0;
foreach ($_SESSION["keranjang"] as $item) {
    $totalHarga += $item['harga'] * $item['jumlah']; // Hitung total harga
}

// Proses unggah foto jika ada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['bukti_pembayaran'])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["bukti_pembayaran"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Cek apakah file gambar adalah gambar yang valid
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["bukti_pembayaran"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }
    }

    // Cek jika file sudah ada
    if (file_exists($targetFile)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Hanya izinkan format gambar tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Jika semuanya baik-baik saja, coba unggah file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $targetFile)) {
            // Simpan nama file untuk digunakan nanti
            $_SESSION['bukti_pembayaran'] = $targetFile;
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css"> <!-- Menggunakan style4.css -->
    <title>Pembayaran DANA</title>
</head>
<body>
    <div class="header">
        <h1>Pembayaran DANA</h1>
        <a href="keranjang.php" class="btn">Kembali ke Keranjang</a>
    </div>

    <div class="container">
        <h2>Total Pembayaran: <?php echo number_format($totalHarga, 0, ',', '.'); ?> IDR</h2>
        <p>Silakan lakukan pembayaran ke nomor DANA:</p>
        <h3><strong>085775393164</strong></h3>

        <p>Setelah melakukan pembayaran, silakan unggah bukti pembayaran:</p>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="bukti_pembayaran" required>
            <button type="submit" class="bayar-btn">Unggah Bukti Pembayaran</button>
        </form>

        <?php if (isset($_SESSION['bukti_pembayaran'])): ?>
            <p>Foto Bukti Pembayaran:</p>
            <img src="<?php echo $_SESSION['bukti_pembayaran']; ?>" alt="Bukti Pembayaran" style="max-width: 200px; margin-top: 10px;">
        <?php endif; ?>

        <p>Setelah melakukan pembayaran, silakan klik tombol di bawah untuk konfirmasi.</p>

        <form action="struk.php" method="POST">
            <input type="hidden" name="total_harga" value="<?php echo $totalHarga; ?>">
            <input type="hidden" name="metode_pembayaran" value="DANA">
            <input type="hidden" name="bukti_pembayaran" value="<?php echo isset($_SESSION['bukti_pembayaran']) ? $_SESSION['bukti_pembayaran'] : ''; ?>">

            <button type="submit" class="bayar-btn" <?php echo !isset($_SESSION['bukti_pembayaran']) ? 'disabled' : ''; ?>>Konfirmasi Pembayaran</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Nama Perusahaan. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>