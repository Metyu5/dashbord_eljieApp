<?php include "header.php" ?>
<!-- sidebar -->
<?php include "sidebar.php" ?>
<!-- maincontent -->
<main class="main-content">
    <?php include "topnav.php"; ?>

    <div class="card-eljie">
        <div class="card-header-eljie">
            <div>
                <h2>Tambah Data Pengguna</h2>
                <p>Silakan lengkapi form di bawah ini untuk menambahkan pengguna baru</p>
            </div>
        </div>

        <div class="card-body-eljie">
            <form action="proses_tambah_pengguna.php" method="POST" class="form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-actions">
                    <a href="pengguna.php" class="btn btn-secondary">
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