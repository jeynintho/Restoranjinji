<?php
include 'db.php';
$id = (int)$_GET['id'];

$q = mysqli_query($conn, "SELECT r.name, r.table_number, p.total, p.uang_bayar, p.kembalian, p.waktu_bayar
                          FROM pembayaran p
                          JOIN reservations r ON r.id = p.reservation_id
                          WHERE r.id = $id");

if (mysqli_num_rows($q) === 0) {
    die("Data tidak ditemukan.");
}

$data = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head><title>Struk Pembayaran</title></head>
<body>
    <h2>🍽 Struk Pembayaran</h2>
    <p>Nama: <?= htmlspecialchars($data['name']) ?></p>
    <p>Meja: <?= $data['table_number'] ?></p>
    <p>Total: Rp<?= number_format($data['total']) ?></p>
    <p>Uang Bayar: Rp<?= number_format($data['uang_bayar']) ?></p>
    <p>Kembalian: Rp<?= number_format($data['kembalian']) ?></p>
    <p>Waktu: <?= $data['waktu_bayar'] ?></p>
    <hr>
    <button onclick="window.print()">🖨 Cetak</button>
    <a href="kasir.php">⬅ Kembali</a>
</body>
</html>
