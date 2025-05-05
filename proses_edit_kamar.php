<?php
include 'config/koneksi.php'; // Koneksi ke database

// Cek apakah form sudah disubmit dan ID kamar tersedia
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_room'])) {
    // Ambil data dari form
    $id_room = $_POST['id_room'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Validasi harga agar tidak ada simbol Rp
    $price = str_replace(['Rp', '.', ' '], '', $price); // Menghapus simbol dan spasi pada harga

    // Menangani upload foto (jika ada)
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_path = "";  // Menyimpan path foto baru

    // Jika ada file foto yang di-upload, proses foto tersebut
    if ($foto_name) {
        // Tentukan path foto baru
        $foto_path = "uploads/" . basename($foto_name);

        // Pindahkan file foto ke direktori upload
        if (!move_uploaded_file($foto_tmp, $foto_path)) {
            echo "<script>alert('Upload foto gagal.'); window.history.back();</script>";
            exit;
        }
    } else {
        // Jika tidak ada foto yang di-upload, gunakan foto lama (jika ada)
        $query = $conn->prepare("SELECT foto FROM tb_rooms WHERE id_room = ?");
        $query->bind_param("i", $id_room);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $foto_path = $row['foto']; // Gunakan foto lama jika tidak ada upload baru
        }
    }

    // Query untuk update data kamar
    $query = "UPDATE tb_rooms SET room_type = ?, price = ?, status = ?, foto = ?, updated_at = CURRENT_TIMESTAMP WHERE id_room = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdssi", $room_type, $price, $status, $foto_path, $id_room);

    if ($stmt->execute()) {
        echo "<script>alert('Data kamar berhasil diperbarui'); window.location.href='rooms.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data kamar: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Data tidak valid.'); window.location.href='rooms.php';</script>";
}

$conn->close();
