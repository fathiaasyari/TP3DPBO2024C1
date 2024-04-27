<?php

class Produk extends DB
{
    function uploadGambar($file) {
        $targetDir = "assets/images/";
        $targetFile = $targetDir . basename($file["gambar_produk"]['name']);

        if (move_uploaded_file($file["gambar_produk"]["tmp_name"], $targetFile)) {
            return basename($file["gambar_produk"]['name']);
        } else {
            return "";
        }
    }

    function getProduk($search = "", $sortColumn = 'nama_produk', $sortOrder = 'asc')
    {
        $where = "";
        if (!empty($search)) {
            $where = " WHERE nama_produk LIKE '%" . $search . "%' OR
                           deskripsi LIKE '%" . $search . "%' OR
                           harga LIKE '%" . $search . "%'";
        }

        $allowedSortColumns = ['nama_produk', 'harga', 'deskripsi'];
        $sortColumn = in_array($sortColumn, $allowedSortColumns) ? $sortColumn : 'nama_produk';
        $sortOrder = $sortOrder === 'desc' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM produk" . $where . " ORDER BY " . $sortColumn . " " . $sortOrder;
        return $this->execute($query);
    }

    function getProdukById($id)
    {
        $query = "SELECT * FROM produk WHERE id_produk=$id";
        return $this->execute($query);
    }

    function addProduk($data)
    {
        $nama = $data['nama_produk'];
        $harga = $data['harga'];
        $deskripsi = $data['deskripsi'];
        $id_penjual = $data['id_penjual'];
        $id_kategori = $data['id_kategori'];
        
        if (!empty($data["gambar_produk"]['name'])) {
            $gambar_produk = $this->uploadGambar($data);
            $query = "INSERT INTO Produk (nama_produk, harga, deskripsi, gambar_produk, id_penjual, id_kategori) VALUES ('$nama', '$harga', '$deskripsi', '$gambar_produk', '$id_penjual', '$id_kategori')";
        } else {
            $query = "INSERT INTO Produk (nama_produk, harga, deskripsi, id_penjual, id_kategori) VALUES ('$nama', '$harga', '$deskripsi', '-', '$id_penjual', '$id_kategori')";
        }
        return $this->executeAffected($query);
    }

    function updateProduk($id, $data)
    {
        $nama = $data['nama_produk'];
        $harga = $data['harga'];
        $deskripsi = $data['deskripsi'];
        $id_penjual = $data['id_penjual'];
        $id_kategori = $data['id_kategori'];

        if (!empty($data["gambar_produk"]['name'])) {
            $gambar_produk = $this->uploadGambar($data);
            $query = "UPDATE Produk SET nama_produk='$nama', harga='$harga', deskripsi='$deskripsi', gambar_produk='$gambar_produk', id_penjual='$id_penjual', id_kategori='$id_kategori' WHERE id_produk=$id";
        } else {
            $query = "UPDATE Produk SET nama_produk='$nama', harga='$harga', deskripsi='$deskripsi', id_penjual='$id_penjual', id_kategori='$id_kategori' WHERE id_produk=$id";
        }

        return $this->executeAffected($query);
    }

    function deleteProduk($id)
    {
        $query = "DELETE FROM produk WHERE id_produk=$id";
        return $this->executeAffected($query);
    }
}
?>
