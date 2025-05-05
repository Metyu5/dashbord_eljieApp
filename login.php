<?php
session_start();
include "config/koneksi.php";

// Validasi dan escape input untuk keamanan
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Gunakan prepared statement untuk mencegah SQL Injection
$query = "SELECT * FROM tb_admin WHERE username=? AND password=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah ada data yang cocok
if ($result->num_rows > 0) {
    // Simpan session jika login berhasil
    $_SESSION['username'] = $username;
    $_SESSION['login_success'] = "Login sebagai Admin berhasil!";
    header("Location: dashboard.php");
    exit();
} else {
    // Jika login gagal
    echo "<script>
        alert('Username atau Password salah!');
        window.location.href = 'index.php'; 
    </script>";
}
