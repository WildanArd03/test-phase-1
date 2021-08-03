$(document).ready(function () {
   const entry = `
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
          <button type="button" class="btn btn-danger" id="hapus"  name="delete">-</button>
      </div>
  </div>
</div>
`

   function stringToHtml(stringHtml) {
      const temp = document.createElement('div')
      temp.innerHTML = stringHtml
      return temp.firstElementChild
   }

   function createEntry(id) {
      const entryEl = stringToHtml(entry)
      entryEl.querySelector('button').addEventListener('click', () => {
         removeEntry(id)
         entryEl.remove()
      })
      return entryEl
   }

   function addEntry(id, element) {
      entries.set(id, element)
      rerender()
   }

   function removeEntry(id) {
      entries.delete(id)
      rerender()
   }
   const parentEl = document.querySelector('#root')
   const buttonTambah = document.querySelector('#tambah')
   const entries = new Map()
   let counter = 1
   buttonTambah.addEventListener('click', () =>
      addEntry(counter, createEntry(counter++))
   )

   function rerender() {
      parentEl.innerHTML = ''
      entries.forEach(value => parentEl.appendChild(value))
   }
})