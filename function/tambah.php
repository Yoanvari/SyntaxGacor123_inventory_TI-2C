<?php
session_start();
var_dump($_POST);
include '../OOP/admin.php';
$Admin = new Admin();

if (!empty($_SESSION['username'])) {

    require 'pesan_kilat.php';
    require 'anti_injection.php';

    if (isset($_GET['jenis']) && $_GET['jenis'] == 'tambahBarang') {
        echo $_POST['asal'];
        $data = $_POST;
        $addtotable_barang = $Admin->tambahBarang($data);
        if ($addtotable_barang) {
            $Admin->pesan('success', "Data  Baru Barang Ditambahkan.");
            header("Location: ../admin/module/barang.php");
        } else {
            $Admin->pesan('failed', "Data Barang Tidak Berhasil Ditambahkan.");
        }
        exit();
    } else if (isset($_GET['jenis']) && $_GET['jenis'] == 'tambahAnggaran') {
        $data = $_POST;
        $addtotable_anggaran = $Admin->tambahAnggaran($data);
        if ($addtotable_anggaran) {
            $Admin->pesan('success', "Data Anggaran Baru Ditambahkan.");
            header("Location: ../admin/module/anggaran.php");
        } else {
            $Admin->pesan('failed', "Data Anggaran Tidak Berhasil Ditambahkan.");
        }
        exit();
    } else if (isset($_GET['jenis']) && $_GET['jenis'] == 'tambahUser') {
        $data = $_POST;
        $addtotable_user = $Admin->tambahUser($data);
        if ($addtotable_user) {
            $Admin->pesan('success', "Data User Baru Ditambahkan.");
            header("Location: ../admin/module/list_user/list.php");
        } else {
            $Admin->pesan('failed', "Data User Tidak Berhasil Ditambahkan.");
        }
        exit();
    }
}

