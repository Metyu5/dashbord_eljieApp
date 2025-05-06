<?php
require_once 'config/koneksi.php';

// Set timezone ke WITA (Asia/Makassar)
date_default_timezone_set('Asia/Makassar');

$query = "SELECT h.id_history, 
                 h.kode_booking, 
                 u.username AS user, 
                 r.room_type AS room, 
                 p.code AS promo, 
                 b.booking_date, 
                 b.check_in_date, 
                 b.check_out_date, 
                 b.total_amount, 
                 b.status
          FROM tb_history h
          LEFT JOIN tb_bookings b ON h.id_booking = b.id_bookings
          LEFT JOIN tb_users u ON b.id_user = u.id_user
          LEFT JOIN tb_rooms r ON b.id_room = r.id_room
          LEFT JOIN tb_promo p ON b.id = p.id"; // Perbaikan pada bagian join untuk promo

$result = mysqli_query($conn, $query);

// Convert logo path and encode
$logoPath = str_replace('\\', '/', 'C:/laragon/www/eljie_app/assets/images/logohotel.png');
$logoData = '';
$logoSrc = '';

if (file_exists($logoPath)) {
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoMime = mime_content_type($logoPath);
    $logoSrc = 'data:' . $logoMime . ';base64,' . $logoData;
}

// Hotel information
$hotelAddress = 'Jl. Jend. Sudirman No.99, Wumialo, Kec. Kota Tengah, Kabupaten Gorontalo, Gorontalo 96128';
$hotelPhone = '(0435) 828279';

$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hotel Eljie - Laporan Pemesanan</title>
    <style>
        @page { 
            margin: 25px 20px;
            header: html_header;
            footer: html_footer;
        }
        body {
            font-family: "Segoe UI", "Helvetica Neue", Arial, sans-serif;
            color: #444;
            line-height: 1.5;
            font-size: 12px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #00000;
        }
        .logo-container {
            width: 80px;
            height: 80px;
            border: 1px solid #eee;
            border-radius: 4px;
            padding: 5px;
            margin-right: 20px;
        }
        .logo {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .header-text {
            text-align: center;
            flex-grow: 1;
        }
        .hotel-name {
            color: #2c3e50;
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .hotel-address {
            color: #7f8c8d;
            margin: 5px 0;
            font-size: 14px;
            font-style: italic;
        }
        .date-badge {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            display: inline-block;
        }
        .report-title {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 4px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }
        .report-title h2 {
            color: #2c3e50;
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 11px;
            background-color: #f5f5f5;
            padding: 8px 12px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 8px 12px;
            font-weight: 500;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            padding: 8px 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .amount {
            font-weight: 600;
            color: #2e7d32;
        }
        .footer-content {
            font-size: 10px;
            color: #777;
            text-align: center;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        .address {
            font-style: italic;
            margin-top: 3px;
        }
    </style>
</head>
<body>

    <!-- Header for all pages -->
    <htmlpageheader name="header">
        <div class="header">
            <div class="logo-container">';
$html .= ($logoSrc != '') ? '<img src="' . $logoSrc . '" class="logo">' : 'LOGO';
$html .= '</div>
            <div class="header-text">
                <h1 class="hotel-name">HOTEL ELJIE SYARIAH</h1>
                <div class="hotel-address">' . $hotelAddress . '</div>
                <div class="date-badge">Dicetak: ' . date('d/m/Y H:i') . '</div>
            </div>
        </div>
    </htmlpageheader>

    <!-- Title Section -->
    <div class="report-title">
        <h2>LAPORAN RIWAYAT PEMESANAN KAMAR</h2>
    </div>

    <!-- Meta Information -->
    <div class="meta-info">
        <div><strong>Total Data:</strong> ' . mysqli_num_rows($result) . ' records</div>
        <div><strong>Periode:</strong> Semua Data</div>
        <div><strong>User:</strong> Sistem</div>
    </div>

    <!-- Table Section -->
    <table>
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="12%">Kode Booking</th>
                <th width="15%">Atas Nama</th>
                <th width="12%">Tipe Kamar</th>
                <th width="10%">Promo</th>
                <th width="12%">Tanggal Pesan</th>
                <th width="12%">Check-In</th>
                <th width="12%">Check-Out</th>
                <th width="10%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;  // Mulai penghitung ID dari 1
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '
            <tr>
                <td>' . $no++ . '</td>
                <td>' . $row['kode_booking'] . '</td>
                <td>' . $row['user'] . '</td>
                <td>' . $row['room'] . '</td>
                <td class="text-center">' . (!empty($row['promo']) ? $row['promo'] : '-') . '</td>
                <td>' . date('d/m/Y', strtotime($row['booking_date'])) . '</td>
                <td>' . date('d/m/Y', strtotime($row['check_in_date'])) . '</td>
                <td>' . date('d/m/Y', strtotime($row['check_out_date'])) . '</td>
                <td class="text-right amount">Rp ' . number_format($row['total_amount'], 3, ',', '.') . '</td>
            </tr>';
    }
} else {
    $html .= '
            <tr>
                <td colspan="9" class="text-center">Tidak ada data pemesanan</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf([
    'chroot' => 'C:/laragon/www/eljie_app',
    'isRemoteEnabled' => true,
    'isHtml5ParserEnabled' => true,
    'defaultFont' => 'helvetica'
]);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');

$dompdf->render();

$filename = "Laporan_Pemesanan_Hotel_Eljie_" . date('Ymd_His') . ".pdf";
$dompdf->stream($filename, [
    "Attachment" => true,
    "compress" => true
]);
?>