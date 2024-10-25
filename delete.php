<?php
$link = mysqli_connect("localhost", "root", "", "db_eventsystem");
$id = $_GET["event_id"];

function delete($id)
{
  global $link;
  mysqli_query($link, "DELETE FROM tb_event WHERE event_id = $id");
  return mysqli_affected_rows($link);
}

if (delete($id) > 0) {
  echo "<script>
                alert('Data Berhasil dihapus!');
                document.location.href = 'adminevent.php';
              </script>
        ";
} else {
  echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'adminevent.php';
              </script>
        ";
}
