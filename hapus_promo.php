<?php
// hapus_kamar.php

include "config/koneksi.php"; // koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil id_room dari POST
    $id = intval($_POST['id']);

    if ($id > 0) {
        // Delete pakai prepared statement
        $stmt = $conn->prepare("DELETE FROM tb_promo WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Menghapus berhasil, redirect dengan pesan sukses
            echo "<script>alert('Data Promo berhasil dihapus.'); window.location='promo.php?status=success';</script>";
        } else {
            // Gagal menghapus, tampilkan pesan error
            echo "<script>alert('Gagal menghapus Data Promo.'); window.location='promo.php';</script>";
        }

        // Menutup statement
        $stmt->close();
    } else {
        // ID tidak valid
        echo "<script>alert('ID kamar tidak valid.'); window.location='promo.kamar.php';</script>";
    }

    // Menutup koneksi
    $conn->close();
} else {
    // Jika ada akses langsung tanpa POST
    header("Location: promo.php");
    exit;
}
