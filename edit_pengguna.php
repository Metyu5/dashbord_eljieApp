<?php
include "config/koneksi.php"; // koneksi ke database

// Ambil ID user dari URL
if (isset($_GET['id'])) {
    $id_user = intval($_GET['id']);

    // Ambil data user dari database
    $query = $conn->prepare("SELECT * FROM tb_users WHERE id_user = ?");
    $query->bind_param("i", $id_user);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('Pengguna tidak ditemukan.'); window.location='pengguna.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID pengguna tidak valid.'); window.location='pengguna.php';</script>";
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
                <h2>Edit Data Pengguna</h2>
                <p>Silakan ubah data pengguna di bawah ini</p>
            </div>
        </div>

        <div class="card-body-eljie">
            <form action="proses_edit_pengguna.php" method="POST" class="form">
                <input type="hidden" name="id_user" value="<?= htmlspecialchars($user['id_user']); ?>">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= htmlspecialchars($user['no_hp']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-actions">
                    <a href="pengguna.php" class="btn btn-secondary">
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