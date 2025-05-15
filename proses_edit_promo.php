<?php
include 'config/koneksi.php';

// Pastikan koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek jika data POST ada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $type = $_POST['type'];
    $value = $_POST['value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Query untuk update data promo
    $sql = "UPDATE tb_promo SET code = ?, type = ?, value = ?, start_date = ?, end_date = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("ssdssi", $code, $type, $value, $start_date, $end_date, $id);

        // Eksekusi query
        if ($stmt->execute()) {
            // Jika berhasil, tampilkan alert dan redirect
            echo "<script>alert('Promo berhasil diperbarui'); window.location.href='promo.php';</script>";
        } else {
            // Jika gagal, tampilkan error
            echo "<script>alert('Gagal memperbarui promo: " . $stmt->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Gagal menyiapkan query: " . $conn->error . "'); window.history.back();</script>";
    }

    // Tutup koneksi
    $conn->close();
}
?>