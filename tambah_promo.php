<?php
include 'config/koneksi.php';

// Pastikan koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $code = $_POST['code'];
    $type = $_POST['type'];
    $value = $_POST['value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // SQL query untuk menambahkan data promo
    $sql = "INSERT INTO tb_promo (code, type, value, start_date, end_date) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssdss", $code, $type, $value, $start_date, $end_date);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Jika berhasil, tampilkan alert dan redirect
            echo "<script>alert('Promo berhasil ditambahkan'); window.location.href='promo.php';</script>";
        } else {
            // Jika gagal, tampilkan alert error
            echo "<script>alert('Gagal menambahkan promo: " . $stmt->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal menyiapkan query: " . $conn->error . "'); window.history.back();</script>";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>


<?php include "header.php" ?>
<?php include "sidebar.php" ?>

<main class="main-content">
    <?php include "topnav.php"; ?>

    <div class="card-eljie">
        <div class="card-header-eljie">
            <div>
                <h2>Tambah Data Promo</h2>
                <p>Silakan lengkapi form di bawah ini untuk menambahkan data promo baru.</p>
            </div>
        </div>

        <div class="card-body-eljie">
            <!-- Form untuk menambah promo -->
            <form action="tambah_promo.php" method="POST" class="form">

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?= $error; ?>
                    </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="code">Kode Promo</label>
                        <input type="text" name="code" id="code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Tipe Promo</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="percentage">Persentase</option>
                            <option value="fixed">Nominal Tetap</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="value">Nilai Promo</label>
                        <input type="number" step="0.01" name="value" id="value" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Mulai Dari</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="end_date">Berakhir Sampai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="promo.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="./assets/js/dashboard.js"></script>