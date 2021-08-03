<?php
include('config/koneksi.php');
@$id = $_POST['id'];
@$siswas = $_POST['siswa'];
$sql = "UPDATE siswa SET siswa = '$siswas' WHERE id=$id";
$jalan = mysqli_query($con, $sql);
if ($jalan) {
   echo "<script>document.location.href='index.php'</script>";
}
