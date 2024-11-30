<?php
include "config.php"; // Menghubungkan ke database
session_start();

// Memastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Mengambil semua menu dari database
$sql = "SELECT * FROM menu";
$result = mysqli_query($conn, $sql);
$menus = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $menus[] = $row;
    }
} else {
    echo "<script>alert('Gagal mengambil data menu');</script>";
}

// Menangani penghapusan menu
if (isset($_POST['delete'])) {
    $menu_id = $_POST['menu_id'];
    $delete_sql = "DELETE FROM menu WHERE id = '$menu_id'";
    mysqli_query($conn, $delete_sql);
    header('Location: edit_menu.php'); // Refresh halaman
}

// Menangani penambahan menu
if (isset($_POST['add'])) {
    $menu_name = $_POST['menu_name'];
    $price = $_POST['price'];
    $kategori = $_POST['kategori']; // Ambil kategori dari form

    // Mengunggah gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'daftar_menu/'; // Folder baru untuk menyimpan gambar
        $upload_file = $upload_dir . basename($_FILES['image']['name']);

        // Memindahkan file yang diunggah ke folder tujuan
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $insert_sql = "INSERT INTO menu (menu_name, price, image, kategori) VALUES ('$menu_name', '$price', '$upload_file', '$kategori')";
            mysqli_query($conn, $insert_sql);
            header('Location: edit_menu.php'); // Refresh halaman
        } else {
            echo "<script>alert('Gagal mengunggah gambar');</script>";
        }
    } else {
        echo "<script>alert('Pilih gambar untuk diunggah');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleA2.css"> <!-- Menggunakan styleA2.css -->
    <title>Edit Menu</title>
</head>
<body>
    <div class="header">
        <h1>Edit Menu</h1> <!-- Judul Halaman -->
        <div class="centered-button">
            <a href="admin_dashboard.php" class="btn">Kembali ke Dashboard</a> <!-- Tombol Kembali -->
        </div>
    </div>

    <div class="container">
        <h2>Tambah Menu Baru</h2>
        <form action="edit_menu.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="menu_name" placeholder="Nama Menu" required>
            <input type="number" name="price" placeholder="Harga" required>
            <input type="file" name="image" required> <!-- Input untuk mengunggah gambar -->
            <select name="kategori" required>
                <option value="">Pilih Kategori</option>
                <option value="Makanan">Makanan</option>
                <option value="Cemilan">Cemilan</option>
                <option value="Minuman">Minuman</option>
            </select>
            <button type="submit" name="add" class="btn">Tambah Menu</button>
        </form>

        <h2>Daftar Menu</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu): ?>
                <tr>
                    <td><?php echo htmlspecialchars($menu['menu_name']); ?></td>
                    <td><?php echo number_format($menu['price'], 0, ',', '.'); ?> IDR</td>
                    <td><img src="<?php echo htmlspecialchars($menu['image']); ?>" alt="Menu Image" style="max-width: 100px;"></td>
                    <td><?php echo htmlspecialchars($menu['kategori']); ?></td>
                    <td>
                        <form action="edit_menu.php" method="POST" style="display:inline;">
                            <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">
                            <button type="submit" name="delete" class="btn" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>