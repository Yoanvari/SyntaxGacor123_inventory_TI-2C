<?php
include('../config/koneksi.php');
$koneksi = new DatabaseConnection();
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    if ($type === 'barang') {
        // Query untuk menghapus barang berdasarkan ID
        $sql = "DELETE FROM barang WHERE idBarang='$id'";
        $result = mysqli_query($koneksi->getConnection(), $sql);

        if ($result) {
            echo "Data barang berhasil dihapus.";
            header('Location: http://localhost:3000/admin/module/barang.php');
            exit();
        } else {
            echo "Gagal menghapus data barang: " . mysqli_error($koneksi->getConnection());
        }
    } elseif ($type === 'anggaran') {
        // Query untuk menghapus anggaran berdasarkan ID
        $sql = "DELETE FROM anggaran WHERE idAnggaran='$id'";
        $result = mysqli_query($koneksi->getConnection(), $sql);

        if ($result) {
            echo "Data anggaran berhasil dihapus.";
            header('Location: ../admin/module/anggaran.php');
            exit();
        } else {
            echo "Gagal menghapus data anggaran: " . mysqli_error($koneksi->getConnection());
        }
    } else {
        echo "Tipe data tidak valid.";
    }
} else {
    echo "ID atau tipe data tidak valid.";
}
