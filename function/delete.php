<?php
session_start();
include '../OOP/admin.php';

$Admin = new Admin();
require 'pesan_kilat.php';
if (isset($_GET['id']) && isset($_GET['type'])) {

    $id = $_GET['id'];
    $type = $_GET['type'];

    if ($type === 'barang') {
        // Query untuk menghapus barang berdasarkan ID

        $result = $Admin->deleteBarang($id);
        if ($result) {
            $Admin->pesan('success', "Data Anggaran Berhasil Dihapus.");
            header("Location: ../admin/module/barang.php");
        } else {
            $Admin->pesan('failed', "Data Barang Tidak Berhasil Ditambahkan.");
        }
        exit();
    }
} else if (isset($_GET['jenis']) == 'deleteAnggaran') {
    $data = $_POST;
    $addtotable_anggaran = $Admin->deleteAnggaran($data);
    echo $addtotable_anggaran;
    if ($addtotable_anggaran) {
        $Admin->pesan('success', "Data Anggaran Berhasil Dihapus.");
        header("Location: ../admin/module/anggaran.php");

    } else {
        $Admin->pesan('failed', "Data Anggaran Baru Tidak Berhasil Dihapus.");
    }
    exit();
} else {
    echo "Tipe data tidak valid.";
}

