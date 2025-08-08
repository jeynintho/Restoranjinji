<?php
session_start();
include '../db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // 🔀 Redirect sesuai role
        switch ($user['role']) {
            case 'admin':
                header("Location: ../Admin/admin.php");
                break;
            case 'kasir':
                header("Location: ../kasir/kasir.php");
                break;
            case 'pelayan':
                header("Location: ../Pelayan/pelayan.php");
                break;
            case 'koki':
                header("Location: ../Koki/koki.php");
                break;
            default:
                echo "Role tidak dikenali.";
                break;
        }
        exit;
    } else {
        echo "Password salah.";
    }
} else {
    echo "User tidak ditemukan.";
}
?>
