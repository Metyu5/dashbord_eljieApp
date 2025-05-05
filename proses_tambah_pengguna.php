<?php
// proses_tambah_pengguna.php

// Sambungkan ke database
include "config/koneksi.php"; // pastikan file koneksi.php sudah ada

// Tangkap data dari form
$username = $_POST['username'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$password = $_POST['password'];

// Hash password sebelum disimpan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Validasi sederhana (optional bisa diperluas)
if (empty($username) || empty($email) || empty($no_hp) || empty($password)) {
    echo "<script>alert('Semua field wajib diisi!'); window.location='tambah_pengguna.php';</script>";
    exit;
}

// Insert ke database menggunakan prepared statement
try {
    $stmt = $conn->prepare("INSERT INTO tb_users (username, password, email, no_hp) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashed_password, $email, $no_hp);

    if ($stmt->execute()) {
        echo "<script>alert('Pengguna berhasil ditambahkan.'); window.location='pengguna.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pengguna.'); window.location='tambah_pengguna.php';</script>";
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
