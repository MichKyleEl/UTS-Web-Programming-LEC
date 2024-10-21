<?php
$pagename = "Event Details"; // Dynamic page title
require 'database/config.php'; // Database connection
require 'authentication.php'; // Session management

require 'features/navbar.php';
require 'features/sidebar.php';

$eventID = $_GET['eid'] ?? null; // Get event ID from URL or set to null if not found
$userId = $_SESSION['user_id'];

if ($eventID === null) {
    echo "<p>No event selected.</p>";
    exit;
}
?>

<!-- main -->
<main id="main" class="main">
<?php
require 'features/pagetitle.php'; // Dynamic page title

try {
    // Prepare query to fetch event details by event_id
    $stmt = $pdo->prepare("SELECT * FROM tb_event WHERE event_id = :event_id");
    $stmt->bindParam(':event_id', $eventID, PDO::PARAM_INT);
    $stmt->execute();
    
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        echo "<p>Event not found.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$reg = $pdo->prepare("
    SELECT * FROM tb_registration 
    WHERE user_id = :user_id AND event_id = :event_id
");
$reg->execute([
    ':user_id' => $userId,
    ':event_id' => $eventID
]);

$registration = $reg->fetch(PDO::FETCH_ASSOC);

?>

<?php if ($event) : ?>

    <div class="card" style="max-width: 1000px;">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($event['event_name']); ?></h5>

                <!-- Slides with indicators -->
                <div
                  id="carouselExampleIndicators"
                  class="carousel slide"
                  data-bs-ride="carousel"
                >
                  <div class="carousel-indicators">
                    <button
                      type="button"
                      data-bs-target="#carouselExampleIndicators"
                      data-bs-slide-to="0"
                      class="active"
                      aria-current="true"
                      aria-label="Slide 1"
                    ></button>
                    <button
                      type="button"
                      data-bs-target="#carouselExampleIndicators"
                      data-bs-slide-to="1"
                      aria-label="Slide 2"
                    ></button>
                  </div>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img
                        src="uploads/<?php echo htmlspecialchars($event['event_banner']); ?>"
                        class="d-block w-100"
                        style="max-height: 700px; object-fit: stretch;"
                        alt="..."
                      />
                    </div>
                    <div class="carousel-item">
                      <img
                        src="uploads/<?php echo htmlspecialchars($event['event_image']); ?>"
                        class="d-block w-100"
                        style="max-height: 700px; object-fit: stretch;"
                        alt="..."
                      />
                    </div>
                  </div>

                  <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev"
                  >
                    <span
                      class="carousel-control-prev-icon"
                      aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next"
                  >
                    <span
                      class="carousel-control-next-icon"
                      aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
                <!-- End Slides with indicators -->
              </div>
            </div>
            
            <div class="card">
              <div class="card-body">
                <br>
                <p class="card-text"><small class="text-muted">Event Date: <?php echo htmlspecialchars($event['event_date']); ?></small></p>
                <p class="card-text"><small class="text-muted">Event Time: <?php echo htmlspecialchars($event['event_time']); ?></small></p>
                <p class="card-text"><small class="text-muted">Location: <?php echo htmlspecialchars($event['event_location']); ?></small></p>
                <p class="card-text"><?php echo htmlspecialchars($event['event_description']); ?></p>
                <?php if (!$registration): ?>
                <a href="registerevent.php?event_id=<?php echo $eventID; ?>" class="btn btn-primary">Register</a>
                <?php else: ?>
                <a href="cancelevent.php?event_id=<?php echo $eventID; ?>" class="btn btn-danger" onclick="alert('Are You Sure?');">Cancel</a>
                <?php endif; ?>
              </div>
            </div>
<?php endif; ?>

</main>
<!-- end main -->

<?php
require 'features/footer.php';
?>
