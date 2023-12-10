<?php
session_start(); // Add session start
var_dump($_POST);

if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../function/pesan_kilat.php';
    require '../function/anti_injection.php';

    if (isset($_POST['editbarang'])) { // Change to 'editbarang'
        // Assuming the 'editNama' field exists in your form
        $gambar_barang = $_FILES['foto']['name'];
        $targetDirImg = $_SERVER['DOCUMENT_ROOT'] . '/dasarweb/inventory_JTI/SyntaxGacor123_inventory_TI-2C/img/';
        $tmpFile = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmpFile, $targetDirImg . $gambar_barang);
        $idBarang = mysqli_real_escape_string($koneksi, $_POST['idBarang']);
        $namaBarang = mysqli_real_escape_string($koneksi, $_POST['namaBarang']);
        $deskripsiBarang = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        $stokBarang = mysqli_real_escape_string($koneksi, $_POST['stok']);
        $asalBarang = mysqli_real_escape_string($koneksi, $_POST['asal']);
        $foto = mysqli_real_escape_string($koneksi, $gambar_barang);

        // Query to update barang
        $update_barang = mysqli_query($koneksi, "UPDATE barang SET namaBarang = '$namaBarang', stok = '$stokBarang', deskripsi = '$deskripsiBarang' , asal = '$asalBarang' , foto ='$foto'  WHERE idBarang = $idBarang");

        if ($update_barang) {
            echo "Data barang berhasil diupdate.";
            header('Location: ../admin/module/barang.php');
        } else {
            echo "Gagal update data barang: " . mysqli_error($koneksi);
        }
    }
} else {
    // Handle the case when the user is not logged in
    echo "You are not logged in.";
    // You might want to redirect the user to a login page or take appropriate action
}
