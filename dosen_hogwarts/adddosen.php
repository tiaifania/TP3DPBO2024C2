<?php

// Include file konfigurasi dan kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Dosen.php');
include('classes/Matakuliah.php');
include('classes/Fakultas.php');
include('classes/Template.php');

// Buat instance objek Dosen
$dosen = new Dosen($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$dosen->open();

$matakuliah = new Matakuliah($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$matakuliah->open();
$fakultas = new Fakultas($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$fakultas->open();

// Ambil data matakuliah dan fakultas dari database
$dataMatakuliah = $matakuliah->getMatakuliah();
$dataFakultas = $fakultas->getFakultas();



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

// Cek apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Cek apakah ada file yang diunggah
    if (isset($_FILES['dosen_foto'])) {
        // Cek apakah ada error dalam unggah file
        if ($_FILES['dosen_foto']['error'] !== UPLOAD_ERR_OK) {
            echo "Error: Terjadi kesalahan saat mengunggah file.";
        } else {
            $namaFile = $_FILES['dosen_foto']['name'];
            $lokasiFile = $_FILES['dosen_foto']['tmp_name'];
            $tujuan = 'assets/images/' . $namaFile; // Sesuaikan dengan lokasi penyimpanan yang diinginkan
            
            // Pindahkan file ke lokasi tujuan
            if (move_uploaded_file($lokasiFile, $tujuan)) {
                // File berhasil diunggah
                // Tambahkan dosen baru
                if ($dosen->addData($_POST, $namaFile) > 0) {
                    echo "<script>
                        alert('Data dosen berhasil ditambah!');
                        document.location.href = 'index.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Data dosen gagal ditambah!');
                        document.location.href = 'index.php';
                    </script>";
                }
            } else {
                // Gagal memindahkan file
                echo "Error: Gagal menyimpan file.";
            }
        }
    } else {
        // Jika tidak ada file yang diunggah
        echo "Error: Tidak ada file yang diunggah.";
    }
}


// //Bangun opsi pilihan untuk matakuliah
// $optionsMatakuliah = "";
// $query = mysqli_query($db, "SELECT * FROM matakuliah");
// while ($data = mysqli_fetch_array($query)) {
//     $optionsMatakuliah .= "<option value='" . $data['mataKuliah_id'] . "'>" . $data['mataKuliah_nama'] . "</option>";
// }

// // Bangun opsi pilihan untuk fakultas
// $optionsFakultas = "";
// $query = mysqli_query($db, "SELECT * FROM fakultas");
// while ($data = mysqli_fetch_array($query)) {
//     $optionsFakultas .= "<option value='" . $data['fakultas_id'] . "'>" . $data['fakultas_nama'] . "</option>";
// }

$optionsMatakuliah = "";
while ($div = $matakuliah->getResult()) {
    $optionsMatakuliah .= "<option value='" . $div['mataKuliah_id'] . "'>" . $div['mataKuliah_nama'] . "</option>";
}

$optionsFakultas = "";
while ($div = $fakultas->getResult()) {
    $optionsFakultas .= "<option value='" . $div['fakultas_id'] . "'>" . $div['fakultas_nama'] . "</option>";
}

$matakuliah->close();
$fakultas->close();

$form = '<form action="aksi_tambah.php?tabel=dosen" method="POST" enctype="multipart/form-data>
<div class="mb-3">
    <label for="nama" class="form-label">Nama Dosen</label>
    <input type="text" class="form-control" id="nama" name="dosen_nama" required>
</div>
<div class="mb-3">
    <label for="nik" class="form-label">NIK Dosen</label>
    <input type="text" class="form-control" id="nik" name="dosen_NIK" required>
</div>
<div class="mb-3">
    <label for="foto" class="form-label">Foto Dosen</label>
    <input type="file" class="form-control" id="foto" name="dosen_foto" required>
</div>
<div class="mb-3">
    <label for="matakuliah" class="form-label">Mata Kuliah</label>
    <select class="form-select" id="matakuliah" name="mataKuliah_id" required>
        <option value="" selected disabled>Pilih Mata Kuliah</option>
        ' . $optionsMatakuliah . '
    </select>
</div>
<div class="mb-3">
    <label for="fakultas" class="form-label">Fakultas</label>
    <select class="form-select" id="fakultas" name="fakultas_id" required>
        <option value="" selected disabled>Pilih Fakultas</option>
        ' . $optionsFakultas . '
    </select>
</div>
<button type="submit" name="submit" class="btn btn-primary">Tambah</button>
</form>

';

// Buat instance objek Template untuk mengelola tampilan
$view = new Template('templates/skinadd.html');

// Ganti nilai placeholder pada template dengan data yang telah disiapkan
$view->replace('DATA_TITLE', 'Tambah Dosen');
$view->replace('DATA_FORM_LABEL', 'Dosen');
$view->replace('DATA_FORM', $form);

// Menampilkan tampilan ke layar
$view->write();

?>
