<?php

class KategoriProduk extends DB
{
    function getKategoriProduk($search = "", $sort = "asc")
    {
        $where = "";
        if (!empty($search)) {
            $where = "WHERE nama_kategori LIKE '" . "%" . $search . "%'";
        }

        $orderBy = "ORDER BY nama_kategori ";
        if ($sort === "desc") {
            $orderBy .= "DESC";
        } else {
            $orderBy .= "ASC";
        }

        $query = "SELECT * FROM kategori_produk " . $where . " " . $orderBy;
        
        return $this->execute($query);
    }

    function getKategoriProdukById($id)
    {
        $query = "SELECT * FROM kategori_produk WHERE id_kategori=$id";
        return $this->execute($query);
    }

    function addKategoriProduk($data)
    {
        $nama = $data['nama_kategori'];
        $query = "INSERT INTO kategori_produk (nama_kategori) VALUES ('$nama')";
        return $this->executeAffected($query);
    }

    function updateKategoriProduk($id, $data)
    {
        $nama = $data['nama_kategori'];
        $query = "UPDATE kategori_produk SET nama_kategori='$nama' WHERE id_kategori=$id";
        return $this->executeAffected($query);
    }

    function deleteKategoriProduk($id)
    {
        $query = "DELETE FROM kategori_produk WHERE id_kategori=$id";
        return $this->executeAffected($query);
    }
}
?>
