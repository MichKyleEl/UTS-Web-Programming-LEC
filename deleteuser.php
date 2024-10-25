<?php
$link = mysqli_connect("localhost", "root", "", "db_eventsystem");
$id = $_GET["user_id"];

function delete($id)
{
  global $link;
  mysqli_query($link, "DELETE FROM tb_user WHERE user_id = $id");
  return mysqli_affected_rows($link);
}

if (delete($id) > 0) {
  echo "<script>
                alert('Akun Berhasil dihapus!');
                document.location.href = 'usermanagement.php';
              </script>
        ";
} else {
  echo "<script>
                alert('Akun gagal dihapus!');
                document.location.href = 'usermanagement.php';
              </script>
        ";
}
