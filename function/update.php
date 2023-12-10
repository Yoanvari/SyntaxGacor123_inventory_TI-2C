<?php
session_start(); // Add session start
var_dump($_POST);

if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../function/pesan_kilat.php';
    require '../function/anti_injection.php';

    if (isset($_POST['editbarang'])) { // Change to 'editbarang'
        // Assuming the 'editNama' field exists in your form
        $idBarang = mysqli_real_escape_string($koneksi, $_POST['idBarang']);
        $namaBarang = mysqli_real_escape_string($koneksi, $_POST['editNama']);

        // Query to update barang
        $update_barang = mysqli_query($koneksi, "UPDATE barang SET namaBarang='$namaBarang' WHERE idBarang=$idBarang");

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
