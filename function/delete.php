<?php
include('koneksi.php'); // Make sure to include your database connection file

if (isset($_POST['updatebarang'])) {
    $id_barang = mysqli_real_escape_string($koneksi, $_POST['id_barang']);
    $namaBarang = mysqli_real_escape_string($koneksi, $_POST['namaBarang']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $foto = mysqli_real_escape_string($koneksi, $_POST['foto']);
    $asal = mysqli_real_escape_string($koneksi, $_POST['asal']);

    // Query to update barang
    $update_barang = mysqli_query($koneksi, "UPDATE barang SET namaBarang='$namaBarang', deskripsi='$deskripsi', stok='$stok', foto='$foto', asal='$asal' WHERE id_barang=$id_barang");

    if ($update_barang) {
        echo "Data barang berhasil diupdate.";
    } else {
        echo "Gagal update data barang: " . mysqli_error($koneksi);
    }
}
?>
