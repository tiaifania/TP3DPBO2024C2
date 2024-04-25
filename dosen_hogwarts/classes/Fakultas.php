<?php

class Fakultas extends DB
{
    function getFakultas()
    {
        $query = "SELECT * FROM fakultas";
        return $this->execute($query);
    }

    function getFakultasById($id)
    {
        $query = "SELECT * FROM fakultas WHERE fakultas_id=$id";
        return $this->execute($query);
    }

    function addFakultas($data)
    {
        $fakultas_nama = $data['fakultas_nama'];
        $query = "INSERT INTO fakultas VALUES('', '$fakultas_nama')";
        return $this->executeAffected($query);
    }

    function updateFakultas($id, $data)
    {
        $fakultas_nama = $data['fakultas_nama'];
        
        // Update query
        $query = "UPDATE fakultas SET fakultas_nama='$fakultas_nama' WHERE fakultas_id=$id";
        return $this->executeAffected($query);
    }

    function deleteFakultas($id)
    {
        $query = "DELETE FROM fakultas WHERE fakultas_id=$id";
        return $this->executeAffected($query);
    }
}
