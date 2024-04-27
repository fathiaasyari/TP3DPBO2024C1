<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Produk.php');
include('classes/Template.php');


$search = $_GET['search'] ?? '';
$sortColumn = $_GET['sortColumn'] ?? 'nama_produk';
$sortOrder = $_GET['sortOrder'] ?? 'asc';

// buat instance produk
$listProduk = new Produk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listProduk->open();

// tampilkan data produk
$listProduk->getProduk($search, $sortColumn, $sortOrder);


$data = null;

// ambil data produk
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listProduk->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 produk-thumbnail">
        <a href="detail_produk.php?id=' . $row['id_produk'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['gambar_produk'] . '" class="card-img-top" alt="' . $row['gambar_produk'] . '">
            </div>
            <div class="card-body">
                <p class="card-text produk-nama my-0">' . $row['nama_produk'] . '</p>
                <p class="card-text produk-harga">' . $row['harga'] . '</p>
                <p class="card-text produk-deskripsi my-0">' . $row['deskripsi'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}


// tutup koneksi
$listProduk->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PRODUK', $data);
$home->replace('DATA_FORM_SEARCH', '
    <form class="d-flex justify-content-between align-items-center mb-3">
        <input class="form-control me-2" type="text" placeholder="Cari Produk" aria-label="Search" name="search" value="' . (isset($_GET['search']) ? $_GET['search'] : '') . '" />
        <select class="form-select me-2" name="sortColumn">
            <option value="nama_produk" ' . (isset($_GET['sortColumn']) && $_GET['sortColumn'] == "nama_produk" ? "selected" : "") . '>Nama Produk</option>
            <option value="harga" ' . (isset($_GET['sortColumn']) && $_GET['sortColumn'] == "harga" ? "selected" : "") . '>Harga</option>
            <option value="deskripsi" ' . (isset($_GET['sortColumn']) && $_GET['sortColumn'] == "deskripsi" ? "selected" : "") . '>Deskripsi</option>
        </select>
        <select class="form-select me-2" name="sortOrder">
            <option value="asc" ' . (isset($_GET['sortOrder']) && $_GET['sortOrder'] == "asc" ? "selected" : "") . '>Ascending</option>
            <option value="desc" ' . (isset($_GET['sortOrder']) && $_GET['sortOrder'] == "desc" ? "selected" : "") . '>Descending</option>
        </select>
        <button class="btn btn-outline-light" type="submit">Search</button>
    </form>
');
$home->write();
