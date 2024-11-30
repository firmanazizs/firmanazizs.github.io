<?php
session_start();

// Cek apakah ada data yang dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update nomor tempat duduk
    if (isset($_POST['nomor_tempat_duduk'])) {
        $_SESSION['nomor_tempat_duduk'] = intval($_POST['nomor_tempat_duduk']);
        echo "Nomor tempat duduk berhasil diperbarui.";
    }

    // Update pesan
    if (isset($_POST['index']) && isset($_POST['pesan'])) {
        $index = intval($_POST['index']);
        $pesan = trim($_POST['pesan']);

        if (isset($_SESSION["keranjang"][$index])) {
            $_SESSION["keranjang"][$index]['pesan'] = $pesan;
            echo "Pesan berhasil diperbarui.";
        }
    }
}
?>