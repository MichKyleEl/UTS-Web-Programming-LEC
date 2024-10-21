<?php
$pagename = "Edit Event"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "index.php"; // INI "index.php" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN URL PAGE YANG KALIAN BUAT 
require 'database/config.php'; // config buat koneksi database doank
require 'authentication.php'; // authentication buat atur session, dll

$link = mysqli_connect("localhost", 'root', '', 'db_eventsystem');

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

$id = $_GET["event_id"];
$data = query("SELECT * FROM tb_event WHERE event_id = $id")[0];

function ubah($data)
{
    global $link;
    $id = $data["event_id"];
    $ename = htmlspecialchars($_POST["event_name"]);
    $edescription = htmlspecialchars($_POST["event_description"]);
    $edate = htmlspecialchars($_POST["event_date"]);
    $etime = htmlspecialchars($_POST["event_time"]);
    $elocation = htmlspecialchars($_POST["event_location"]);
    $max = htmlspecialchars($_POST["max_participants"]);
    $img = htmlspecialchars($_POST["event_image"]);
    $ebanner = htmlspecialchars($_POST["event_banner"]);
    $estatus = htmlspecialchars($_POST["event_status"]);

    $query = "UPDATE tb_event SET
                event_name = '$ename',
                event_description = '$edescription',
                event_date = '$edate',
                event_time = '$etime',
                event_location = '$elocation',
                max_participants = '$max',
                event_image = '$img',
                event_banner = '$ebanner',
                event_status = '$estatus'
            WHERE event_id = $id
    ";
    mysqli_query($link, $query);

    return mysqli_affected_rows($link);
}

if (isset($_POST["submit"])) {
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data Berhasil Diubah');
                document.location.href = 'adminevent.php';
              </script>
        ";
    } else {
        echo " <script>
                alert('Data Gagal Diubah, Silahkan Ulangi!');
                document.location.href = 'adminevent.php';
              </script>";
        echo "<br>";
        echo mysqli_error($link);
    }
}

require 'features/navbar.php';
require 'features/sidebar.php';
?>

<!-- main -->
<style>
    button:hover {
        transition: all 0.3s ease;
        transform: scale(1.05);
    }
</style>
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>
    <form action="" method="post">
        <input type="hidden" name="event_id" id="event_id" value="<?= $data["event_id"]; ?>">
        <input type="hidden" name="event_image" id="event_image" value="<?= $data["event_image"]; ?>">
        <div class="container mb-5">
            <div class="form-group mb-4">
                <label for="event_name">Event Name</label>
                <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Add New Event" required value="<?= $data["event_name"]; ?>">
            </div>
            <div class="form-group mb-4">
                <label for="event_description">Event Description</label>
                <textarea class="form-control" rows="3" name="event_description" id="event_description" placeholder="Description"><?= $data["event_description"]; ?></textarea>
            </div>
            <div class="form-group mb-4">
                <label for="event_date">Event Date</label>
                <input type="text" name="event_date" id="event_date" class="form-control" required value="<?= $data["event_date"]; ?>">
            </div>
            <div class="form-group mb-4">
                <label for="event_time">Event Time</label>
                <input type="text" name="event_time" id="event_time" class="form-control" placeholder="Duration" required value="<?= $data["event_time"]; ?>">
            </div>
            <div class="form-group mb-4">
                <label for="event_location">Event Location</label>
                <input type="text" name="event_location" id="event_location" class="form-control" placeholder="Location" required value="<?= $data["event_location"]; ?>">
            </div>
            <div class="form-group mb-4">
                <label for="max_participants">Maximum Participants</label>
                <input type="number" name="max_participants" id="max_participants" class="form-control" placeholder="number of people" value="<?= $data["max_participants"]; ?>">
            </div>
            <div class="form-group mb-4">
                <label for="event_image">Image</label>
                <img src="uploads/<?= $data["event_image"] ?>" width="100" alt="">
                <input type="file" name="event_image" id="event_image" class="form-control" placeholder="number of people">
            </div>
            <div class="form-group mb-4">
                <label for="event_banner">Banner</label>
                <img src="uploads/<?= $data["event_banner"] ?>" width="150">
                <input type="file" name="event_banner" id="event_banner" class="form-control" placeholder="number of people">
            </div>
            <div class="form-group mb-5">
                <label for="event_status">Status</label>
                <select class="form-control" name="event_status" id="event_status" required value="<?= $data["event_status"]; ?>">
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                    <option value="Canceled">Canceled</option>
                </select>

                <button class="mt-5 btn btn-primary me-2" type="submit" name="submit">Change</button>
                <button class="mt-5 btn btn-danger" type="reset" name="reset">Reset</button>
            </div>

    </form>
    </div>


</main>
<!-- end main -->

<?php
require 'features/footer.php';
?>