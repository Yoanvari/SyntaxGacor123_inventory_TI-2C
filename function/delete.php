<?php
session_start();

// Include file koneksi.php dan fungsi-fungsi lainnya
require '../config/koneksi.php';
require '../function/pesan_kilat.php';
require '../function/anti_injection.php';

// Mendapatkan nilai $id_barang dari formulir POST atau sumber data lainnya
$id_barang = isset($_POST['id_barang']) ? $_POST['id_barang'] : null;

// Mengeksekusi fungsi deleteBarang dengan AJAX jika $id_barang sudah terdefinisi
if (isset($id_barang) && isset($_POST['deleteBarang'])) {
    deleteBarang($koneksi, $id_barang);
}

// Fungsi untuk menghapus data barang
function deleteBarang($koneksi, $id_barang) {
    // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt = mysqli_prepare($koneksi, "DELETE FROM barang WHERE idBarang = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_barang);

    if (mysqli_stmt_execute($stmt)) {
        echo "Data barang berhasil dihapus.";
    } else {
        echo "Gagal menghapus data barang: " . mysqli_error($koneksi);
    }

    // Menutup statement
    mysqli_stmt_close($stmt);
}
?>
