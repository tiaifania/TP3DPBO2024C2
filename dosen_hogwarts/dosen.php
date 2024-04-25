<?php
include('config/db.php');
include('classes/DB.php');
include('classes/Dosen.php');
include('classes/Template.php');

// Buat instance objek Fakultas
$dosen = new Dosen($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$dosen->open();

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

?>