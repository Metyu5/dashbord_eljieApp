<?php include "header.php" ?>
<!-- sidebar -->
<?php include "sidebar.php" ?>
<main class="main-content">
    <?php include "topnav.php"; ?> <!-- tombol menu, search, profile -->
    <div class="card-eljie">
        <div class="card-header-eljie">
            <div>
                <h2>Tambah Data Kamar</h2>
                <p>Silakan lengkapi form di bawah ini untuk menambahkan data kamar</p>
            </div>
        </div>

        <div class="card-body-eljie">
            <form action="proses_tambah_kamar.php" method="POST" class="form" enctype="multipart/form-data">

                <div class="form-row">
                    <div class="form-group">
                        <label for="room_type">Nama Kamar</label>
                        <input type="text" name="room_type" id="room_type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Harga</label>
                        <div class="input-prefix">
                            <span class="prefix">Rp.</span>
                            <input type="number" step="0.01" name="price" id="price" class="form-control with-prefix" required>
                        </div>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                        <img id="preview-foto" src="#" alt="Preview Foto" style="display: none; margin-top: 10px; max-height: 150px; border-radius: 6px;">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="terisi">Terisi</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>
<!-- 
                <div class="form-row">
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                        <img id="preview-foto" src="#" alt="Preview Foto" style="display: none; margin-top: 10px; max-height: 150px; border-radius: 6px;">
                    </div>
                </div> -->

                <div class="form-actions">
                    <a href="rooms.php" class="btn btn-secondary">
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