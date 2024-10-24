<?php
$pagename = "User Management"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "usermanagement.php"; // INI "index.php" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN URL PAGE YANG KALIAN BUAT 
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

$tabelevent = query("SELECT * FROM tb_user WHERE role != 'admin'");


require 'features/navbar.php';
require 'features/sidebar.php';
?>

<!-- main -->
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>
    User Management Table
    <div class="container mb-4">
        <div class="table-responsive mt-2">
            <table class="table table-striped table-hover table-bordered">
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
                                <a href="deleteuser.php?user_id=<?= $row["user_id"]; ?>" onclick="return confirm('Are you sure want to delete this account?');" class=" btn btn-danger btn-sm">Delete User account</a>
                                <a href="listusermanagement.php?user_id=<?= $row['user_id']; ?>" class="btn btn-primary">History</a>
                            </td>
                            <td><?= $row["user_name"]; ?></td>
                            <td><?= $row["user_email"]; ?></td>
                            <td><?= $row["role"]; ?></td>
                            <td><?= $row["created_at"]; ?></td>
                            <td><?= $row["foto"]; ?></td>
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