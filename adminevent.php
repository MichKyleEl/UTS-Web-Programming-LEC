<?php
$pagename = "Event Management"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "adminevent.php"; // INI "index.php" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN URL PAGE YANG KALIAN BUAT 
require 'database/config.php'; // config buat koneksi database doank
require 'authentication.php'; // authentication buat atur session, dll



require 'features/navbar.php';
require 'features/sidebar.php';

$link = mysqli_connect("localhost", "root", "", "db_eventsystem");

function query($query)
{
    global $link;
    $tb_event = mysqli_query($link, $query);
    $data_rows = [];
    while ($data_row = mysqli_fetch_assoc($tb_event)) {
        $data_rows[] = $data_row;
    }
    return $data_rows;
}

$tabelevent = query("SELECT * FROM tb_event");

?>

<!-- main -->
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>
    List of existing events
    <div class="table-responsive">
        <table class="table table-striped table-hover datatable">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Max Participant</th>
                    <th>image</th>
                    <th>banner</th>
                    <th>event_status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($tabelevent as $row) : ?>
                    <tr>
                        <td><a href="delete.php?event_id=<?= $row["event_id"]; ?>" onclick="return confirm('Are you sure want to delete this data?');" class="btn btn-danger btn-sm">Delete</a>
                            <a href="editevent.php?event_id=<?= $row["event_id"]; ?>" class="btn btn-warning mt-1">Edit</a>
                        </td>
                        <td><?= $row["event_name"]; ?></td>
                        <td><?= $row["event_description"]; ?></td>
                        <td><?= $row["event_date"]; ?></td>
                        <td><?= $row["event_time"]; ?></td>
                        <td><?= $row["event_location"]; ?></td>
                        <td><?= $row["max_participants"]; ?></td>
                        <td><img src="uploads/<?= $row["event_image"]; ?>" width="90"></td>
                        <td><img src="uploads/<?= $row["event_banner"]; ?>" width="90"></td>
                        <td><?= $row["event_status"]; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">
        <a href="createevent.php" class="btn btn-success">Create New Event</a>
    </div>

</main>
<!-- end main -->

<?php
require 'features/footer.php';
?>