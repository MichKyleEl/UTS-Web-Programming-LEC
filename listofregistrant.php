<?php
$pagename = "List Of Registrant"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "listofregistrant.php"; // INI "index.php" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN URL PAGE YANG KALIAN BUAT 
require 'database/config.php'; // config buat koneksi database doank
require 'authentication.php'; // authentication buat atur session, dll

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

$tabelevent = query("
    SELECT DISTINCT u.*
    FROM tb_user u
    JOIN tb_registration r ON u.user_id = r.user_id
    WHERE u.role != 'admin'
");

require 'features/navbar.php';
require 'features/sidebar.php';
?>

<!-- main -->
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>
    <div class="card mb-3" style="padding:20px; border-radius:15px">
        List Registrant Event User
        <div class="container mb-4">
            <div class="table-responsive mt-2">
                <table class="table table-striped table-hover" id="table6">
                    <thead class="table-dark">
                        <tr>
                            <th>Actions</th>
                            <th>User_name</th>
                            <th>User Email</th>
                            <th>Role</th>
                            <th>Created at</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($tabelevent as $row) : ?>
                            <tr>
                                <td>
                                    <a href="listeventuser.php?user_id=<?= $row['user_id']; ?>" class="btn btn-primary btn-sm">List Event</a>
                                </td>
                                <td><?= $row["user_name"]; ?></td>
                                <td><?= $row["user_email"]; ?></td>
                                <td><?= $row["role"]; ?></td>
                                <td><?= $row["created_at"]; ?></td>
                                <td><img src="uploads/profile/<?= $row["foto"]; ?>" alt="Profile Picture" style="max-width: 50px; max-height: 50px;"></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

</main>
<!-- end main -->

<?php
require 'features/footer.php';
?>