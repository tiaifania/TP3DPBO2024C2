<?php

class Dosen extends DB
{
    function getDosenJoin()
    {
        $query = "SELECT * FROM dosen JOIN fakultas ON dosen.fakultas_id=fakultas.fakultas_id JOIN matakuliah ON dosen.mataKuliah_id=matakuliah.mataKuliah_id ORDER BY dosen.dosen_id";

        return $this->execute($query);
    }

    function getDosen()
    {
        $query = "SELECT * FROM dosen";
        return $this->execute($query);
    }

    function getDosenById($id)
    {
        $query = "SELECT * FROM dosen JOIN fakultas ON dosen.fakultas_id=fakultas.fakultas_id JOIN matakuliah ON dosen.mataKuliah_id=matakuliah.mataKuliah_id WHERE dosen_id=$id";
        return $this->execute($query);
    }

    function searchDosen($keyword)
    {
        $query = "SELECT dosen.*, fakultas.fakultas_nama, matakuliah.matakuliah_nama FROM dosen 
                    JOIN fakultas ON dosen.fakultas_id = fakultas.fakultas_id 
                    JOIN matakuliah ON dosen.mataKuliah_id = matakuliah.mataKuliah_id 
                    WHERE dosen_nama LIKE '%$keyword%' OR matakuliah_nama LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addData($data, $file)
    {
        $dosen_nama = $data['dosen_nama'];
        $dosen_NIK = $data['dosen_NIK'];
        $fakultas_id = $data['fakultas_id'];
        $mataKuliah_id = $data['mataKuliah_id'];
        $dosen_foto = $file['dosen_foto']['name'];

        // Simpan file foto ke direktori tujuan
        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($dosen_foto);
        move_uploaded_file($file['dosen_foto']['tmp_name'], $target_file);
        
        // // Insert query
        // $query = "INSERT INTO dosen (dosen_nama, dosen_NIK, fakultas_id, mataKuliah_id) VALUES ('$dosen_nama', '$dosen_NIK', $fakultas_id, $mataKuliah_id)";
        // return $this->executeAffected($query);

        // Insert query
        $query = "INSERT INTO dosen (dosen_nama, dosen_foto, dosen_NIK, mataKuliah_id, fakultas_id) 
                  VALUES ('$dosen_nama', '$dosen_foto', '$dosen_NIK', $mataKuliah_id, $fakultas_id)";
        return $this->executeAffected($query);
    }

    function updateData($id, $data, $file)
    {
        // Ambil data dari $data array
        $dosen_nama = $data['dosen_nama'];
        $dosen_NIK = $data['dosen_NIK'];
        $mataKuliah_id = $data['mataKuliah_id'];
        $fakultas_id = $data['fakultas_id'];

        // Jika ada foto baru diunggah, simpan ke direktori tujuan
        if ($file['dosen_foto']['size'] > 0) {
            $foto = $file['dosen_foto']['name'];
            $target_dir = "assets/images/";
            $target_file = $target_dir . basename($foto);
            move_uploaded_file($file['dosen_foto']['tmp_name'], $target_file);

            // Update query dengan foto baru
            $query = "UPDATE dosen 
                      SET dosen_nama='$dosen_nama', dosen_foto='$foto', dosen_NIK='$dosen_NIK', mataKuliah_id=$mataKuliah_id, fakultas_id=$fakultas_id 
                      WHERE dosen_id=$id";
        } else {
            // Update query tanpa mengubah foto
            $query = "UPDATE dosen 
                      SET dosen_nama='$dosen_nama', dosen_NIK='$dosen_NIK', mataKuliah_id=$mataKuliah_id, fakultas_id=$fakultas_id 
                      WHERE dosen_id=$id";
        }

        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM dosen WHERE dosen_id=$id";
        return $this->executeAffected($query);
    }
}
