<?php
@include('config/koneksi.php');
if ($_POST['rowid']) {
   $id = $_POST['rowid'];
   $sql = "SELECT * FROM siswa WHERE id = $id";
   $result = $con->query($sql);
   foreach ($result as $baris) { ?>
      <form action="update.php" method="post">
         <input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
         <div class="mb-3">
            <label for="inputS" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" id="inputS" name="siswa" value="<?php echo $baris['siswa']; ?>">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
            <button class="btn btn-primary" type="submit">Update</button>
         </div>
      </form>

<?php }
}
