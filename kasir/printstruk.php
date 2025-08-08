<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $table_number = $_POST['table_number'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $status_meja = mysqli_real_escape_string($conn, $_POST['status_meja']);
    $reservation_id = $_POST['reservation_id'];
    $total = $_POST['total'];
    $uang_bayar = $_POST['uang_bayar'];
    $metode = mysqli_real_escape_string($conn, $_POST['metode']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $kembalian = $uang_bayar - $total;
    $waktu_bayar = date('Y-m-d H:i:s');

    // Simpan pembayaran
    $insert1 = mysqli_query($conn, "INSERT INTO pembayaran 
        (nama, reservation_id, total, uang_bayar, kembalian, metode, keterangan, waktu_bayar) 
        VALUES ('$nama', $reservation_id, $total, $uang_bayar, $kembalian, '$metode', '$keterangan', '$waktu_bayar')");

    // Simpan riwayat
    $insert2 = mysqli_query($conn, "INSERT INTO riwayat 
        (nama, reservation_id, total, uang_bayar, kembalian, metode, waktu_selesai, table_number, reservation_date, reservation_time, status_meja) 
        VALUES ('$nama', $reservation_id, $total, $uang_bayar, $kembalian, '$metode', '$waktu_bayar', '$table_number', '$reservation_date', '$reservation_time', '$status_meja')");

    // Hapus pesanan dari orders
    $hapus_orders = mysqli_query($conn, "DELETE FROM orders WHERE reservation_id = $reservation_id");

    // Kosongkan reservasi
    $reset_reservasi = mysqli_query($conn, "
        UPDATE reservations 
        SET status_meja = 'selesai'
        WHERE id = $reservation_id
    ");

    if (!($insert1 && $insert2 && $hapus_orders && $reset_reservasi)) {
        echo "Gagal menyimpan pembayaran.";
        exit();
    }
} else {
    header('Location: kasir.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Pembayaran</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    @media print { .btn-struk { display: none; } }
  </style>
</head>
<body onload="window.print()">

<div class="receipt">
  <h2>Restaurant Jinji</h2>
  <p>Jl. Merdeka No. 123, Jakarta</p>
  <p>Telp: 021-12345678</p>
  <hr>

  <div class="info">
    <p>No. Struk: <?= rand(100000, 999999) ?></p>
    <p>Tanggal: <?= date('d-m-Y H:i') ?></p>
    <p>Kasir: Andi</p>
    <p>Meja: <?= $table_number ?></p>
    <p>Nama: <?= htmlspecialchars($nama) ?></p>
  </div>

  <hr>

  <table>
    <thead>
      <tr>
        <th>Item</th><th>Qty</th><th>Harga</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Total Pesanan</td><td>1</td><td>Rp<?= number_format($total, 0, ',', '.') ?></td></tr>
    </tbody>
  </table>

  <hr>

  <div class="summary">
    <p>Sub Total: <span>Rp<?= number_format($total, 0, ',', '.') ?></span></p>
    <p>PPN 10%: <span>Rp<?= number_format($total * 0.10, 0, ',', '.') ?></span></p>
    <p class="total">Total Bayar: <span>Rp<?= number_format($total * 1.10, 0, ',', '.') ?></span></p>
    <p>Uang Bayar: <span>Rp<?= number_format($uang_bayar, 0, ',', '.') ?></span></p>
    <p>Kembali: <span>Rp<?= number_format($uang_bayar - ($total * 1.10), 0, ',', '.') ?></span></p>
    <p>Metode: <span><?= $metode ?></span></p>
    <p>Keterangan: <span><?= $keterangan ?: '-' ?></span></p>
  </div>

  <hr>

  <p class="thanks">Terima kasih atas kunjungan Anda!</p>
  <p class="footer">Struk ini adalah bukti pembayaran yang sah</p>
</div>

<div class="btn-struk">
  <a href="kasir.php"><button class="kembali">Kembali</button></a>
</div>

</body>
</html>
