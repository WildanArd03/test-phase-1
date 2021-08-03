<?php
@$siswa = $_POST['namaSiswa'];
@$nilai = $_POST['nilaiSiswa'];
$data = array();
@$suze = count($siswa);
for ($count = 0; $count < $suze; $count++) {
   if ($nilai[$count] >= 80) {
      $predikat = 'A';
   } else if ($nilai[$count] >= 60) {
      $predikat = 'B';
   } else if ($nilai[$count] >= 40) {
      $predikat = 'C';
   } else {
      $predikat = 'D';
   }
   $data = array(
      'siswa' => $siswa[$count],
      'nilai' => $nilai[$count],
      'predikat' => $predikat
   );
   @$insert[] = $data;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Versi 2</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
   <div class="container-fluid">
      <div class="row justify-content-center  pt-5">
         <div class="col-md-1">
            <a href="index.php" class="btn btn-sm btn-dark mb-3">Kembali</a>
         </div>
         <div class="col-sm-6 col-md-4">
            <div class="card mb-3">
               <div class="card-header">
                  <div class="row">
                     <div class="col-md-8">
                        Inputan Nama Siswa Dan Nilai
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <form method="post">
                     <div class="mb-3">
                        <div class="row">
                           <div class="col-5 col-sm-5 col-md-5">
                              <label for="namaSiswa" class="form-label">Nama siswa</label>
                              <input type="text" class="form-control" id="namaSiswa" name="namaSiswa[]" required>
                           </div>
                           <div class="col-5 col-sm-5 col-md-5">
                              <label for="nilaiSiswa" class="form-label">Nilai siswa</label>
                              <input type="text" class="form-control" id="nilaiSiswa" name="nilaiSiswa[]" required maxlength="3" placeholder="0 - 100">
                           </div>
                           <div class="col-2 col-sm-2 col-md-2" style="margin-top: 31px;">
                              <input type="button" class="btn btn-success" id="tambah" value="+" name="add">
                           </div>
                        </div>
                     </div>
                     <div id="root"></div>
                     <button type="submit" class="btn btn-primary" name="submit">Submit ></button>
                  </form>
               </div>
            </div>
         </div>
         <div class="col-sm-6 col-md-4">
            <div class="card mb-5">
               <div class="card-header">
                  <div class="row">
                     <div class="col-md-8">
                        Nilai Seluruh Siswa
                     </div>
                  </div>
               </div>
               <di class="card-body">
                  <?php
                  if (is_array(@$insert) || is_object(@$insert)) {
                     $no = 0;
                     foreach ($insert as $i) {
                        $no++ ?>
                        <div class="card mb-2">
                           <div class="card-header p-0 px-2 py-1 fw-bold">Siswa <?= $no ?> </div>
                           <div class="card-body p-0 px-2 py-1">
                              <p class="m-0">Nama : <?= @$i['siswa'] ?></p>
                              <p class="m-0">Nilai : <?= @$i['predikat'] ?></p>
                           </div>
                        </div>
                  <?php }
                  } ?>
            </div>
         </div>
      </div>
   </div>
   </div>
   <script src="src/index.js"></script>
</body>

</html>