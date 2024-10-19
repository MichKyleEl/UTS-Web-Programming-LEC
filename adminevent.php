<?php
$pagename = "Event Management"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "adminevent.php"; // INI "index.php" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN URL PAGE YANG KALIAN BUAT 
require 'database/config.php'; // config buat koneksi database doank
require 'authentication.php'; // authentication buat atur session, dll



require 'features/navbar.php';
require 'features/sidebar.php';
?>

<!-- main -->
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>


    NAH INI KONTEN KALIAN
    <h1>TES dulu</h1>


</main>
<!-- end main -->

<?php
require 'features/footer.php';
?>