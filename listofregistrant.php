<?php
$pagename = "List of Registrants"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
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

$tabelevent = query("SELECT * FROM tb_user");


require 'features/navbar.php';
require 'features/sidebar.php';
?>

<!-- main -->
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>
    NAH INI KONTEN KALIAN

    <div class="table-responsive">
        <table class="table table-striped table-hover datatable">
            <thead>
                <tr>
                    <th>User_name</th>
                    <th>User Email</th>
                    <th>User Password</th>
                    <th>Role</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($tabelevent as $row) : ?>
                    <tr>
                        </td>
                        <td><?= $row["user_name"]; ?></td>
                        <td><?= $row["user_email"]; ?></td>
                        <td><?= $row["user_password"]; ?></td>
                        <td><?= $row["role"]; ?></td>
                        <td><?= $row["created_at"]; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>
<!-- end main -->

<?php
require 'features/footer.php';
?>