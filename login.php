<?php
$pagename = "Profile"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "index.php"; // INI "DASHBOARD" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
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



</main>
<!-- end main -->

<?php
require 'features/footer.php'; 
?>
