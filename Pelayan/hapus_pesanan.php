<?php
include '../db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;

    if (is_numeric($order_id)) {
        $stmt = mysqli_prepare($conn, "DELETE FROM orders WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $order_id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'Gagal menghapus pesanan']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID tidak valid']);
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'Metode tidak diizinkan']);
exit;
