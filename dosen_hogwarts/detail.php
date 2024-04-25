<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Fakultas.php');
include('classes/Matakuliah.php');
include('classes/Dosen.php');
include('classes/Template.php');

$dosen = new Dosen($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$dosen->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $dosen->getDosenById($id);
        $row = $dosen->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['dosen_nama'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['dosen_foto'] . '" class="img-thumbnail" alt="' . $row['dosen_foto'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['dosen_nama'] . '</td>
                                </tr>
                                <tr>
                                    <td>NIM</td>
                                    <td>:</td>
                                    <td>' . $row['dosen_NIK'] . '</td>
                                </tr>
                                <tr>
                                    <td>mata kuliah</td>
                                    <td>:</td>
                                    <td>' . $row['mataKuliah_nama'] . '</td>
                                </tr>
                                <tr>
                                    <td>Fakultas</td>
                                    <td>:</td>
                                    <td>' . $row['fakultas_nama'] . '</td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="editdosen.php"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="detail.php?hapus=' . $row['dosen_id'] . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        // Hapus data fakultas berdasarkan id
        if ($dosen->deleteData($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

$dosen->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PENGURUS', $data);
$detail->write();
