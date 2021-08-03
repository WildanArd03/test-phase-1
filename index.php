<?php
include('config/koneksi.php');
include('App/controller.php');
$op = new oop();
@$tabel = "siswa";
@$where = "id = $_GET[id]";
$siswaErr = $nilaiErr = $nsisErr = '';
if (isset($_POST['btnSis'])) {
   @$siswa = $_POST['nama_siswa'];
   @$tabel = "siswa";
   @$field = array(
      'siswa' => $siswa
   );
   $sql = mysqli_query($con, "SELECT * FROM siswa where siswa = '$siswa'");
   $r = mysqli_num_rows($sql);
   if ($r > 0) {
      $siswaErr = '<p class="text-danger m-0">Siswa sudah ada</p>';
   } else if (!preg_match("/^[0-9 ]*$/", $siswa)) {
      $op->simpan($con, $tabel, $field);
   } else {
      $siswaErr = '<p class="text-danger m-0">Format tidak valid</p>';
   }
}
if (isset($_POST['btnNil'])) {
   @$tabels = "input_nilai";
   @$nilai = $_POST['nilai'];
   @$siswa = $_POST['siswa'];
   if ($nilai >= 80) {
      $predikat = 'Nilai A';
   } else if ($nilai >= 60) {
      $predikat = 'Nilai B';
   } else if ($nilai >= 40) {
      $predikat = 'Nilai C';
   } else {
      $predikat = 'Nilai D';
   }
   @$fields = array(
      'id_siswa' => $siswa,
      'nilai' => $nilai,
      'predikat' => $predikat
   );
   $sql = mysqli_query($con, "SELECT * FROM $tabels where id_siswa = '$siswa'");
   $r = mysqli_num_rows($sql);
   $val = trim($_POST['nilai']);
   if ($r > 0) {
      $nsisErr = '<p class="text-danger m-0">Siswa sudah di input nilai</p>';
   } else if (is_numeric($val) == TRUE) {
      $op->simpan($con, $tabels, $fields);
   } else {
      $nilaiErr = '<p class="text-danger m-0">Format Tidak valid</p>';
   }
}
if (isset($_GET['hapus'])) {
   $op->hapus($con, $tabel, $where);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Case</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
   <div class="container-fluid">
      <div class="row mt-3">
         <div class="col-md-6">
            <div class="row">
               <div class="col-md-10">
                  <h1 class="m-0">Recruitment test phase 1</h1>
                  <p class="m-0 mb-3">PT Berdhaya Gemilang Mandiri</p>
               </div>
               <div class="d-flex col-sm-12 justify-content-center mb-3 col-md-2 align-items-center">
                  <a href="versi2.php" class="btn btn-success btn-sm">Versi 2</a>
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header">
                        Tambah Siswa
                     </div>
                     <div class="card-body">
                        <form method="post">
                           <div class="mb-3">
                              <label for="inputSis" class="form-label">Tambah Siswa</label>
                              <?= $siswaErr ?>
                              <input type="text" class="form-control" id="inputSis" name="nama_siswa" required>
                           </div>
                           <button type="submit" class="btn btn-primary" name="btnSis">Tambah +</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header">
                        Input Nilai
                     </div>
                     <div class="card-body">
                        <form method="POST">
                           <div class="mb-3">
                              <label for="inputSis" class="form-label">Nama Siswa/i</label>
                              <?= $nsisErr ?>
                              <select class="form-select" aria-label="Default select example" name="siswa" required>
                                 <option selected disabled>- - - Pilih Siswa - - -</option>
                                 <?php
                                 $siswas = $op->tampil($con, 'siswa');
                                 foreach ($siswas as $siswa) { ?>
                                    <option value="<?= $siswa['id'] ?>"><?= $siswa['siswa'] ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="mb-3">
                              <label for="inputNil" class="form-label">Input Nilai</label>
                              <?= $nilaiErr ?>
                              <input type="text" class="form-control" id="inputNil" name="nilai" maxlength="3" placeholder="0 - 100" required>
                           </div>
                           <button type="submit" class="btn btn-primary" name="btnNil">Submit</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="row mb-3">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header">Siswa</div>
                     <div class="card-body p-0">
                        <table class="table table-striped m-0">
                           <thead>
                              <tr>
                                 <th scope="col">No</th>
                                 <th scope="col">Nama Siswa</th>
                                 <th scope="col">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $batas = 4;
                              $halaman = isset($_GET['siswa']) ? (int)$_GET['siswa'] : 1;
                              $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

                              $previous = $halaman - 1;
                              $next = $halaman + 1;

                              $data = mysqli_query($con, "select * from siswa");
                              $jumlah_data = mysqli_num_rows($data);
                              $total_halaman = ceil($jumlah_data / $batas);

                              $i = 0;
                              $siswas = mysqli_query($con, "select * from siswa limit $halaman_awal, $batas");
                              $nomor = $halaman_awal + 1;
                              foreach ($siswas as $siswa) {
                              ?>
                                 <tr>
                                    <th scope="row"><?= $nomor++ ?></th>
                                    <td><?= $siswa['siswa'] ?></td>
                                    <td>
                                       <?= '<a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" id="custId" data-id=' . $siswa["id"] . '>Edit</a>' ?>
                                       <a href="?hapus&id=<?= $siswa['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin Mau Di Hapus ?')">Hapus</a>
                                    </td>
                                 </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                        <nav>
                           <ul class="pagination m-0 p-2">
                              <li class="page-item">
                                 <a class="page-link p-0 px-2" <?php
                                                               if ($halaman > 1) {
                                                                  echo "href='?siswa=$previous'";
                                                               } ?>> Previous</a>
                              </li>
                              <?php
                              for ($x = 1; $x <= $total_halaman; $x++) {
                              ?>
                                 <li class="page-item"><a class="page-link p-0 px-2" href="?siswa=<?php echo $x ?>"><?php echo $x; ?></a></li>
                              <?php
                              }
                              ?>
                              <li class="page-item">
                                 <a class="page-link p-0 px-2" <?php if ($halaman < $total_halaman) {
                                                                  echo "href='?siswa=$next'";
                                                               } ?>>Next</a>
                              </li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header">Nilai Siswa</div>
                     <div class="card-body p-0">
                        <table class="table table-striped">
                           <thead>
                              <tr>
                                 <th scope="col">No</th>
                                 <th scope="col">Nama Siswa</th>
                                 <th scope="col">Nilai</th>
                                 <th scope="col">Predikat</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $batas = 4;
                              $halaman = isset($_GET['nilaiSiswa']) ? (int)$_GET['nilaiSiswa'] : 1;
                              $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

                              $previous = $halaman - 1;
                              $next = $halaman + 1;

                              $data = mysqli_query($con, "select * from input_nilai");
                              $jumlah_data = mysqli_num_rows($data);
                              $total_halaman = ceil($jumlah_data / $batas);
                              $siswas = mysqli_query($con, "SELECT * FROM input_nilai, siswa where input_nilai.id_siswa = siswa.id  order by siswa asc limit $halaman_awal, $batas");
                              $nomor = $halaman_awal + 1;
                              foreach ($siswas as $siswa) {
                              ?>
                                 <tr>
                                    <th scope="row"><?= $nomor++ ?></th>
                                    <td><?= $siswa['siswa'] ?></td>
                                    <td><?= $siswa['nilai'] ?></td>
                                    <td><?= $siswa['predikat'] ?></td>
                                 </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                        <nav>
                           <ul class="pagination m-0 p-2">
                              <li class="page-item">
                                 <a class="page-link p-0 px-2" <?php
                                                               if ($halaman > 1) {
                                                                  echo "href='?nilaiSiswa=$previous'";
                                                               } ?>> Previous</a>
                              </li>
                              <?php
                              for ($x = 1; $x <= $total_halaman; $x++) {
                              ?>
                                 <li class="page-item"><a class="page-link p-0 px-2" href="?nilaiSiswa=<?php echo $x ?>"><?php echo $x; ?></a></li>
                              <?php
                              }
                              ?>
                              <li class="page-item">
                                 <a class="page-link p-0 px-2" <?php if ($halaman < $total_halaman) {
                                                                  echo "href='?nilaiSiswa=$next'";
                                                               } ?>>Next</a>
                              </li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="fetched-data">
               </div>
            </div>
         </div>
      </div>
   </div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   <script>
      $(document).ready(function() {
         $('#exampleModal').on('show.bs.modal', function(e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
               type: 'post',
               url: 'edit.php',
               data: 'rowid=' + rowid,
               success: function(data) {
                  $('.fetched-data').html(data); //menampilkan data ke dalam modal
               }
            });
         });
      });
   </script>
</body>

</html>