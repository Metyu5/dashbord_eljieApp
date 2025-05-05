<?php
session_start();
include "config/koneksi.php"; // Koneksi ke database

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data yang dikirimkan melalui form
    $id_bookings = intval($_POST['id_bookings']);
    $id_room = intval($_POST['room']);
    $id = isset($_POST['promo']) && $_POST['promo'] !== '' ? intval($_POST['promo']) : null; // Promo bisa null jika tidak dipilih
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $status = $_POST['status'];

    // Ambil harga kamar berdasarkan ID kamar
    $roomQuery = "SELECT price FROM tb_rooms WHERE id_room = ?";
    $stmt = $conn->prepare($roomQuery);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id_room);
    $stmt->execute();
    $roomResult = $stmt->get_result();

    if ($roomResult->num_rows == 1) {
        $room = $roomResult->fetch_assoc();
        $room_price = $room['price'];
    } else {
        echo "<script>alert('Kamar tidak ditemukan.'); window.location='bookings.php';</script>";
        exit;
    }

    // Jika promo dipilih, ambil informasi promo
    if ($id !== null) {
        $promoQuery = "SELECT type, value FROM tb_promo WHERE id = ?";
        $stmt = $conn->prepare($promoQuery);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $promoResult = $stmt->get_result();

        if ($promoResult->num_rows == 1) {
            $promo = $promoResult->fetch_assoc();
            $promo_type = $promo['type'];
            $promo_value = $promo['value'];

            // Hitung total amount berdasarkan promo
            if ($promo_type == 'percentage') {
                $total_amount = $room_price - ($room_price * $promo_value / 100);
            } elseif ($promo_type == 'fixed') {
                $total_amount = $room_price - $promo_value;
            } else {
                $total_amount = $room_price; // Jika promo tidak valid, tidak ada diskon
            }
        } else {
            $total_amount = $room_price; // Tidak ada promo yang valid
            $id = null; // Reset promo id jika promo invalid
        }
    } else {
        $total_amount = $room_price; // Tidak ada promo, totalnya hanya harga kamar
    }

    // Update query: dua versi, jika promo null set id_promo = NULL, jika ada set id_promo = ?
    if ($id === null) {
        // Query tanpa promo
        $updateQuery = "UPDATE tb_bookings 
                        SET id_room = ?, id = NULL, check_in_date = ?, check_out_date = ?, total_amount = ?, status = ? 
                        WHERE id_bookings = ?";
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("issdsi", $id_room, $check_in_date, $check_out_date, $total_amount, $status, $id_bookings);
    } else {
        // Query dengan promo
        $updateQuery = "UPDATE tb_bookings 
                        SET id_room = ?, id = ?, check_in_date = ?, check_out_date = ?, total_amount = ?, status = ? 
                        WHERE id_bookings = ?";
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iissdsi", $id_room, $id, $check_in_date, $check_out_date, $total_amount, $status, $id_bookings);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Data booking berhasil diperbarui.'); window.location='bookings.php';</script>";
    } else {
        $error = htmlspecialchars($stmt->error, ENT_QUOTES);
        echo "<script>alert('Gagal memperbarui data booking: $error'); window.location='edit_bookings.php?id=$id_bookings';</script>";
    }
} else {
    echo "<script>alert('Data tidak ditemukan.'); window.location='bookings.php';</script>";
}
?>