<?php

class Matakuliah extends DB
{
    function getMatakuliah()
    {
        $query = "SELECT * FROM matakuliah";
        return $this->execute($query);
    }

    function getMatakuliahById($id)
    {
        $query = "SELECT * FROM matakuliah WHERE mataKuliah_id=$id";
        return $this->execute($query);
    }

    function addMatakuliah($data)
    {
        $matakuliah_nama = $data['mataKuliah_nama'];
        
        // Insert query
        $query = "INSERT INTO matakuliah (mataKuliah_nama) VALUES ('$matakuliah_nama')";
        return $this->execute($query);
    }

    function updateMatakuliah($id, $data)
    {
        $matakuliah_nama = $data['mataKuliah_nama'];
        
        // Update query
        $query = "UPDATE matakuliah SET mataKuliah_nama='$matakuliah_nama' WHERE jabatan_id=$id";
        return $this->execute($query);

    }

    function deleteMatakuliah($id)
    {
        $query = "DELETE FROM matakuliah WHERE mataKuliah_id=$id";
        return $this->execute($query);
    }
}
