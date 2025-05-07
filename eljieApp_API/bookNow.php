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

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Ambil data dari JSON
    $username       = isset($data['username']) ? $data['username'] : null;
    $id_room        = isset($data['hotel_id']) ? $data['hotel_id'] : null;
    $kode_booking   = isset($data['booking_code']) ? $data['booking_code'] : null;
    $check_in_date  = isset($data['check_in_date']) ? $data['check_in_date'] : null;
    $check_out_date = isset($data['check_out_date']) ? $data['check_out_date'] : null;
    $total_amount   = isset($data['total_amount']) ? $data['total_amount'] : null;
    $promo_code     = isset($data['promo_code']) ? $data['promo_code'] : null;
    $booking_date   = date("Y-m-d");
    $status         = 'terpesan';

    // Validasi data wajib
    if (!$username || !$id_room || !$kode_booking || !$check_in_date || !$check_out_date || !$total_amount) {
        $response['status'] = "error";
        $response['message'] = "Data tidak lengkap!";
        echo json_encode($response);
        exit;
    }

    // Ambil ID user berdasarkan email (username)
    $sql_user = "SELECT id_user FROM tb_users WHERE username = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows === 0) {
        $response['status'] = "error";
        $response['message'] = "User tidak ditemukan!";
        echo json_encode($response);
        exit;
    }

    $row_user = $result_user->fetch_assoc();
    $id_user = $row_user['id_user'];
    $stmt_user->close();

    // Ambil id promo jika promo code ada
    $id_promo = null;
    if (!empty($promo_code)) {
        $sql_promo = "SELECT id FROM tb_promo WHERE code = ?";
        $stmt_promo = $conn->prepare($sql_promo);
        $stmt_promo->bind_param("s", $promo_code);
        $stmt_promo->execute();
        $result_promo = $stmt_promo->get_result();

        if ($row_promo = $result_promo->fetch_assoc()) {
            $id_promo = $row_promo['id'];
        }
        $stmt_promo->close();
    }

    // // Simpan ke tb_bookings
    // // Format total_amount dengan 3 angka desimal untuk tipe decimal
    // $total_amount = number_format((float)$total_amount, 0, '.', '');  // Pastikan format dengan 3 desimal

    // // Membersihkan dan memformat total_amount (menghapus karakter selain angka dan titik)
    // $total_amount = preg_replace("/[^0-9.]/", "", $total_amount);

    $sql = "INSERT INTO tb_bookings (id_user, id_room, id, kode_booking, booking_date, check_in_date, check_out_date, total_amount, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiissssds", $id_user, $id_room, $id_promo, $kode_booking, $booking_date, $check_in_date, $check_out_date, $total_amount, $status);

    if ($stmt->execute()) {
        // Ambil ID booking terakhir
        $last_id = mysqli_insert_id($conn);

        // Tambahkan ke tb_history
        $query_history = "INSERT INTO tb_history (kode_booking, id_booking) VALUES (?, ?)";
        $stmt_history = mysqli_prepare($conn, $query_history);
        mysqli_stmt_bind_param($stmt_history, "si", $kode_booking, $last_id);
        mysqli_stmt_execute($stmt_history);
        mysqli_stmt_close($stmt_history);

        // Respons sukses
        $response['status'] = "success";
        $response['message'] = "Booking berhasil disimpan!";
    } else {
        // Respons gagal
        $response['status'] = "error";
        $response['message'] = "Gagal menyimpan booking: " . $stmt->error;
    }

    $stmt->close();
} else {
    $response['status'] = "error";
    $response['message'] = "Metode request tidak valid!";
}

$conn->close();
echo json_encode($response);
?>