<?php
$pagename = "Event"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "event.php"; // INI "DASHBOARD" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
require 'database/config.php'; // config buat koneksi database doank
require 'authentication.php'; // authentication buat atur session, dll



require 'features/navbar.php';
require 'features/sidebar.php'; 
?>

<!-- main -->
<main id="main" class="main">
<?php
require 'features/alert.php';
require 'features/pagetitle.php'; 

try {
    // Prepare query to get event names and number of registrants
    $stmt = $pdo->prepare("
        SELECT 
            e.event_name, 
            COUNT(r.registration_id) AS registrant_count 
        FROM tb_event e 
        LEFT JOIN tb_registration r ON e.event_id = r.event_id 
        GROUP BY e.event_id
    ");
    $stmt->execute();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM tb_event WHERE event_status = 'open'");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<?php foreach ($events as $event) : ?>
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-2">
        <img
        src="uploads/<?php echo htmlspecialchars($event['event_banner']); ?>"
        class="img-fluid rounded-start"
        alt="..."
        />
        </div>
        <div class="col-md-8">
            <div class="card-body">
            <h5 class="card-title"><a href="eventdetails.php?eid=<?php echo $event['event_id'] ?>" style="text-decoration:none;color:black;"><?php echo htmlspecialchars($event['event_name']); ?></a></h5>
            <p class="card-text">
            <?php echo htmlspecialchars($event['event_description']); ?>
            </p>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
</main>
<!-- end main -->

<?php
require 'features/footer.php'; 
?>
