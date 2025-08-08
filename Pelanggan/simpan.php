<?php
include '../db.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$table = (int)($_POST['table_number'] ?? 0);
$guest = (int)($_POST['guest_count'] ?? 0);
$date = $_POST['reservation_date'] ?? '';
$time = $_POST['reservation_time'] ?? '';

// Validasi dasar
if (!$name || !$email || !$table || !$guest || !$date || !$time) {
    header("Location: reservasi.php?error=Isi semua field.");
    exit();
}

// Validasi tanggal tidak boleh lewat
if (strtotime($date) < strtotime(date('Y-m-d'))) {
    header("Location: reservasi.php?error=Tidak bisa reservasi ke tanggal yang sudah lewat.");
    exit();
}

// Validasi kapasitas meja
$kapasitasQ = mysqli_query($conn, "SELECT capacity FROM tables WHERE id = $table");
$meja = mysqli_fetch_assoc($kapasitasQ);
if (!$meja) {
    header("Location: reservasi.php?error=Meja tidak ditemukan.");
    exit();
}
if ($guest > $meja['capacity']) {
    header("Location: reservasi.php?error=Jumlah tamu melebihi kapasitas meja.");
    exit();
}

// Cek apakah meja sudah terisi pada waktu tersebut dan belum selesai
$cek = mysqli_query($conn, "SELECT * FROM reservations 
    WHERE table_number = $table 
    AND reservation_date = '$date' 
    AND reservation_time = '$time'
    AND status_meja != 'selesai'");
    
if (mysqli_num_rows($cek) > 0) {
    header("Location: reservasi.php?tanggal=$date&error=Meja sudah dipesan pada waktu tersebut.");
    exit();
}

// Simpan reservasi
$name = mysqli_real_escape_string($conn, $name);
$email = mysqli_real_escape_string($conn, $email);

$query = "INSERT INTO reservations 
          (name, email, table_number, reservation_date, reservation_time, guest_count, status, status_meja)
          VALUES ('$name', '$email', $table, '$date', '$time', $guest, 'belum', 'belum selesai')";

if (mysqli_query($conn, $query)) {
    header("Location: reservasi.php?success=1&tanggal=$date");
} else {
    header("Location: reservasi.php?error=Gagal menyimpan reservasi.");
}
?>
