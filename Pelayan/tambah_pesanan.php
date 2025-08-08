<?php
include '../db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $food = trim($_POST['food']);
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

    if (!empty($food) && $qty > 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO orders (reservation_id, food, qty, status) VALUES (?, ?, ?, 'belum')");
        mysqli_stmt_bind_param($stmt, 'isi', $reservation_id, $food, $qty);
        if (mysqli_stmt_execute($stmt)) {
            $order_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);

            // ✅ Berhasil: Kirim JSON ke JS
            echo json_encode([
                'success' => true,
                'order_id' => $order_id,
                'food' => $food,
                'qty' => $qty,
                'status' => 'belum'
            ]);
            exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'Query gagal']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Data tidak valid']);
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'Invalid request method']);
exit;



