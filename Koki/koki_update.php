<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['order_id'];
    $status = $_POST['status'];

    if (in_array($status, ['diproses', 'selesai'])) {
        mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE id = $id");
    }
}

header("Location: koki.php");
exit;
