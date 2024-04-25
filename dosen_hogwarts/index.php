<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Fakultas.php');
include('classes/Matakuliah.php');
include('classes/Dosen.php');
include('classes/Template.php');

// buat instance pengurus
$listDosen = new Dosen($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listDosen->open();
// tampilkan data pengurus
$listDosen->getDosenJoin();

// cari pengurus
if (isset($_POST['btn-cari'])) {
    // methode mencari data pengurus
    $listDosen->searchDosen($_POST['cari']);
} else {
    // method menampilkan data pengurus
    $listDosen->getDosenJoin();
}

$data = null;

// ambil data pengurus
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listDosen->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 pengurus-thumbnail">
        <a href="detail.php?id=' . $row['dosen_id'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['dosen_foto'] . '" class="card-img-top" alt="' . $row['dosen_foto'] . '">
            </div>
            <div class="card-body">
                <p class="card-text pengurus-nama my-0">' . $row['dosen_nama'] . '</p>
                <p class="card-text divisi-nama">' . $row['fakultas_nama'] . '</p>
                <p class="card-text jabatan-nama my-0">' . $row['mataKuliah_nama'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}


// tutup koneksi
$listDosen->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PENGURUS', $data);
$home->write();
