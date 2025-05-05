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

$email = $_POST['username'];  // Menggunakan email sebagai username
$password = $_POST['password'];  // Password yang dimasukkan oleh pengguna

// Query untuk mengecek apakah email dan password valid
$sql = "SELECT * FROM tb_users WHERE email = '$email' AND password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Login Berhasil!";
} else {
    echo "Login Gagal: Periksa email/password.";
}

$conn->close();
