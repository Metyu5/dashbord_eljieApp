<?php
include 'config/koneksi.php';

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Pagination Setup
$perPage = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Hitung total data
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_rooms");
$totalRows = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRows / $perPage);

// Ambil data kamar sesuai halaman
$sql = "SELECT id_room, room_type, price, status, updated_at, foto 
        FROM tb_rooms 
        ORDER BY id_room DESC 
        LIMIT $offset, $perPage";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$counter = $offset + 1;

// Hitung halaman untuk tampilan 5 tombol
$range = 5;
$startPage = max(1, $page - floor($range / 2));
$endPage = min($totalPages, $startPage + $range - 1);
if ($endPage - $startPage + 1 < $range) {
    $startPage = max(1, $endPage - $range + 1);
}
?>

<?php include "header.php" ?>
<?php include "sidebar.php" ?>
<main class="main-content">
    <?php include "topnav.php"; ?>

    <div class="card-kucing">
        <div class="card-header-singa">
            <div>
                <h2>Manajemen Data Kamar</h2>
                <p>Daftar kamar beserta datanya</p>
            </div>
            <a href="tambah_kamar.php" class="btn-add-gajah">
                <i class="fas fa-plus"></i> Tambah Kamar
            </a>
        </div>

        <!-- Alert jika berhasil -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <?php endif; ?>

        <div class="card-body-panda">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Terakhir Diupdate</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?>
                        <?php
                        $statusClass = '';
                        $statusText = ucfirst($row['status']);
                        if ($statusText == 'Maintenance') {
                            $statusClass = 'badge-maintenance';
                        } elseif ($statusText == 'Tersedia') {
                            $statusClass = 'badge-available';
                        } elseif ($statusText == 'Terisi') {
                            $statusClass = 'badge-occupied';
                        } else {
                            $statusClass = 'badge-default';
                        }
                        ?>
                        <tr>
                            <td><?php echo str_pad($counter++, 2, '0', STR_PAD_LEFT); ?></td>
                            <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                            <td>Rp <?php echo number_format($row['price'], 3, ',', '.'); ?></td>
                            <td><span class="badge-ular <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($row['updated_at'])); ?></td>
                            <td>
                                <img src="uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="Foto Kamar" style="width: 50px; height: auto;">
                            </td>
                            <td>
                                <a href="edit_kamar.php?id=<?= $row['id_room']; ?>" class="btn-edit-beruang"><i class="fas fa-edit"></i></a>
                                <form action="hapus_kamar.php" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kamar ini?');">
                                    <input type="hidden" name="id_room" value="<?= $row['id_room']; ?>">
                                    <button type="submit" class="btn-delete-kuda"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer Pagination -->
        <div class="card-footer-burung">
            <div>Menampilkan <?php echo $offset + 1; ?> sampai <?php echo min($offset + $perPage, $totalRows); ?> dari <?php echo $totalRows; ?> entri</div>
            <div class="pagination-kucing">
                <!-- Tombol Sebelumnya -->
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="btn-page-singa">Sebelumnya</a>
                <?php else: ?>
                    <button class="btn-page-singa disabled">Sebelumnya</button>
                <?php endif; ?>

                <!-- Nomor Halaman -->
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

<script src="./assets/js/dashboard.js"></script>