<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_eljie";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Koneksi ke database gagal"
    ]));
}

// Ambil data dari request
$id_user = $_POST['id_user'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];

// Query untuk memperbarui data pengguna
$sql = "UPDATE tb_users SET username=?, password=?, email=?, no_hp=? WHERE id_user=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $username, $password, $email, $no_hp, $id_user);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Profile updated successfully"]);
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "Failed to update profile", 
        "error" => $stmt->error
    ]);
}


$stmt->close();
$conn->close();
?>