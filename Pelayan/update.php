<?php
include '../db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $qty = $_POST['qty'] ?? null;

    if (is_numeric($order_id) && is_numeric($qty)) {
        $stmt = mysqli_prepare($conn, "UPDATE orders SET qty = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'ii', $qty, $order_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Gagal eksekusi query']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'error' => 'Input tidak valid']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Bukan metode POST']);
exit;
?>
