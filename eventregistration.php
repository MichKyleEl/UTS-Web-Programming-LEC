<?php
$pagename = "Registered Events";
$urlname = "eventregistration.php";
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

$userId = $_SESSION['user_id']; // Get the logged-in user ID

// Fetch events the user has registered for
$reg = $pdo->prepare("
    SELECT e.* 
    FROM tb_registration r
    JOIN tb_event e ON r.event_id = e.event_id
    WHERE r.user_id = :user_id
");
$reg->execute([':user_id' => $userId]);
$registeredEvents = $reg->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (empty($registeredEvents)) : ?>
    <p class="text-center">You have not registered for any events yet.</p>
<?php else : ?>
    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col" class="banner-column-rounded">Banner</th>
                <th scope="col" class="image-column-rounded">Photo</th>
                <th scope="col">Name</th>
                <th scope="col">Date & Time</th>
                <th scope="col">Description</th>
                <th scope="col">Location</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registeredEvents as $event) : ?>
                <tr>
                    <!-- Banner -->
                    <td class="banner-column p-0px">
                        <img src="uploads/<?php echo htmlspecialchars($event['event_banner']); ?>" alt="Event Banner" class="banner-image" style="border-radius:10px; object-fit: scale-down;" />
                    </td>

                    <!-- Photo -->
                    <td class="image-column p-0px">
                        <img src="uploads/<?php echo htmlspecialchars($event['event_image']); ?>" alt="Event Image" class="event-image" style="border-radius:10px; object-fit: scale-down;" />
                    </td>

                    <!-- Name -->
                    <td>
                        <?php echo htmlspecialchars($event['event_name']); ?>
                    </td>

                    <!-- Date & Time -->
                    <td><?php echo htmlspecialchars($event['event_date']); ?><br><?php echo htmlspecialchars($event['event_time']); ?></td>

                    <!-- Description -->
                    <td><?php echo htmlspecialchars($event['event_description']); ?></td>

                    <!-- Location -->
                    <td><?php echo htmlspecialchars($event['event_location']); ?></td>

                    <!-- Status (Cancel Button) -->
                    <td>
                        <!-- Unique modal trigger -->
                        <a class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#cancelModal<?php echo $event['event_id']; ?>">Cancel</a>
                    </td>
                </tr>

                <!-- Modal (unique for each event) -->
                <div class="modal fade" id="cancelModal<?php echo $event['event_id']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Cancel Event?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to cancel <strong><?php echo htmlspecialchars($event['event_name']); ?></strong>?
                                <p class="text-muted">Event Date & Time: <?php echo htmlspecialchars($event['event_date']) . ', ' . htmlspecialchars($event['event_time']); ?></p>
                                <p class="text-muted">Location: <?php echo htmlspecialchars($event['event_location']); ?></p>
                                <p class="text-muted"><?php echo htmlspecialchars($event['event_description']); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="cancelevent.php?event_id=<?php echo $event['event_id']; ?>&source=eventreg" class="btn btn-danger">Cancel Event</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</main>
<!-- end main -->

<!-- CSS to fix image sizes -->
<style>
    .banner-image, .event-image {
        width: 150px;
        height: 100px;
        object-fit: cover; /* This ensures images are resized without distortion */
    }
</style>

<?php
require 'features/footer.php'; 
?>
