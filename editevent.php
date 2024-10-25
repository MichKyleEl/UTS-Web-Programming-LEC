<?php
$pagename = "Edit Event"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "adminevent.php"; // INI "index.php" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN URL PAGE YANG KALIAN BUAT 
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
    $estatus = htmlspecialchars($_POST["event_status"]);
    $gambarLamaImage = htmlspecialchars($data["event_image_lama"]);
    $gambarlamaBanner = htmlspecialchars($data["event_banner_lama"]);
    //cek user pilih gambar baru apa engga
    if ($_FILES["event_image"]["error"] === 4) {
        $img = $gambarLamaImage;
    } else {
        $img = upload("event_image");
    }

    if ($_FILES["event_banner"]["error"] === 4) {
        $ebanner = $gambarlamaBanner;
    } else {
        $ebanner = upload2("event_banner");
    }

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

function upload()
{
    $namaFile = $_FILES['event_image']['name'];
    $ukuranFile = $_FILES['event_image']['size'];
    $error = $_FILES['event_image']['error'];
    $tmpName = $_FILES['event_image']['tmp_name'];

    // cek gambar yang ga diupload
    if ($error === 4) {
        echo "<script>
                alert('Please choose the image first!');
            </script>";
        return false;
    }

    // cek gambar atau bukan yang diupload
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('File harus berbentuk gambar!');
            </script>";
    }

    //cek jika ukuran gambar terlalu besar
    if ($ukuranFile > 10000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar');
            </script>";
    }

    //generate gambar
    $namaFileBaru = uniqid();
    $namaFileBaru .= '-';
    $namaFileBaru .= $ekstensiGambar;

    // persiapan gambar untuk diuplad 
    move_uploaded_file($tmpName, 'uploads/' . $namaFileBaru);
    return $namaFileBaru;
}

function upload2()
{
    $namaFile = $_FILES['event_banner']['name'];
    $ukuranFile = $_FILES['event_banner']['size'];
    $error = $_FILES['event_banner']['error'];
    $tmpName = $_FILES['event_banner']['tmp_name'];

    // cek gambar yang ga diupload
    if ($error === 4) {
        echo "<script>
                alert('Please choose the image first!');
            </script>";
        return false;
    }

    // cek gambar atau bukan yang diupload
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('File harus berbentuk gambar!');
            </script>";
    }

    //cek jika ukuran gambar terlalu besar
    if ($ukuranFile > 10000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar');
            </script>";
    }

    //generate gambar
    $namaFileBaru = uniqid();
    $namaFileBaru .= '-';
    $namaFileBaru .= $ekstensiGambar;

    // persiapan gambar untuk diuplad 
    move_uploaded_file($tmpName, 'uploads/' . $namaFileBaru);
    return $namaFileBaru;
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

        label {
            font-weight: 1000;
        }
    }
</style>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>
    <div class="container mb-5">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="event_id" id="event_id" value="<?= $data["event_id"]; ?>">
            <input type="hidden" name="event_image_lama" id="event_image" value="<?= $data["event_image"]; ?>">
            <input type="hidden" name="event_banner_lama" id="event_banner" value="<?= $data["event_banner"]; ?>">

            <div class="form-floating mb-4">
                <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Add New Event" required value="<?= $data["event_name"]; ?>" autofocus>
                <label for="event_name">Event Name</label>
            </div>

            <div class="form-floating mb-4">
                <textarea class="form-control" rows="3" name="event_description" id="event_description" placeholder="Description"><?= $data["event_description"]; ?></textarea>
                <label for="event_description">Event Description</label>
            </div>

            <div class="form-floating mb-4">
                <input type="date" name="event_date" id="event_date" class="form-control" placeholder="Event Date" required value="<?= $data["event_date"]; ?>">
                <label for="event_date">Event Date</label>
            </div>

            <div class="form-floating mb-4">
                <input type="time" name="event_time" id="event_time" class="form-control" placeholder="Event Time" required value="<?= $data["event_time"]; ?>">
                <label for="event_time">Event Time</label>
            </div>

            <div class="form-floating mb-4">
                <input type="text" name="event_location" id="event_location" class="form-control" placeholder="Event Location" required value="<?= $data["event_location"]; ?>">
                <label for="event_location">Event Location</label>
            </div>

            <div class="form-floating mb-4">
                <input type="number" name="max_participants" id="max_participants" class="form-control" placeholder="Maximum Participants" value="<?= $data["max_participants"]; ?>">
                <label for="max_participants">Maximum Participants</label>
            </div>

            <div class="mb-4">
                <label for="event_image">Event Image</label><br>
                <img src="uploads/<?= $data["event_image"] ?>" width="120" alt="Event Image">
                <input type="file" name="event_image" id="event_image" class="form-control mt-2">
            </div>

            <div class="mb-4">
                <label for="event_banner">Event Banner</label><br>
                <img src="uploads/<?= $data["event_banner"] ?>" width="120" alt="Event Banner">
                <input type="file" name="event_banner" id="event_banner" class="form-control mt-2">
            </div>

            <div class="form-floating mb-5">
                <select class="form-control" name="event_status" id="event_status" required>
                    <option value="Open" <?= $data["event_status"] == "Open" ? "selected" : "" ?>>Open</option>
                    <option value="Closed" <?= $data["event_status"] == "Closed" ? "selected" : "" ?>>Closed</option>
                    <option value="Canceled" <?= $data["event_status"] == "Canceled" ? "selected" : "" ?>>Canceled</option>
                </select>
                <label for="event_status">Status</label>
            </div>

            <button class="btn btn-primary me-2" type="submit" name="submit">Change</button>
            <button class="btn btn-danger" type="reset" name="reset">Reset</button>
        </form>
    </div>


</main>


<?php
require 'features/footer.php';
?>