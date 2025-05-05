<?php
// hapus_pengguna.php

include "config/koneksi.php"; // koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = intval($_POST['id_user']);

    if ($id_user > 0) {
        // Delete pakai prepared statement
        $stmt = $conn->prepare("DELETE FROM tb_users WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);

        if ($stmt->execute()) {
            echo "<script>alert('Pengguna berhasil dihapus.'); window.location='pengguna.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus pengguna.'); window.location='pengguna.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('ID tidak valid.'); window.location='manajemen_pengguna.php';</script>";
    }

    $conn->close();
} else {
    // Kalau akses langsung tanpa POST
    header("Location: manajemen_pengguna.php");
    exit;
}
