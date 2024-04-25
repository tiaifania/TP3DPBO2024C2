<?php

// Include file konfigurasi dan kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Fakultas.php');
include('classes/Template.php');

// Buat instance objek Fakultas
$fakultas = new Fakultas($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$fakultas->open();

// Ambil daftar fakultas dari database
$fakultas->getFakultas();

// Cek apakah parameter id tidak diset
if (!isset($_GET['id'])) {
    // Jika form telah disubmit
    if (isset($_POST['submit'])) {
        // Tambahkan fakultas baru
        if ($fakultas->addFakultas($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'fakultas.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'fakultas.php';
            </script>";
        }
    }

    // Set judul dan tombol untuk menambah fakultas
    $btn = 'Tambah';
    $title = 'Tambah';
}

// Buat instance objek Template untuk mengelola tampilan
$view = new Template('templates/skintabel.html');

// Judul utama untuk halaman
$mainTitle = 'Fakultas';

// Header tabel
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Fakultas</th>
<th scope="row">Aksi</th>
</tr>';

// Data tabel yang akan ditampilkan
$data = null;
$no = 1;
$formLabel = 'fakultas';

// Loop untuk menampilkan data fakultas
while ($div = $fakultas->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['fakultas_nama'] . '</td>
    <td style="font-size: 22px;">
        <a href="fakultas.php?id=' . $div['fakultas_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="fakultas.php?hapus=' . $div['fakultas_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

// Jika parameter id diset (proses ubah data)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        // Jika form telah disubmit
        if (isset($_POST['submit'])) {
            // Update data fakultas
            if ($fakultas->updateFakultas($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'fakultas.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'fakultas.php';
            </script>";
            }
        }

        // Ambil data fakultas berdasarkan id
        $fakultas->getFakultasById($id);
        $row = $fakultas->getResult();

        // Data untuk form update
        $dataUpdate = $row['fakultas_nama'];
        $btn = 'Simpan';
        $title = 'Ubah';

        // Ganti nilai placeholder pada template dengan data update
        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
        $view->write();
    }
}

// Jika parameter hapus diset (proses hapus data)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        // Hapus data fakultas berdasarkan id
        if ($fakultas->deleteFakultas($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'fakultas.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'fakultas.php';
            </script>";
        }
    }
}

$test = ' <a href="addfakultas.php" class="btn btn-primary mt-3">Tambah Fakultas</a>';

// Tutup koneksi database
$fakultas->close();

// Ganti nilai placeholder pada template dengan data yang telah disiapkan
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('BUTTON', $test);

// Menampilkan tampilan ke layar
$view->write();

?>
