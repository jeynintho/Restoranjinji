<?php
include '../db.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$harga = $_POST['harga'];
$jenis = $_POST['jenis'];
$tersedia = $_POST['tersedia'];

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

if ($gambar != '') {
    $path = 'img/' . $gambar;
    move_uploaded_file($tmp, '../Admin/' . $path);

    $sql = "UPDATE menu SET name='$nama', harga='$harga', jenis='$jenis', tersedia='$tersedia', gambar='$gambar' WHERE id='$id'";
} else {
    $sql = "UPDATE menu SET name='$nama', harga='$harga', jenis='$jenis', tersedia='$tersedia' WHERE id='$id'";
}

mysqli_query($conn, $sql);

header('Location: kelola_menu_makanan.php');
