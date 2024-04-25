<?php

// Include file konfigurasi dan kelas yang diperlukan
include('config/db.php');
include('classes/DB.php');
include('classes/Dosen.php');
include('classes/Fakultas.php');
include('classes/Matakuliah.php');

// Ambil parameter 'tabel' dari URL
if(isset($_GET['tabel'])) {
    $tabel = $_GET['tabel'];

    // Buat instance objek Database
    $db = new DB($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $db->open();

    // Cek apakah form telah disubmit
    if(isset($_POST['submit'])) {
        // Tambahkan data sesuai dengan tabel yang ditentukan
        switch($tabel) {
            case 'dosen':
                // Buat instance objek Dosen
                $dosen = new Dosen($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
                $dosen->open();
                
                // Tambahkan data untuk tabel dosen
                if($dosen->addData($_POST, $_FILES) > 0) {
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
                // Tutup koneksi database Dosen
                $dosen->close();
                break;
                
            case 'fakultas':
                // Buat instance objek Fakultas
                $fakultas = new Fakultas($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
                $fakultas->open();

                // Tambahkan data untuk tabel fakultas
                if($fakultas->addFakultas($_POST) > 0) {
                    echo "<script>
                        alert('Data fakultas berhasil ditambah!');
                        document.location.href = 'index.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Data fakultas gagal ditambah!');
                        document.location.href = 'index.php';
                    </script>";
                }
                // Tutup koneksi database Fakultas
                $fakultas->close();
                break;

            case 'matakuliah':
                // Buat instance objek Matakuliah
                $matakuliah = new Matakuliah($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
                $matakuliah->open();

                // Tambahkan data untuk tabel matakuliah
                if($matakuliah->addMatakuliah($_POST) > 0) {
                    echo "<script>
                        alert('Data matakuliah berhasil ditambah!');
                        document.location.href = 'index.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Data matakuliah gagal ditambah!');
                        document.location.href = 'index.php';
                    </script>";
                }
                // Tutup koneksi database Matakuliah
                $matakuliah->close();
                break;

            default:
                // Tidak ada tindakan yang diambil jika tabel tidak ditemukan atau tidak sesuai
                break;
        }
    }

    // Tutup koneksi database
    $db->close();
}

// Setelah menambahkan data, Anda bisa mengarahkan pengguna ke halaman yang sesuai.
// Misalnya, Anda bisa mengarahkan pengguna kembali ke halaman utama setelah menambah data.
header('Location: index.php');
exit();

?>
