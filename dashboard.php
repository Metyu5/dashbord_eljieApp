<?php
session_start();

// Cek apakah ada session login_success
if (isset($_SESSION['login_success'])) {
    echo "<script>alert('" . $_SESSION['login_success'] . "');</script>";

    // Setelah menampilkan pesan, unset session agar tidak muncul lagi
    unset($_SESSION['login_success']);
}
?>

<?php include "header.php" ?>
<!-- sidebar -->
<?php include "sidebar.php" ?>
<!-- maincontent -->
<main class="main-content">
    <?php include "topnav.php"; ?> <!-- khusus tombol menu, search, profile -->
    <?php include "maincontent.php"; ?> <!-- khusus dashboard content -->
</main>

<script src="./assets/js/dashboard.js"></script>