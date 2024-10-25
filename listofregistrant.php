<?php
$pagename = "List Of Registrant";
$urlname = "listofregistrant.php";
require 'database/config.php'; // config for database connection
require 'authentication.php'; // for session management

$link = mysqli_connect('localhost', 'root', '', 'db_eventsystem');

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

// Query to select users with at least one registered event
$tabelevent = query("
    SELECT u.*, COUNT(r.event_id) AS event_count
    FROM tb_user u
    JOIN tb_registration r ON u.user_id = r.user_id
    WHERE u.role != 'admin'
    GROUP BY u.user_id
    HAVING event_count > 0
");

require 'features/navbar.php';
require 'features/sidebar.php';
?>

<!-- main -->
<main id="main" class="main">
    <?php require 'features/pagetitle.php'; ?>

    <div class="card mb-3" style="padding:20px; border-radius:15px">
        List Registrant Event User
        <div class="container mb-4">
            <div class="table-responsive mt-2">
                <table class="table table-striped table-hover" id="table4">
                    <thead class="table-dark">
                        <tr>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Role</th>
                            <th>Created at</th>
                            <th>Foto</th>
                            <th>Number of Registered Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tabelevent as $row) : ?>
                            <tr>
                                <td><?= $row["user_name"]; ?></td>
                                <td><?= $row["user_email"]; ?></td>
                                <td><?= $row["role"]; ?></td>
                                <td><?= $row["created_at"]; ?></td>
                                <td><img src="uploads/profile/<?= $row["foto"]; ?>" class="img-fluid rounded-start" alt="..." /></td>
                                <td><?= $row["event_count"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<!-- end main -->

<?php require 'features/footer.php'; ?>