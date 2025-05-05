<?php
include 'config/koneksi.php'; // Pastikan koneksi database dimuat

// Ambil data dari form
$room_type = $_POST['room_type'];
$price = $_POST['price'];
$status = $_POST['status'];

// Handle upload foto
$foto_name = $_FILES['foto']['name'];
$foto_tmp = $_FILES['foto']['tmp_name'];
$foto_path = "uploads/" . basename($foto_name);

// Cek apakah file berhasil dipindahkan
if (move_uploaded_file($foto_tmp, $foto_path)) {
    // Simpan ke database
    $query = "INSERT INTO tb_rooms (room_type, price, foto, status) 
              VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdss", $room_type, $price, $foto_name, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Data kamar berhasil ditambahkan'); window.location.href='rooms.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan kamar: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Upload foto gagal'); window.history.back();</script>";
}

$conn->close();
