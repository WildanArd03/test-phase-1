<?php
class oop
{
   function simpan($con, $tabel, array $field)
   {
      $sql = "INSERT INTO $tabel SET";
      foreach ($field as $key => $value) {
         $sql .= " $key = '$value',";
      }
      $sql = rtrim($sql, ',');
      $jalan = mysqli_query($con, $sql);
      if ($jalan) {
         echo "<script>document.location.href='index.php'</script>";
      } else {
         echo "<script>document.location.href='index.php'</script>";
      }
   }
   function tampil($con, $tabel)
   {
      $sql = "SELECT * FROM $tabel";
      $tampil = mysqli_query($con, $sql);
      while ($data = mysqli_fetch_assoc($tampil))
         $isi[] = $data;
      return @$isi;
   }
   function edit($con, $tabel, $where)
   {
      $sql = "SELECT * FROM $tabel WHERE $where";
      $jalan = mysqli_fetch_assoc(mysqli_query($con, $sql));
      return $jalan;
   }
   function update($con, $tabel, array $field, $where)
   {
      $sql = "UPDATE $tabel SET";
      foreach ($field as $key => $value) {
         $sql .= " $key = '$value',";
      }
      $sql = rtrim($sql, ',');
      $sql .= " WHERE $where";
      $jalan = mysqli_query($con, $sql);
      if ($jalan) {
         echo "<script>alert('Data terupdate...');document.location.href='index.php'</script>";
      } else {
         echo error_reporting($jalan);
      }
   }
   function hapus($con, $tabel, $where)
   {
      $sql = "DELETE FROM $tabel WHERE $where";
      $jalan = mysqli_query($con, $sql);
   }
}
