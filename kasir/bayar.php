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
    $insert = mysqli_query($conn, "INSERT INTO pembayaran 
        (nama, reservation_id, total, uang_bayar, kembalian, metode, keterangan, waktu_bayar) 
        VALUES ('$nama', $reservation_id, $total, $uang_bayar, $kembalian, '$metode', '$keterangan', '$waktu_bayar')");


    // Simpan riwayat
    $insert = mysqli_query($conn, "INSERT INTO riwayat 
        (nama, reservation_id, total, uang_bayar, kembalian, metode, waktu_selesai, table_number, reservation_date, reservation_time, status_meja) 
        VALUES ('$nama', $reservation_id, $total, $uang_bayar, $kembalian, '$metode', '$waktu_bayar', '$table_number', '$reservation_date', '$reservation_time', '$status_meja')");

    // Hapus pesanan dari orders
    $hapus_orders = mysqli_query($conn, "DELETE FROM orders WHERE reservation_id = $reservation_id");

    // Kosongkan reservasi (opsi: hapus atau reset)
    $reset_reservasi = mysqli_query($conn, "
        UPDATE reservations 
        SET status_meja = 'selesai'
        WHERE id = $reservation_id
    ");

    if ($insert && $hapus_orders && $reset_reservasi) {
        header('Location: kasir.php?success=1');
        exit();
    } else {
        echo "Terjadi kesalahan saat memproses pembayaran.";
    }
} else {
    header('Location: kasir.php');
    exit();
}
