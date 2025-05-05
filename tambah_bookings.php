<?php
include "header.php"; // Menyertakan header
include "sidebar.php"; // Menyertakan sidebar
include "config/koneksi.php"; // Koneksi ke database 
?>

<main class="main-content">
    <?php include "topnav.php"; ?> <!-- Menyertakan navbar atas -->

    <div class="card-eljie">
        <div class="card-header-eljie">
            <div>
                <h2>Tambah Data Booking</h2>
                <p>Silakan lengkapi form di bawah ini untuk menambahkan data pemesanan baru.</p>
            </div>
        </div>

        <div class="card-body-eljie">
            <!-- Form untuk menambah booking -->
            <form action="proses_tambah_bookings.php" method="POST" class="form">

                <!-- Dropdown untuk memilih User -->
                <div class="form-group">
                    <label for="id_user">User</label>
                    <select name="id_user" id="id_user" class="form-control" required>
                        <option value="">-- Pilih User --</option>
                        <?php
                        $users = mysqli_query($conn, "SELECT id_user, username FROM tb_users");
                        while ($user = mysqli_fetch_assoc($users)) {
                            echo "<option value='{$user['id_user']}'>{$user['username']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Dropdown untuk memilih Kamar -->
                <div class="form-group">
                    <label for="id_room">Kamar</label>
                    <select name="id_room" id="id_room" class="form-control" required>
                        <option value="">-- Pilih Kamar --</option>
                        <?php
                        $rooms = mysqli_query($conn, "SELECT id_room, room_type, price FROM tb_rooms WHERE status = 'tersedia'");
                        while ($room = mysqli_fetch_assoc($rooms)) {
                            echo "<option value='{$room['id_room']}' data-price='{$room['price']}'>{$room['room_type']} - Rp. {$room['price']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Tanggal booking, check-in, check-out -->
                <div class="form-group">
                    <label for="booking_date">Tanggal Booking</label>
                    <input type="date" name="booking_date" id="booking_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="check_in_date">Tanggal Check-In</label>
                    <input type="date" name="check_in_date" id="check_in_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="check_out_date">Tanggal Check-Out</label>
                    <input type="date" name="check_out_date" id="check_out_date" class="form-control" required>
                </div>

                <!-- Promo dan Total Pembayaran -->
                <div class="form-group">
                    <label for="id">Promo (Opsional)</label>
                    <select name="id" id="id" class="form-control">
                        <option value="">-- Tanpa Promo --</option>
                        <?php
                        $promos = mysqli_query($conn, "SELECT id, code, type, value FROM tb_promo WHERE CURDATE() BETWEEN start_date AND end_date");
                        while ($promo = mysqli_fetch_assoc($promos)) {
                            $label = ($promo['type'] == 'percentage')
                                ? "{$promo['code']} - {$promo['value']}%"
                                : "{$promo['code']} - Rp. {$promo['value']}";
                            echo "<option value='{$promo['id']}' data-type='{$promo['type']}' data-value='{$promo['value']}'>{$label}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="total_amount">Total Pembayaran</label>
                    <div class="input-prefix">
                        <span class="prefix">Rp.</span>
                        <input type="number" step="0.001" name="total_amount" id="total_amount" class="form-control with-prefix" required readonly>
                    </div>
                </div>

                <!-- Tombol untuk aksi simpan atau batal -->
                <div class="form-actions">
                    <a href="bookings.php" class="btn btn-secondary">
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

<!-- JavaScript untuk update Total Pembayaran berdasarkan harga kamar dan promo -->
<script>
    document.getElementById('id_room').addEventListener('change', updateTotal);
    document.getElementById('id').addEventListener('change', updateTotal);

    function updateTotal() {
        var roomSelect = document.getElementById('id_room');
        var promoSelect = document.getElementById('id');
        var price = roomSelect.options[roomSelect.selectedIndex].getAttribute('data-price');
        var promoType = promoSelect.options[promoSelect.selectedIndex].getAttribute('data-type');
        var promoValue = promoSelect.options[promoSelect.selectedIndex].getAttribute('data-value');
        var totalAmountField = document.getElementById('total_amount');

        if (price) {
            var totalAmount = parseFloat(price);

            // Jika ada promo yang dipilih, hitung diskon
            if (promoType && promoValue) {
                if (promoType === 'percentage') {
                    totalAmount -= totalAmount * (parseFloat(promoValue) / 100); // Diskon dalam persen
                } else {
                    totalAmount -= parseFloat(promoValue); // Diskon dalam nominal tetap
                }
            }

            // Update total amount field
            totalAmountField.value = totalAmount.toFixed(3); // Menampilkan 3 angka di belakang koma
        } else {
            totalAmountField.value = ''; // Jika tidak ada kamar yang dipilih, kosongkan
        }
    }
</script>