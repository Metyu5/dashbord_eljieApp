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

$email = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input sederhana
if (empty($email) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "Email dan password wajib diisi"
    ]);
    exit;
}

// Gunakan prepared statement
$stmt = $conn->prepare("SELECT id_user, username, email, no_hp FROM tb_users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "message" => "Login Berhasil!",
        "id_user" => $user['id_user'],         // Tambahkan id_user
        "username" => $user['username'],
        "email" => $user['email'],
        "no_hp" => $user['no_hp']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Login Gagal: Periksa email/password."
    ]);
}

$conn->close();
?>