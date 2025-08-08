<?php
include '../db.php';

// Validasi apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $harga = $_POST['harga'] ?? 0;
    $jenis = $_POST['jenis'] ?? '';
    $tersedia = $_POST['tersedia'] ?? 1;

    // Penanganan file
    $gambar = $_FILES['gambar']['name'] ?? '';
    $tmp = $_FILES['gambar']['tmp_name'] ?? '';
    $upload_dir = 'img/';
    $target = $upload_dir . basename($gambar);

    if (move_uploaded_file($tmp, $target)) {
        $query = "INSERT INTO menu (name, harga, jenis, tersedia, gambar)
                  VALUES ('$nama', $harga, '$jenis', $tersedia, '$gambar')";

        if (mysqli_query($conn, $query)) {
            header("Location: kelola_menu_makanan.php?status=sukses");
            exit;
        } else {
            echo "Gagal simpan ke DB: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload gambar.";
    }
}
?>
