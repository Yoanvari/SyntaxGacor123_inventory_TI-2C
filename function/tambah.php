<?php
session_start();
var_dump($_POST);

if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../function/pesan_kilat.php';
    require '../function/anti_injection.php';

    if (isset($_POST['addnewbarang'])) {
        $gambar_barang = $_FILES['foto']['name'];
        $targetDirImg = $_SERVER['DOCUMENT_ROOT'] . '/dasarweb/inventory_JTI/SyntaxGacor123_inventory_TI-2C/img/';
        $tmpFile = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmpFile, $targetDirImg . $gambar_barang);
        $namaBarang = antiinjection($koneksi, $_POST['namaBarang']);
        $deskripsi = antiinjection($koneksi, $_POST['deskripsi']);
        $stok = antiinjection($koneksi, $_POST['stok']);
        $foto = antiinjection($koneksi, $gambar_barang);
        $asal = antiinjection($koneksi, $_POST['asal']); // Sesuaikan dengan nama elemen form

        var_dump($namaBarang, $deskripsi, $stok, $foto, $asal);

        // Query SQL untuk barang
        $addtotable_barang = mysqli_query($koneksi, "INSERT INTO barang (namaBarang, deskripsi, stok, foto, asal) VALUES ('$namaBarang', '$deskripsi', '$stok', '$foto', '$asal')");

        if ($addtotable_barang) {
            pesan('success', "Data Barang Baru Ditambahkan.");
        } else {
            pesan('danger', "Menambahkan Data Barang Gagal: " . mysqli_error($koneksi));
            echo "Query error: " . mysqli_error($koneksi);
            die(mysqli_error($koneksi));
        }

        header("Location: ../admin/module/barang.php");
        exit();
    }

    if (isset($_POST['addnewanggaran'])) {
        $asal = antiinjection($koneksi, $_POST['asal']);

        var_dump($asal);

        // Query SQL untuk anggaran
        $addtotable_anggaran = mysqli_query($koneksi, "INSERT INTO anggaran (asal) VALUES ('$asal')");

        if ($addtotable_anggaran) {
            pesan('success', "Data Anggaran Baru Ditambahkan.");
        } else {
            pesan('danger', "Menambahkan Data Anggaran Gagal: " . mysqli_error($koneksi));
            echo "Query error: " . mysqli_error($koneksi);
            die(mysqli_error($koneksi));
        }

        header("Location: ../admin/module/barang.php");
        exit();
    }
}
