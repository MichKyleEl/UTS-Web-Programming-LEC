<?php
$pagename = "User Management";
$urlname = "usermanagement.php";
require 'database/config.php';
require 'authentication.php';

$link = mysqli_connect('localhost', 'root', '', 'db_eventsystem');

$Id = $_GET['user_id'];

// Fetch user details
$userQuery = "SELECT * FROM tb_user WHERE user_id = $Id AND role != 'admin'";
$userResult = mysqli_query($link, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// Fetch registration history
$historyQuery = "
    SELECT e.event_name, e.event_date, e.event_time, e.event_location, e.event_description, r.status, r.registration_date
    FROM tb_registration r
    JOIN tb_event e ON r.event_id = e.event_id
    WHERE r.user_id = $Id
    ORDER BY r.registration_date DESC
";
$historyResult = mysqli_query($link, $historyQuery);
$historyData = [];
while ($row = mysqli_fetch_assoc($historyResult)) {
    $historyData[] = $row;
}

require 'features/navbar.php';
require 'features/sidebar.php';
?>

<!-- main -->
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>

    <div class="container mb-4">
        <h2 class="mb-3">User History for <?= htmlspecialchars($user['user_name']); ?></h2>

        <?php if (empty($historyData)) : ?>
            <p class="text-center">This user has no history yet.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="table6">
                    <thead class="table-dark">
                        <tr>
                            <th>Event Name</th>
                            <th>Date & Time</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historyData as $history) : ?>
                            <tr>
                                <td><?= htmlspecialchars($history['event_name']); ?></td>
                                <td><?= htmlspecialchars($history['event_date']) . ' ' . htmlspecialchars($history['event_time']); ?></td>
                                <td><?= htmlspecialchars($history['event_location']); ?></td>
                                <td><?= htmlspecialchars($history['event_description']); ?></td>
                                <td>
                                    <?php if ($history['status'] === 'registered') : ?>
                                        <span class="badge bg-success">Registered</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">Canceled</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($history['registration_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>
<!-- end main -->

<?php
require 'features/footer.php';
?>