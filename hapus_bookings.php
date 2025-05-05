<?php
// hapus_kamar.php

include "config/koneksi.php"; // koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil id_room dari POST
    $id_bookings = intval($_POST['id_bookings']);

    if ($id_bookings > 0) {
        // Delete pakai prepared statement
        $stmt = $conn->prepare("DELETE FROM tb_bookings WHERE id_bookings = ?");
        $stmt->bind_param("i", $id_bookings);

        if ($stmt->execute()) {
            // Menghapus berhasil, redirect dengan pesan sukses
            echo "<script>alert('Data Booking berhasil dihapus.'); window.location='bookings.php?status=success';</script>";
        } else {
            // Gagal menghapus, tampilkan pesan error
            echo "<script>alert('Gagal menghapus Data Booking.'); window.location='bookings.php';</script>";
        }

        // Menutup statement
        $stmt->close();
    } else {
        // ID tidak valid
        echo "<script>alert('ID kamar tidak valid.'); window.location='bookings.kamar.php';</script>";
    }

    // Menutup koneksi
    $conn->close();
} else {
    // Jika ada akses langsung tanpa POST
    header("Location: bookings.php");
    exit;
}
