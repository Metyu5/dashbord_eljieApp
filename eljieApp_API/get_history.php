<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_eljie";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');

$username = $_GET['username'] ?? null;

if (!$username) {
    echo json_encode(['success' => false, 'message' => 'Username tidak ditemukan']);
    exit;
}

// Ambil id_user dari username dengan prepared statement
$stmt = $conn->prepare("SELECT id_user FROM tb_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User  tidak ditemukan']);
    exit;
}

$id_user = $user['id_user'];

// Ambil history pemesanan dan detail kamar (tanpa pembulatan total_amount)
$query = "
    SELECT h.id_history, h.kode_booking, h.created_at,
           b.id_bookings AS id_booking,
           b.booking_date, b.check_in_date, b.check_out_date, 
           b.total_amount, b.status,
           r.room_type, r.price, r.foto
    FROM tb_history h
    JOIN tb_bookings b ON h.id_booking = b.id_bookings
    JOIN tb_rooms r ON b.id_room = r.id_room
    WHERE b.id_user = ? AND b.status != 'dibatalkan'  -- Tambahkan kondisi ini
    ORDER BY h.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Pastikan total_amount dikirim sebagai float (tanpa pembulatan)
        $row['total_amount'] = (float) $row['total_amount'];
        $data[] = $row;
    }

    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal ambil data: ' . $conn->error]);
}

// Tutup koneksi
$conn->close();
?>