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

// SQL query untuk mengambil semua data dari tabel tb_rooms
$sql = "SELECT * FROM tb_rooms";
$result = $conn->query($sql);

// Membuat array untuk menampung hasil data
$rooms = array();

// Jika ada data, masukkan ke array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row; // Menambah hasil ke array
    }
}

// Menutup koneksi
$conn->close();

// Menampilkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($rooms);
?>