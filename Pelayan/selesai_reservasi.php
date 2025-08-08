<?php
include '../db.php';

if (!isset($_POST['reservation_id'])) {
    die("ID reservasi tidak ditemukan.");
}

$reservation_id = (int)$_POST['reservation_id'];

// Cek apakah data reservasi memang ada
$cek = mysqli_query($conn, "SELECT id FROM reservations WHERE id = $reservation_id");
if (!$cek || mysqli_num_rows($cek) === 0) {
    die("Reservasi tidak valid atau sudah dihapus.");
}

// Update status menjadi 'selesai'
$query = "UPDATE reservations SET status = 'selesai' WHERE id = $reservation_id";
if (mysqli_query($conn, $query)) {
    header("Location: pelayan.php"); // atau redirect ke halaman pelayan yang kamu punya
    exit;
} else {
    die("Gagal memperbarui status: " . mysqli_error($conn));
}
