<?php
// Konfigurasi Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_eljie";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Set header untuk output JSON
header('Content-Type: application/json');

// Ambil ID booking dari POST atau GET (GET hanya untuk pengujian via browser)
$booking_id = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_bookings'])) {
    $booking_id = $_POST['id_bookings'];
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_bookings'])) {
    $booking_id = $_GET['id_bookings'];
}

if ($booking_id && is_numeric($booking_id)) {
    // Query: update hanya jika status bukan 'dibatalkan'
    $sql = "UPDATE tb_bookings SET status='dibatalkan' WHERE id_bookings=? AND status != 'dibatalkan'";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $booking_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(["status" => "success", "message" => "Pemesanan berhasil dibatalkan."]);
            } else {
                echo json_encode(["status" => "error", "message" => "ID pemesanan tidak ditemukan atau status sudah dibatalkan."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal mengeksekusi query."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Terjadi kesalahan saat menyiapkan query."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID pemesanan tidak valid atau tidak ditemukan."]);
}

$conn->close();
?>