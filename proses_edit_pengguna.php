<?php
include "config/koneksi.php"; // koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = intval($_POST['id_user']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $no_hp = trim($_POST['no_hp']);
    $password = trim($_POST['password']); // Password boleh kosong

    if ($id_user > 0 && $username && $email && $no_hp) {
        if (!empty($password)) {
            // Jika password diisi, update semua
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE tb_users SET username = ?, password = ?, email = ?, no_hp = ? WHERE id_user = ?");
            $stmt->bind_param("ssssi", $username, $hashed_password, $email, $no_hp, $id_user);
        } else {
            // Jika password kosong, jangan update password
            $stmt = $conn->prepare("UPDATE tb_users SET username = ?, email = ?, no_hp = ? WHERE id_user = ?");
            $stmt->bind_param("sssi", $username, $email, $no_hp, $id_user);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Data pengguna berhasil diperbarui.'); window.location='pengguna.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data.'); window.location='pengguna.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Data tidak lengkap.'); window.location='manajemen_pengguna.php';</script>";
    }

    $conn->close();
} else {
    header("Location: manajemen_pengguna.php");
    exit;
}
?>