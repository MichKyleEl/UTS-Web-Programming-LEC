<?php
$pagename = "Event";
$urlname = "event.php";
require 'database/config.php';
require 'authentication.php';

require 'features/navbar.php';
require 'features/sidebar.php';
?>

<!-- main -->
<main id="main" class="main">
    <?php
    require 'features/alert.php';
    require 'features/pagetitle.php';

    try {
        // Prepare query to get all events
        $stmt = $pdo->prepare("SELECT * FROM tb_event");
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
                        alt="..." />
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