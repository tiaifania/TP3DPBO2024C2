<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Matakuliah.php');
include('classes/Template.php');

$matakuliah = new Matakuliah($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$matakuliah->open();
$matakuliah->getMatakuliah();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($matakuliah->addMatakuliah($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'matakuliah.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'matakuliah.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Mata Kuliah';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Mata Kuliah</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'mata kuliah';

while ($div = $matakuliah->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['mataKuliah_nama'] . '</td>
    <td style="font-size: 22px;">
        <a href="fakultas.php?id=' . $div['mataKuliah_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="matakuliah.php?hapus=' . $div['mataKuliah_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($divisi->updateMatakuliah($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'matakuliah.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'matakuliah.php';
            </script>";
            }
        }

        $matakuliah->getMatakuliahById($id);
        $row = $matakuliah->getResult();

        $dataUpdate = $row['mataKuliah_nama'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($matakuliah->deleteMatakuliah($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'matakuliah.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'matakuliah.php';
            </script>";
        }
    }
}

$test = ' <a href="addmatakuliah.php" class="btn btn-primary mt-3">Tambah Mata Kuliah</a>';


$matakuliah->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('BUTTON', $test);
$view->write();
