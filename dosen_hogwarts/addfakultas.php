<?php

// Include file konfigurasi dan kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');;
include('classes/Fakultas.php');
include('classes/Template.php');

// Buat instance objek Dosen
$matakuliah = new Fakultas($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$matakuliah->open();




// // Cek apakah form telah disubmit
// if (isset($_POST['submit'])) {
//     // Tambahkan dosen baru
//     if ($dosen->addData($_POST, $_FILES) > 0) {
//         echo "<script>
//             alert('Data dosen berhasil ditambah!');
//             document.location.href = 'index.php';
//         </script>";
//     } else {
//         echo "<script>
//             alert('Data dosen gagal ditambah!');
//             document.location.href = 'index.php';
//         </script>";
//     }
// }



$form = '<form action="aksi_tambah.php?tabel=fakultas" method="POST" enctype="multipart/form-data>
<div class="mb-3">
    <label for="nama" class="form-label">Nama Fakultas</label>
    <input type="text" class="form-control" id="nama" name="fakultas_nama" required>
</div>
<button type="submit" name="submit" class="btn btn-primary">Tambah</button>
</form>

';

// Buat instance objek Template untuk mengelola tampilan
$view = new Template('templates/skinadd.html');

// Ganti nilai placeholder pada template dengan data yang telah disiapkan
$view->replace('DATA_TITLE', 'Tambah Fakultas');
$view->replace('DATA_FORM_LABEL', 'Fakultas');
$view->replace('DATA_FORM', $form);

// Menampilkan tampilan ke layar
$view->write();

?>
