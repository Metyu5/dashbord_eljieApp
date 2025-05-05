<?php
include "config/koneksi.php"; // koneksi ke database

// Ambil ID kamar dari URL
if (isset($_GET['id'])) {
    $id_room = intval($_GET['id']);

    // Ambil data kamar dari database
    $query = $conn->prepare("SELECT * FROM tb_rooms WHERE id_room = ?");
    $query->bind_param("i", $id_room);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $room = $result->fetch_assoc();
    } else {
        echo "<script>alert('Kamar tidak ditemukan.'); window.location='rooms.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID kamar tidak valid.'); window.location='rooms.php';</script>";
    exit;
}
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<main class="main-content">
    <?php include "topnav.php"; ?>

    <div class="card-eljie">
        <div class="card-header-eljie">
            <div>
                <h2>Edit Data Kamar</h2>
                <p>Silakan ubah data kamar di bawah ini</p>
            </div>
        </div>

        <div class="card-body-eljie">
            <form action="proses_edit_kamar.php" method="POST" enctype="multipart/form-data" class="form">
                <input type="hidden" name="id_room" value="<?= htmlspecialchars($room['id_room']); ?>">

                <div class="form-group">
                    <label for="room_type">Nama Kamar</label>
                    <input type="text" name="room_type" id="room_type" class="form-control" value="<?= htmlspecialchars($room['room_type']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="price">Harga</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" name="price" id="price" class="form-control" value="<?= number_format($room['price'], 2, ',', '.'); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="tersedia" <?= ($room['status'] == 'tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                        <option value="terisi" <?= ($room['status'] == 'terisi') ? 'selected' : ''; ?>>Terisi</option>
                        <option value="maintenance" <?= ($room['status'] == 'maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    <?php if ($room['foto']): ?>
                        <img id="preview-foto" src="uploads/<?php echo $room['foto']; ?>" alt="Preview Foto" style="display: block; margin-top: 10px; max-height: 150px; border-radius: 6px;">
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <a href="rooms.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="./assets/js/dashboard.js"></script>