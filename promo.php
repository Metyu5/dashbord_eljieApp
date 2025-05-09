<?php
include 'config/koneksi.php';
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Pagination Setup
$perPage = 5;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

// Total data promo
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_promo");
$totalRows = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRows / $perPage);

// Ambil data promo sesuai halaman
$sql = "SELECT * FROM tb_promo ORDER BY id DESC LIMIT $offset, $perPage";
$query = mysqli_query($conn, $sql);
if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}
$counter = $offset + 1;

// Hitung rentang halaman yang akan ditampilkan (maksimal 5)
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
                <h2>Manajemen Data Promo</h2>
                <p>Data Promo dan detailnya</p>
            </div>
            <a href="tambah_promo.php" class="btn-add-gajah">
                <i class="fas fa-plus"></i> Tambah Promo
            </a>
        </div>

        <div class="card-body-panda">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Promo</th>
                        <th>Tipe Promo</th>
                        <th>Nilai Promo</th>
                        <th>Mulai Dari</th>
                        <th>Berakhir sampai</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?= sprintf("%02d", $counter++); ?></td> <!-- Format nomor urut dengan 2 digit -->
                            <td><?= htmlspecialchars($row['code']); ?></td>
                            <td><?= htmlspecialchars($row['type']); ?></td>
                            <td>
                                <?php
                                if ($row['type'] == 'percentage') {
                                    echo $row['value'] . '%';
                                } else {
                                    echo 'Rp. ' . number_format($row['value'], 0, ',', '.');
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['start_date']); ?></td>
                            <td><?= htmlspecialchars($row['end_date']); ?></td>
                            <td>
                                <a href="edit_promo.php?id=<?= $row['id']; ?>" class="btn-edit-beruang"><i class="fas fa-edit"></i></a>
                                <form action="hapus_promo.php" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus promo ini?');">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
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

<script src="./assets/js/dashboard.js"></script>