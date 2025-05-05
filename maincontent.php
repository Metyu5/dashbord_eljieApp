<?php
include "config/koneksi.php";

// Mengambil total jumlah pengguna
$result = $conn->query("SELECT COUNT(*) AS id_user FROM tb_users");
$row = $result->fetch_assoc();
$id_user = $row['id_user'];

// Mengambil total jumlah kamar yang tersedia (status 'tersedia')
$result_rooms = $conn->query("SELECT COUNT(*) AS available_rooms FROM tb_rooms WHERE status = 'tersedia'");
$row_rooms = $result_rooms->fetch_assoc();
$available_rooms = $row_rooms['available_rooms'];

// Mengambil total jumlah booking
$result_bookings = $conn->query("SELECT COUNT(*) AS total_bookings FROM tb_bookings");
$row_bookings = $result_bookings->fetch_assoc();
$total_bookings = $row_bookings['total_bookings'];

// Mengambil total jumlah riwayat pemesanan dari tb_history
$result_history = $conn->query("SELECT COUNT(*) AS total_history FROM tb_history");
$row_history = $result_history->fetch_assoc();
$total_history = $row_history['total_history'];
?>
<!-- Main Content -->
<!-- Content -->
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h1>Dashboard Administrator</h1>
            <p>Welcome back!.</p>
        </div>
    </div>
    <!-- Stats Cards -->
    <div class="cards-grid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Total Bookings</h3>
                <div class="card-icon blue">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <h2 class="card-value"><?= htmlspecialchars($total_bookings); ?></h2>
            <div class="card-footer positive">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Total Pengguna</h3>
                <div class="card-icon green">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <h2 class="card-value"><?= htmlspecialchars($id_user); ?></h2>
            <div class="card-footer positive">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Available Rooms</h3>
                <div class="card-icon orange">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
            <h2 class="card-value"><?= htmlspecialchars($available_rooms); ?></h2>
            <div class="card-footer negative">
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Total History Pemesanan</h3>
                <div class="card-icon red">
                    <i class="fas fa-history"></i>
                </div>
            </div>
            <h2 class="card-value"><?= htmlspecialchars($total_history); ?></h2>
            <div class="card-footer positive">
            </div>
        </div>
    </div>
</div>