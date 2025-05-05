<?php
session_start();
include "config/koneksi.php";

// Query untuk mengambil data history dengan informasi booking lengkap
$query = "SELECT h.id_history, h.kode_booking, u.username AS user, r.room_type AS room, 
                 p.code AS promo, b.booking_date, b.check_in_date, b.check_out_date, b.total_amount, b.status
          FROM tb_history h
          LEFT JOIN tb_bookings b ON h.kode_booking = b.kode_booking
          LEFT JOIN tb_users u ON b.id_user = u.id_user
          LEFT JOIN tb_rooms r ON b.id_room = r.id_room
          LEFT JOIN tb_promo p ON b.id = p.id"; // Ganti b.id menjadi b.id_promo
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
                    <th>Status</th> <!-- Kolom status ditambahkan -->
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
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

        <div class="card-footer-burung">
            <div>Menampilkan 1 sampai <?php echo mysqli_num_rows($result); ?> dari <?php echo mysqli_num_rows($result); ?> entri</div>
            <div class="pagination-kucing">
                <button class="btn-page-singa">Sebelumnya</button>
                <button class="btn-page-singa active">1</button>
                <button class="btn-page-singa">Selanjutnya</button>
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