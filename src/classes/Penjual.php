<?php

class Penjual extends DB
{
    function getPenjual($search = "", $sortColumn = 'nama_penjual', $sortOrder = 'asc')
    {
        $where = "";
        if (!empty($search)) {
            $where = " WHERE nama_penjual LIKE '%" . $search . "%' OR 
                           alamat_penjual LIKE '%" . $search . "%' OR 
                           email LIKE '%" . $search . "%' OR 
                           telepon LIKE '%" . $search . "%'";
        }

        $allowedSortColumns = ['nama_penjual', 'alamat_penjual', 'email', 'telepon'];
        $sortColumn = in_array($sortColumn, $allowedSortColumns) ? $sortColumn : 'nama_penjual';
        $sortOrder = $sortOrder === 'desc' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM penjual" . $where . " ORDER BY " . $sortColumn . " " . $sortOrder;

        return $this->execute($query);
    }

    function getPenjualById($id)
    {
        $query = "SELECT * FROM penjual WHERE id_penjual=$id";
        return $this->execute($query);
    }

    function addPenjual($data)
    {
        $nama_penjual = $data['nama_penjual'];
        $alamat_penjual = $data['alamat_penjual'];
        $telepon = $data['telepon'];
        $email = $data['email'];
        $query = "INSERT INTO penjual (nama_penjual, alamat_penjual, telepon, email) VALUES ('$nama_penjual', '$alamat_penjual', '$telepon', '$email')";
        return $this->executeAffected($query);
    }

    function updatePenjual($id, $data)
    {
        $nama_penjual = $data['nama_penjual'];
        $alamat_penjual = $data['alamat_penjual'];
        $telepon = $data['telepon'];
        $email = $data['email'];
        $query = "UPDATE penjual SET nama_penjual='$nama_penjual', alamat_penjual='$alamat_penjual', telepon='$telepon', email='$email' WHERE id_penjual=$id";
        return $this->executeAffected($query);
    }

    function deletePenjual($id)
    {
        $query = "DELETE FROM penjual WHERE id_penjual=$id";
        return $this->executeAffected($query);
    }
}
?>
