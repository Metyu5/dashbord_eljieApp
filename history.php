<?php
session_start();
include "config/koneksi.php";

// Setup Pagination
$perPage = 5;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Hitung total data untuk pagination
$countQuery = "SELECT COUNT(*) as total FROM tb_history h
               LEFT JOIN tb_bookings b ON h.kode_booking = b.kode_booking
               LEFT JOIN tb_users u ON b.id_user = u.id_user
               LEFT JOIN tb_rooms r ON b.id_room = r.id_room
               LEFT JOIN tb_promo p ON b.id = p.id";
$totalResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalRows / $perPage);

// Hitung rentang halaman
$range = 5;
$startPage = max(1, $page - floor($range / 2));
$endPage = min($totalPages, $startPage + $range - 1);
if ($endPage - $startPage + 1 < $range) {
    $startPage = max(1, $endPage - $range + 1);
}

// Query untuk data history
$query = "SELECT h.id_history, h.kode_booking, u.username AS user, r.room_type AS room, 
                 p.code AS promo, b.booking_date, b.check_in_date, b.check_out_date, b.total_amount, b.status
          FROM tb_history h
          LEFT JOIN tb_bookings b ON h.kode_booking = b.kode_booking
          LEFT JOIN tb_users u ON b.id_user = u.id_user
          LEFT JOIN tb_rooms r ON b.id_room = r.id_room
          LEFT JOIN tb_promo p ON b.id = p.id
          LIMIT $offset, $perPage";
$result = mysqli_query($conn, $query);
?>



<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<main class="main-content">
    <?php include "topnav.php"; ?>

    <div class="card-kucing">
        <div class="card-header-singa">
            <div>
                <h2>Manajemen Data History Pemesanan</h2>
                <p>Daftar riwayat pemesanan lengkap yang tersimpan secara otomatis</p>
            </div>
            <a href="generate_pdf.php" class="btn-add-gajah">
                <i class="fas fa-print"></i> CETAK PDF
            </a>
        </div>

        <!-- TABEL DATA -->
        <table class="table-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Booking</th>
                    <th>Atas Nama</th>
                    <th>Tipe Kamar</th>
                    <th>Kode Promo</th>
                    <th>Booking Date</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Total Harga</th>
                    <th>Status</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $offset + 1;
                while ($row = mysqli_fetch_assoc($result)) :
                    // Cek apakah promo kosong atau NULL
                    $promo = $row['promo'] ? $row['promo'] : "Tidak Menggunakan";

                    // Status untuk ditampilkan
                    $status_label = ucfirst($row['status']);
                    $badge_class = '';
                    if ($row['status'] == 'terpesan') {
                        $badge_class = 'badge-green';
                    } elseif ($row['status'] == 'dibatalkan') {
                        $badge_class = 'badge-red';
                    } elseif ($row['status'] == 'selesai') {
                        $badge_class = 'badge-blue';
                    }
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['kode_booking']; ?></td>
                        <td><?php echo $row['user']; ?></td>
                        <td><?php echo $row['room']; ?></td>
                        <td><?php echo $promo; ?></td> <!-- Menampilkan kode promo atau "Tidak Menggunakan" -->
                        <td><?php echo $row['booking_date']; ?></td>
                        <td><?php echo $row['check_in_date']; ?></td>
                        <td><?php echo $row['check_out_date']; ?></td>
                        <td><?php echo "Rp. " . number_format($row['total_amount'], 3, ',', '.'); ?></td>
                        <td><span class='<?php echo $badge_class; ?>'><?php echo $status_label; ?></span></td> <!-- Status dengan badge warna -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Footer Pagination -->
        <div class="card-footer-burung">
            <div>
                Menampilkan <?= $offset + 1; ?> sampai <?= min($offset + $perPage, $totalRows); ?> dari <?= $totalRows; ?> entri
            </div>
            <div class="pagination-kucing">
                <!-- Tombol Sebelumnya -->
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="btn-page-singa">Sebelumnya</a>
                <?php else: ?>
                    <button class="btn-page-singa disabled">Sebelumnya</button>
                <?php endif; ?>

                <!-- Nomor halaman -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="?page=<?= $i ?>" class="btn-page-singa <?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>

                <!-- Tombol Selanjutnya -->
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="btn-page-singa">Selanjutnya</a>
                <?php else: ?>
                    <button class="btn-page-singa disabled">Selanjutnya</button>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-footer-panda">
            <a href="dashboard.php">
                <button class="btn-back-panda">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
            </a>
        </div>
    </div>
</main>

<!-- OPTIONAL CSS untuk badge status -->
<style>
    .badge-green {
        color: white;
        background-color: green;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .badge-red {
        color: white;
        background-color: red;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .badge-blue {
        color: white;
        background-color: dodgerblue;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>

<script src="./assets/js/dashboard.js"></script>