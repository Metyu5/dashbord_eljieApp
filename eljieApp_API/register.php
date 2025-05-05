<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_eljie";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari POST
$username = $_POST['username'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$password = $_POST['password']; // Password yang dimasukkan oleh pengguna

// Menggunakan prepared statement untuk menghindari SQL Injection
$stmt = $conn->prepare("INSERT INTO tb_users (username, email, password, no_hp) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password, $no_hp);

// Eksekusi query
if ($stmt->execute()) {
    echo "Registration Successful!";
} else {
    echo "Registration Failed: " . $stmt->error;  // Tampilkan error jika query gagal
}

$stmt->close();
$conn->close();
?>