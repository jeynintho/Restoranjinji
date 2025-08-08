<?php
include 'db.php';

$id_reservasi = $_POST['reservation_id'];
$total_harga = $_POST['total_harga'];
$uang_bayar = $_POST['uang_bayar'];
$keterangan = $_POST['keterangan'];

$kembalian = $uang_bayar - $total_harga;

// Simpan ke tabel pembayaran
mysqli_query($conn, "INSERT INTO pembayaran (reservation_id, total_harga, uang_bayar, kembalian, keterangan)
                     VALUES ($id_reservasi, $total_harga, $uang_bayar, $kembalian, '$keterangan')");

// Simpan juga ke riwayat
mysqli_query($conn, "INSERT INTO riwayat (reservation_id, total_bayar, tanggal_bayar, metode)
                     VALUES ($id_reservasi, $total_harga, NOW(), '$keterangan')");

// Redirect atau tampilkan pesan
header("Location: kasir.php?status=success");
?>
