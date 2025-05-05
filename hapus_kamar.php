<?php
// hapus_kamar.php

include "config/koneksi.php"; // koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil id_room dari POST
    $id_room = intval($_POST['id_room']);

    if ($id_room > 0) {
        // Delete pakai prepared statement
        $stmt = $conn->prepare("DELETE FROM tb_rooms WHERE id_room = ?");
        $stmt->bind_param("i", $id_room);

        if ($stmt->execute()) {
            // Menghapus berhasil, redirect dengan pesan sukses
            echo "<script>alert('Kamar berhasil dihapus.'); window.location='rooms.php?status=success';</script>";
        } else {
            // Gagal menghapus, tampilkan pesan error
            echo "<script>alert('Gagal menghapus kamar.'); window.location='rooms.php';</script>";
        }

        // Menutup statement
        $stmt->close();
    } else {
        // ID tidak valid
        echo "<script>alert('ID kamar tidak valid.'); window.location='rooms.kamar.php';</script>";
    }

    // Menutup koneksi
    $conn->close();
} else {
    // Jika ada akses langsung tanpa POST
    header("Location: rooms.php");
    exit;
}
