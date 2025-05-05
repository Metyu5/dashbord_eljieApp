<?php
include 'config/koneksi.php';

// Pastikan koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil id promo yang ingin diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data promo berdasarkan ID
    $sql = "SELECT * FROM tb_promo WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $promo = $result->fetch_assoc();
        } else {
            echo "Promo tidak ditemukan!";
            exit;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
} else {
    echo "ID promo tidak ditemukan!";
    exit;
}
?>

<?php include "header.php" ?>
<?php include "sidebar.php" ?>

<main class="main-content">
    <?php include "topnav.php"; ?> <!-- tombol menu, search, profile -->

    <div class="card-eljie">
        <div class="card-header-eljie">
            <div>
                <h2>Edit Data Promo</h2>
                <p>Silakan lengkapi form di bawah ini untuk mengedit promo</p>
            </div>
        </div>

        <div class="card-body-eljie">
            <form action="proses_edit_promo.php" method="POST" class="form">

                <input type="hidden" name="id" value="<?= $promo['id']; ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="code">Kode Promo</label>
                        <input type="text" name="code" id="code" class="form-control" value="<?= htmlspecialchars($promo['code']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Tipe Promo</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="percentage" <?= ($promo['type'] == 'percentage') ? 'selected' : ''; ?>>Percentage</option>
                            <option value="fixed" <?= ($promo['type'] == 'fixed') ? 'selected' : ''; ?>>Fixed</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="value">Nilai Promo</label>
                        <input type="number" name="value" id="value" class="form-control" value="<?= htmlspecialchars($promo['value']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Mulai Dari</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $promo['start_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Berakhir Sampai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $promo['end_date']; ?>" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="promo.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="./assets/js/dashboard.js"></script>
