<?php
$pagename = "Create Event"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "adminevent.php"; // INI "index.php" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN URL PAGE YANG KALIAN BUAT 
require 'database/config.php'; // config buat koneksi database doank
require 'authentication.php'; // authentication buat atur session, dll

$link = mysqli_connect("localhost", 'root', '', 'db_eventsystem');



if (isset($_POST["submit"])) {
    $ename = htmlspecialchars($_POST["event_name"]);
    $edescription = htmlspecialchars($_POST["event_description"]);
    $edate = htmlspecialchars($_POST["event_date"]);
    $etime = htmlspecialchars($_POST["event_time"]);
    $elocation = htmlspecialchars($_POST["event_location"]);
    $max = htmlspecialchars($_POST["max_participants"]);
    $estatus = htmlspecialchars($_POST["event_status"]);

    //upload gambar
    $img = upload('event_image');
    if (!$img) {
        return false;
    }

    $ebanner = upload2('event_banner');
    if (!$ebanner) {
        return false;
    }

    $query = "INSERT INTO tb_event VALUES ('', '$ename', '$edescription', '$edate', '$etime', '$elocation', '$max', '$img', '$ebanner', '$estatus')";
    mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'adminevent.php';
              </script>
        ";
    } else {
        echo " <script>
                alert('Data Gagal Ditambahkan, Silahkan Ulangi!');
                document.location.href = 'adminevent.php';
              </script>";
        echo "<br>";
        echo mysqli_error($link);
    }
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
    <form action="" method="post" enctype="multipart/form-data">
        <div class="container mb-5">
            <div class="form-group mb-4">
                <label for="event_name">Event Name</label>
                <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Add New Event" required autofocus>
            </div>
            <div class="form-group mb-4">
                <label for="event_description">Event Description</label>
                <textarea class="form-control" rows="3" name="event_description" id="event_description" placeholder="Description"></textarea>
            </div>
            <div class="form-group mb-4">
                <label for="event_date">Event Date</label>
                <input type="text" name="event_date" id="event_date" class="form-control" required>
            </div>
            <div class="form-group mb-4">
                <label for="event_time">Event Time</label>
                <input type="text" name="event_time" id="event_time" class="form-control" placeholder="Duration" required>
            </div>
            <div class="form-group mb-4">
                <label for="event_location">Event Location</label>
                <input type="text" name="event_location" id="event_location" class="form-control" placeholder="Location" required>
            </div>
            <div class="form-group mb-4">
                <label for="max_participants">Maximum Participants</label>
                <input type="number" name="max_participants" id="max_participants" class="form-control" placeholder="number of people">
            </div>
            <div class="form-group mb-4">
                <label for="event_image">Image</label>
                <input type="file" name="event_image" id="event_image" class="form-control" placeholder="number of people">
            </div>
            <div class="form-group mb-4">
                <label for="event_banner">Banner</label>
                <input type="file" name="event_banner" id="event_banner" class="form-control" placeholder="number of people">
            </div>
            <div class="form-group mb-5">
                <label for="event_status">Status</label>
                <select class="form-control" name="event_status" id="event_status" required>
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                    <option value="Canceled">Canceled</option>
                </select>

                <button class="mt-5 btn btn-primary me-2" type="submit" name="submit">Create New Event</button>
                <button class="mt-5 btn btn-danger" type="reset" name="reset">Reset</button>
            </div>

    </form>
    </div>


</main>
<!-- end main -->

<?php
require 'features/footer.php';
?>