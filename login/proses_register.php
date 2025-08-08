<?php
include '../db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validasi
    if ($password != $confirm_password) {
        echo "<script>alert('Password tidak sama!'); window.history.back();</script>";
        exit();
    }

    // Cek apakah username sudah dipakai
    $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($checkUser) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.history.back();</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan user ke database
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', '$role')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>
