<?php
include "config.php"; // Menghubungkan ke database
session_start();

// Mengecek apakah pengguna sudah login dan memiliki role 'user'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}

// Ambil data menu dari database
$sql = "SELECT * FROM menu";
$result = mysqli_query($conn, $sql);

// Cek apakah ada data menu
$menus = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $menus[] = $row; // Simpan setiap baris data menu ke dalam array
    }
} else {
    echo "<script>alert('Gagal mengambil data menu');</script>";
}

// Kelompokkan menu berdasarkan kategori
$grouped_menus = [];
foreach ($menus as $menu) {
    $grouped_menus[$menu['kategori']][] = $menu;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spicy+Rice&family=Poppins:ital,wght@0,400;0,500;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css"> <!-- Menggunakan style2.css -->
    <title>User Dashboard</title>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="row ai-center jc-sb nav-space">
                <div class="nav-brand">
                    <h1><a href="">Cafe-In</a></h1>
                </div>
                <div class="nav-contact">
                    <a href="keranjang.php" class="btn">
                        <div class="btn-text">
                            <span>Keranjang Anda</span><br>
                        </div>
                    </a>
                    <a href="history.php" class="btn">
                        <div class="btn-text">
                            <span>History</span>
                        </div>
                    </a>
                    <a href="https://wa.link/4lmthb" class="btn">
                        <div class="btn-text">
                            <span>Kontak Kami</span><br>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->

    <div class="hero">
        <div class="container">
            <div class="row jc-center">
                <div class="col12">
                    <img src="menu/menuhome.jpg" alt="" class="img-responsive img-radius">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="welcome-message">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>Rasakan kenikmatan di setiap sruputan!</p>
        </div>
    </div>

    <!-- Benefit Section -->
    <div class="benefit">
        <div class="container">
            <div class="row">
                <div class="col4">
                    <img src="https://cdn-icons-png.flaticon.com/128/1011/1011587.png" alt="" class="icon64">
                    <h3>MURAH!</h3>
                    <p>Hidangan nikmat, harga bersahabat.</p>
                </div>
                <div class="col4">
                    <img src="https://cdn-icons-png.flaticon.com/128/6768/6768096.png" alt="" class="icon64">
                    <h3>ENAKKK!</h3>
                    <p>Sajian istimewa untuk pelanggan tercinta.</p>
                </div>
                <div class="col4">
                    <img src="https://cdn-icons-png.flaticon.com/128/2918/2918224.png" alt="" class="icon64">
                    <h3>HALAL!</h3>
                    <p>Rasa juara, halal terjaga.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Benefit Section -->

    <!-- Product Section -->
    <div class="product spacer5">
        <div class="container">
            <h2 class="product-title">Aneka Menu</h2>

            <?php foreach ($grouped_menus as $kategori => $items): ?>
                <div class="category">
                    <h3><?php echo htmlspecialchars($kategori); ?></h3>
                    <div class="row">
                        <?php foreach ($items as $item): ?>
                            <div class="col3">
                                <div class="product-item">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['menu_name']); ?>" class="img-responsive">
                                    <div class="name"><p><?php echo htmlspecialchars($item['menu_name']); ?></p></div>
                                    <div class="price"><h3><?php echo number_format($item['price'], 0, ',', '.'); ?> IDR</h3></div>
                                    <a href="keranjang.php?item=<?php echo urlencode($item['menu_name']); ?>&harga=<?php echo $item['price']; ?>&jumlah=1" class="btn">+Keranjang</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- End Product Section -->

    <div class="logout-container">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="thank-you-message">
        <h2>Terima Kasih Atas Kunjungan Anda!</h2>
        <p>SOSIAL MEDIA KAMI!</p>
        <p>Instagram: <a href="https://www.instagram.com/aziz.saputraa" target="_blank">aziz.saputraa</a></p>
        <p>Facebook: <a href="https://www.facebook.com/Firman Aziz Saputra" target="_blank">Firman Aziz Saputra</a></p>
        <p>WhatsApp: 085775393164</p>
        <p>JAM OPERASIONAL!</p>
        <p>Senin-jumat, 08:00-22:00</p>
        <p>Sabtu-Minggu, 08:00-00:00</p>
        <p>Alamat: Jl. Raya Puspitek, Buaran, Kec. Pamulang, Kota Tangerang Selatan, Banten 15310</p>
    </div>

</body>
</html>