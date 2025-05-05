<?php
include "config/koneksi.php";

// Ambil data dari form
$id_user = $_POST['id_user'];
$id_room = $_POST['id_room'];
$id_promo = !empty($_POST['id']) ? $_POST['id'] : null;
$booking_date = $_POST['booking_date'];
$check_in_date = $_POST['check_in_date'];
$check_out_date = $_POST['check_out_date'];
$total_amount = $_POST['total_amount'];
$status = 'terpesan'; // status default

// Validasi sederhana
if (!$id_user || !$id_room || !$booking_date || !$check_in_date || !$check_out_date || !$total_amount) {
    echo "<script>alert('Semua data wajib diisi.'); window.location='tambah_bookings.php';</script>";
    exit;
}

// Membersihkan dan memformat total_amount (menghapus karakter selain angka dan titik)
$total_amount = preg_replace("/[^0-9.]/", "", $total_amount);

// Pastikan total_amount adalah float
$total_amount = (float) $total_amount;

// Generate kode booking otomatis
$result_kode = mysqli_query($conn, "SELECT MAX(RIGHT(kode_booking, 3)) AS max_kode FROM tb_bookings");
$row_kode = mysqli_fetch_assoc($result_kode);
$next_number = $row_kode['max_kode'] ? (int)$row_kode['max_kode'] + 1 : 1;
$kode_booking = 'KB' . str_pad($next_number, 3, '0', STR_PAD_LEFT);

// Simpan ke tb_bookings (dengan kolom status)
$query = "INSERT INTO tb_bookings (id_user, id_room, id, kode_booking, booking_date, check_in_date, check_out_date, total_amount, status)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "iiissssds", $id_user, $id_room, $id_promo, $kode_booking, $booking_date, $check_in_date, $check_out_date, $total_amount, $status);

if (mysqli_stmt_execute($stmt)) {
    // Ambil ID booking terakhir
    $last_id = mysqli_insert_id($conn);

    // Tambahkan ke tb_history
    $query_history = "INSERT INTO tb_history (kode_booking, id_booking) VALUES (?, ?)";
    $stmt_history = mysqli_prepare($conn, $query_history);
    mysqli_stmt_bind_param($stmt_history, "si", $kode_booking, $last_id);
    mysqli_stmt_execute($stmt_history);
    mysqli_stmt_close($stmt_history);

    echo "<script>alert('Data booking berhasil ditambahkan.'); window.location='bookings.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan data booking.'); window.location='tambah_bookings.php';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>