<?php
session_start();
include "config/koneksi.php"; // Koneksi ke database

// Cek apakah ID booking ada di URL
if (isset($_GET['id'])) {
    $id_bookings = intval($_GET['id']);

    // Query untuk mengambil data booking berdasarkan ID
    $query = "SELECT b.id_bookings, u.username AS user, r.room_type AS room, r.price AS room_price, 
                     p.id AS promo_id, p.code AS promo_code, p.type AS promo_type, p.value AS promo_value, 
                     b.booking_date, b.check_in_date, b.check_out_date, b.total_amount, b.status, b.id_room
              FROM tb_bookings b
              LEFT JOIN tb_users u ON b.id_user = u.id_user
              LEFT JOIN tb_rooms r ON b.id_room = r.id_room
              LEFT JOIN tb_promo p ON b.id = p.id
              WHERE b.id_bookings = $id_bookings";

    $result = mysqli_query($conn, $query);

    // Cek apakah booking ditemukan
    if (mysqli_num_rows($result) == 1) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Booking tidak ditemukan.'); window.location='bookings.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID Booking tidak valid.'); window.location='bookings.php';</script>";
    exit;
}

// Ambil daftar kamar dan promo
$roomQuery = "SELECT id_room, room_type, price FROM tb_rooms WHERE status = 'Tersedia'";
$roomResult = mysqli_query($conn, $roomQuery);

$promoQuery = "SELECT id, code, type, value FROM tb_promo WHERE end_date >= CURDATE()";
$promoResult = mysqli_query($conn, $promoQuery);
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<main class="main-content">
    <?php include "topnav.php"; ?>

    <div class="card-eljie">
        <div class="card-header-eljie">
            <div>
                <h2>Edit Data Booking</h2>
                <p>Silakan ubah data booking di bawah ini</p>
            </div>
        </div>

        <div class="card-body-eljie">
            <form action="proses_edit_booking.php" method="POST" class="form">
                <input type="hidden" name="id_bookings" value="<?= $booking['id_bookings']; ?>">

                <div class="form-group">
                    <label for="user">Nama Pemesan</label>
                    <input type="text" name="user" id="user" class="form-control" value="<?= htmlspecialchars($booking['user']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="room">Tipe Kamar</label>
                    <select name="room" id="room" class="form-control" onchange="updatePrice()" required>
                        <?php while ($room = mysqli_fetch_assoc($roomResult)): ?>
                            <option value="<?= $room['id_room']; ?>" data-price="<?= $room['price']; ?>"
                                <?= ($room['id_room'] == $booking['id_room']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($room['room_type']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="promo">Kode Promo</label>
                    <select name="promo" id="promo" class="form-control" onchange="updatePrice()">
                        <option value="">-- Pilih Promo --</option>
                        <?php while ($promo = mysqli_fetch_assoc($promoResult)): ?>
                            <option value="<?= $promo['id']; ?>" data-type="<?= $promo['type']; ?>"
                                data-value="<?= $promo['value']; ?>" <?= ($promo['id'] == $booking['promo_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($promo['code']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="booking_date">Tanggal Booking</label>
                    <input type="text" name="booking_date" id="booking_date" class="form-control" value="<?= htmlspecialchars($booking['booking_date']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="check_in_date">Tanggal Check-In</label>
                    <input type="date" name="check_in_date" id="check_in_date" class="form-control" value="<?= htmlspecialchars($booking['check_in_date']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="check_out_date">Tanggal Check-Out</label>
                    <input type="date" name="check_out_date" id="check_out_date" class="form-control" value="<?= htmlspecialchars($booking['check_out_date']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="total_amount">Total Pembayaran (Rp)</label>
                    <input type="text" name="total_amount" id="total_amount" class="form-control"
                        value="Rp. <?= number_format($booking['total_amount'], 0, ',', '.'); ?>" required readonly>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="terpesan" <?= ($booking['status'] == 'terpesan') ? 'selected' : ''; ?>>Terpesan</option>
                        <option value="dibatalkan" <?= ($booking['status'] == 'dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                       
                    </select>
                </div>

                <div class="form-actions">
                    <a href="bookings.php" class="btn btn-secondary">
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

<script>
    // Fungsi untuk mengupdate harga berdasarkan tipe kamar dan promo yang dipilih
    function updatePrice() {
        var roomSelect = document.getElementById("room");
        var promoSelect = document.getElementById("promo");
        var totalAmountField = document.getElementById("total_amount");

        var roomPrice = parseInt(roomSelect.options[roomSelect.selectedIndex].getAttribute("data-price"));
        var promoType = promoSelect.options[promoSelect.selectedIndex].getAttribute("data-type");
        var promoValue = parseInt(promoSelect.options[promoSelect.selectedIndex].getAttribute("data-value"));

        var totalAmount = roomPrice;

        // Menghitung total berdasarkan promo
        if (promoType && promoValue) {
            if (promoType === "percentage") {
                totalAmount -= (totalAmount * promoValue / 100);
            } else if (promoType === "fixed") {
                totalAmount -= promoValue;
            }
        }

        // Menampilkan total harga dalam format Rp.
        // Update total amount field
        totalAmountField.value = "Rp. " + parseInt (totalAmount).toFixed(3); // Menampilkan 3 angka di belakang koma

    }

    // Panggil fungsi updatePrice saat halaman pertama kali dimuat
    window.onload = updatePrice;
</script>