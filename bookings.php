<?php
session_start();
include "config/koneksi.php"; // Pastikan koneksi ke database

// Setup Pagination
$perPage = 5; // Jumlah item per halaman
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // Halaman saat ini
$offset = ($page - 1) * $perPage; // Offset untuk pagination

// Query untuk menghitung jumlah total data bookings
$totalQuery = "SELECT COUNT(*) AS total FROM tb_bookings";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRows = mysqli_fetch_assoc($totalResult)['total']; // Total baris untuk pagination
$totalPages = ceil($totalRows / $perPage); // Total halaman

// Hitung rentang halaman yang akan ditampilkan (maksimal 5)
$range = 5; // Rentang maksimal untuk link pagination
$startPage = max(1, $page - floor($range / 2));
$endPage = min($totalPages, $startPage + $range - 1);
if ($endPage - $startPage + 1 < $range) {
    $startPage = max(1, $endPage - $range + 1);
}

// Query untuk mengambil data booking dengan JOIN ke tb_users, tb_rooms, dan tb_promo
$query = "SELECT b.id_bookings, u.username AS user, r.room_type AS room, p.code AS promo, 
                 b.booking_date, b.check_in_date, b.check_out_date, b.total_amount, b.status
          FROM tb_bookings b
          LEFT JOIN tb_users u ON b.id_user = u.id_user
          LEFT JOIN tb_rooms r ON b.id_room = r.id_room
          LEFT JOIN tb_promo p ON b.id = p.id
          LIMIT $offset, $perPage"; // Terapkan limit dan offset untuk pagination
$result = mysqli_query($conn, $query);
?>

<?php include "header.php" ?>
<!-- sidebar -->
<?php include "sidebar.php" ?>
<!-- maincontent -->
<main class="main-content">
    <?php include "topnav.php"; ?> <!-- khusus tombol menu, search, profile -->

    <div class="card-kucing">
        <div class="card-header-singa">
            <div>
                <h2>Manajemen Data Reservation</h2>
                <p>Daftar kamar beserta datanya</p>
            </div>
            <a href="tambah_bookings.php" class="btn-add-gajah">
                <i class="fas fa-plus"></i> Tambah Bookings
            </a>
        </div>

        <div class="card-body-panda">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>Tipe Kamar</th>
                        <th>Kode Promo</th>
                        <th>Tanggal Booking</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $counter = $offset + 1; // Mulai dari nomor urut yang sesuai dengan halaman
                        while ($row = mysqli_fetch_assoc($result)) {
                            $promo = $row['promo'] ? $row['promo'] : "Tidak Menggunakan";

                            // Badge status warna (optional)
                            $status_label = ucfirst($row['status']);
                            $badge_class = '';
                            if ($row['status'] == 'terpesan') {
                                $badge_class = 'badge-green';
                            } elseif ($row['status'] == 'dibatalkan') {
                                $badge_class = 'badge-red';
                            } elseif ($row['status'] == 'selesai') {
                                $badge_class = 'badge-blue';
                            }

                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>"; // Gunakan $counter untuk nomor urut
                            echo "<td>" . $row['user'] . "</td>";
                            echo "<td>" . $row['room'] . "</td>";
                            echo "<td>" . $promo . "</td>";
                            echo "<td>" . $row['booking_date'] . "</td>";
                            echo "<td>" . $row['check_in_date'] . "</td>";
                            echo "<td>" . $row['check_out_date'] . "</td>";
                            echo "<td>Rp " . number_format($row['total_amount'], 0, ',', '.') . "</td>";
                            echo "<td><span class='$badge_class'>$status_label</span></td>";
                            echo "<td>
                                    <a href='edit_bookings.php?id={$row['id_bookings']}' class='btn-edit-beruang' title='Edit'>
                                        <i class='fas fa-edit'></i>
                                    </a>";

                            // Tampilkan tombol BATALKAN jika status masih "terpesan"
                            if ($row['status'] == 'terpesan') {
                                echo "<form action='batal_booking.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Yakin ingin membatalkan booking ini?\");'>
                                        <input type='hidden' name='id_bookings' value='{$row['id_bookings']}'>
                                        <button type='submit' class='btn-delete-kuda' title='Batalkan Booking'>
                                            <i class='fas fa-times-circle'></i>
                                        </button>
                                      </form>";
                            }

                            // Tombol hapus masih bisa ditampilkan (jika kamu tetap izinkan penghapusan manual)
                            echo "<form action='hapus_bookings.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Yakin ingin menghapus booking ini?\");'>
                                    <input type='hidden' name='id_bookings' value='{$row['id_bookings']}'>
                                    <button type='submit' class='btn-delete-kuda' title='Hapus Permanen'>
                                        <i class='fas fa-trash'></i>
                                    </button>
                                  </form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Belum Ada Pemesanan Kamar.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

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