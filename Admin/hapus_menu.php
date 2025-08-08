<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file gambar terlebih dahulu
    $queryGambar = "SELECT gambar FROM menu WHERE id = ?";
    $stmtGambar = mysqli_prepare($conn, $queryGambar);
    mysqli_stmt_bind_param($stmtGambar, 'i', $id);
    mysqli_stmt_execute($stmtGambar);
    mysqli_stmt_bind_result($stmtGambar, $gambar);
    mysqli_stmt_fetch($stmtGambar);
    mysqli_stmt_close($stmtGambar);

    // Hapus data dari database
    $query = "DELETE FROM menu WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Jika ada gambar dan bukan gambar default, hapus dari folder
        if ($gambar && $gambar !== 'default.jpg') {
            $gambarPath = 'img/' . $gambar;
            if (file_exists($gambarPath)) {
                unlink($gambarPath); // Hapus file
            }
        }

        header("Location: kelola_menu_makanan.php?hapus=berhasil");
        exit;
    } else {
        echo "Gagal menghapus data.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "ID tidak ditemukan.";
}
?>
