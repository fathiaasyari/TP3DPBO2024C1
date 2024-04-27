<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Produk.php');
include('classes/Template.php');

$produk = new Produk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$produk->open();

$data = null;

$actionButtons = '';

$id = @$_GET['id'];
if ($id > 0) {
    $produk->getProdukById($id);
    $row = $produk->getResult();
}
$data .= '
    <div class="card-body text-end">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group row mb-4">
                <label for="nama_produk" class="col-sm-3 col-form-label">Nama Produk</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="' . @$row['nama_produk'] . '">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="harga" class="col-sm-3 col-form-label">Harga</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="harga" name="harga" value="' . @$row['harga'] . '">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="deskripsi" name="deskripsi">' . @$row['deskripsi'] . '</textarea>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="gambar_produk" class="col-sm-3 col-form-label">Gambar Produk</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="gambar_produk" name="gambar_produk">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="id_penjual" class="col-sm-3 col-form-label">ID Penjual</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="id_penjual" name="id_penjual" value="' . @$row['id_penjual'] . '">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="id_kategori" class="col-sm-3 col-form-label">ID Kategori</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="id_kategori" name="id_kategori" value="' . @$row['id_kategori'] . '">
                </div>
            </div>
            <div class="form-group row mb-4">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary" name="' . ($id ? 'update' : 'tambah') . '">Update</button>
                </div>
            </div>
        </form>
    </div>';

if (isset($_POST['tambah'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $id_penjual = $_POST['id_penjual'];
    $id_kategori = $_POST['id_kategori'];

    $produk->addProduk([
        'nama_produk' => $nama_produk,
        'harga' => $harga,
        'deskripsi' => $deskripsi,
        'id_penjual' => $id_penjual,
        'id_kategori' => $id_kategori,
        'gambar_produk' => $_FILES['gambar_produk']
    ]);
    header("Location: index.php");
}

if (isset($_POST['update'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $id_penjual = $_POST['id_penjual'];
    $id_kategori = $_POST['id_kategori'];

    $produk->updateProduk($id, [
        'nama_produk' => $nama_produk,
        'harga' => $harga,
        'deskripsi' => $deskripsi,
        'id_penjual' => $id_penjual,
        'id_kategori' => $id_kategori,
        'gambar_produk' => $_FILES['gambar_produk']
    ]);
    header("Location: index.php");
}

$produk->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL', $data);
$detail->write();
?>
