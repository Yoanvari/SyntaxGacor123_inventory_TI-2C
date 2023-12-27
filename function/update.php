<?php
session_start();
include '../OOP/admin.php';
$Admin = new Admin();


if (!empty($_SESSION['username'])) {

    require 'pesan_kilat.php';
    require 'anti_injection.php';

    if (isset($_GET['jenis']) && $_GET['jenis'] == 'updateBarang') {

        $data = $_POST;
        $addtotable_barang = $Admin->updateBarang($data);

        if ($addtotable_barang) {
            $Admin->pesan('success', "Data Barang Baru Diupdate.");
            header("Location: ../admin/module/barang.php");
        } else {
            $Admin->pesan('failed', "Data Barang Baru Tidak Berhasil Diupdate.");
        }
    } else if (isset($_GET['jenis']) && $_GET['jenis'] == 'updateAnggaran') {

        $data = $_POST;
        $addtotable_anggaran = $Admin->updateAnggaran($data);

        if ($addtotable_anggaran) {
            $Admin->pesan('success', "Data Anggaran Baru Diupdate.");
            header("Location: ../admin/module/anggaran.php");
        } else {
            $Admin->pesan('failed', "Data Anggaran Baru Tidak Berhasil Diupdate.");
        }
        exit();
    } else if (isset($_GET['jenis']) && $_GET['jenis'] == 'updateUser') {

        $data = $_POST;
        $addtotable_user = $Admin->updateUser($data);

        if ($addtotable_user) {
            $Admin->pesan('success', "Data User Berhasil Diupdate.");
            header("Location: ../admin/module/list_user/list.php");
        } else {
            $Admin->pesan('failed', "Data User Tidak Berhasil Diupdate.");
        }
        exit();
    } else if (isset($_GET['jenis']) && $_GET['jenis'] == 'updateProfile') {

        $data = $_POST;
        $addtotable_profile = $Admin->updateProfile($data);

        if ($addtotable_profile) {
            // $Admin->pesan('success', "Profile Berhasil Diupdate.");
            $_SESSION['alert'] = array('type' => 'success', 'message' => 'Profile Berhasil Diupdate.');
            // untuk admin
            header("Location: ../user/profile/profile.php");
            // untuk user
            header("Location: ../user/data/profile/profile.php");
        } else {
            // $Admin->pesan('failed', "Profile Tidak Berhasil Diupdate.");
            $_SESSION['alert'] = array('type' => 'failed', 'message' => 'Profile Tidak Berhasil Diupdate.');
        }
        exit();
    }
} else {
    echo "Anda tidak masuk.";
}
