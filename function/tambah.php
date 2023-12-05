<?php
session_start(); // Pastikan session_start() dipanggil sebelum menggunakan $_SESSION
var_dump($_POST);
// Tambah barang
if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../function/pesan_kilat.php';
    require '../function/anti_injection.php';

    if (isset($_POST['addnewbarang'])) {
        $namaBarang = antiinjection($koneksi, $_POST['namaBarang']);
        $deskripsi = antiinjection($koneksi, $_POST['deskripsi']);
        $stok = antiinjection($koneksi, $_POST['stok']);

        // Tampilkan nilai variabel sebelum eksekusi query (untuk debugging)
        var_dump($namaBarang, $deskripsi, $stok);

        // Query SQL
        $addtotable = mysqli_query($koneksi, "INSERT INTO barang (namaBarang, deskripsi, stok) VALUES ('$namaBarang', '$deskripsi', '$stok')");
    
        if ($addtotable) {
            pesan('success', "Data Barang Baru Ditambahkan.");
        } else {
            pesan('danger', "Menambahkan Data Barang Gagal: " . mysqli_error($koneksi));
            echo "Query error: " . mysqli_error($koneksi); // Tampilkan pesan error
            die(mysqli_error($koneksi)); // Hentikan eksekusi skrip jika ada kesalahan
        }

        header("Location: ../admin/module/barang.php");
        exit(); // Pastikan exit() dipanggil setelah header redirect
    }
}
?>

