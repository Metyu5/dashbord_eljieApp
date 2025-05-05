<?php
include "config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_bookings'])) {
    $id_bookings = $_POST['id_bookings'];

    // Update status jadi 'dibatalkan'
    $query = "UPDATE tb_bookings SET status = 'dibatalkan' WHERE id_bookings = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_bookings);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Booking berhasil dibatalkan.'); window.location='bookings.php';</script>";
    } else {
        echo "<script>alert('Gagal membatalkan booking.'); window.location='bookings.php';</script>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Permintaan tidak valid.'); window.location='bookings.php';</script>";
}

mysqli_close($conn);
?>