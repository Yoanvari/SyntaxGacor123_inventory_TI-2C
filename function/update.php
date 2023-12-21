<?php
session_start(); // Memulai sesi
// var_dump($_POST);

if (!empty($_SESSION['username'])) {

    require '../config/koneksi.php';
    require '../function/pesan_kilat.php';
    require '../function/anti_injection.php';
    if (isset($_POST['editbarang'])) {

        $idBarang = mysqli_real_escape_string($koneksi, $_POST['idBarang']);
        $namaBarang = mysqli_real_escape_string($koneksi, $_POST['namaBarang']);
        $deskripsiBarang = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        $stokBarang = mysqli_real_escape_string($koneksi, $_POST['stok']);
        $asalBarang = mysqli_real_escape_string($koneksi, $_POST['asal']);
        $tahun_penerimaan = mysqli_real_escape_string($koneksi, $_POST['tahun_penerimaan']);

        // File Upload
        $gambar_barang = $_FILES['foto']['name'];
        $tmpFile = $_FILES['foto']['tmp_name'];
        $targetDirImg = "../../img/";

        // Periksa apakah direktori target ada dan buat jika belum ada
        if (!file_exists($targetDirImg)) {

            mkdir($targetDirImg, 0755, true);
        }

        move_uploaded_file($tmpFile, $targetDirImg . $gambar_barang);

        // Query Update
        $query = "UPDATE barang SET namaBarang = '$namaBarang', deskripsi = '$deskripsiBarang', stok = '$stokBarang', asal = '$asalBarang', tahun_penerimaan = '$tahun_penerimaan', foto = '$gambar_barang' WHERE idBarang = $idBarang";

        $update_barang = mysqli_query($koneksi, $query);

        if ($update_barang) {

            echo "Data barang berhasil diupdate.";
            header('Location: ../admin/module/barang.php');
        } else {
            echo "Gagal update data barang: " . mysqli_error($koneksi);
        }
    } else if (isset($_POST['editanggaran'])) {

        $idAnggaran = mysqli_real_escape_string($koneksi, $_POST['idAnggaran']);
        $asalAnggaran = mysqli_real_escape_string($koneksi, $_POST['asal']);
        $tahun_penerimaan = mysqli_real_escape_string($koneksi, $_POST['tahun_penerimaan']);

        $update_anggaran = mysqli_query($koneksi, "UPDATE anggaran SET asal = '$asalAnggaran', tahun_penerimaan = '$tahun_penerimaan' WHERE idAnggaran = $idAnggaran");

        if ($update_anggaran) {
            echo 'f';
            echo "Data anggaran berhasil diupdate.";
            header('Location: ../admin/module/anggaran.php'); // Change the location accordingly
        } else {
            echo "Gagal update data anggaran: " . mysqli_error($koneksi);
        }
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['editUser'])) {
            echo 'h';
            $id = $_POST['id'];
            $nama_lengkap = $_POST['nama_lengkap'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $alamat = $_POST['alamat'];
            $status = $_POST['status'];

            // Perform the update query
            $query = "UPDATE user SET 
                nama_lengkap = '$nama_lengkap', 
                email = '$email', 
                username = '$username', 
                alamat = '$alamat', 
                status = '$status' 
                WHERE id = $id";

            $result = mysqli_query($koneksi, $query);

            if ($result) {
                echo 'i';
                // Redirect to the page where you display the users
                header("Location: ../admin/module/list_user/list.php");
                exit();
            } else {
                echo "Error updating user: " . mysqli_error($koneksi);
            }
        } else if (isset($_POST['editProfile'])) {
            // echo 'k';
            // var_dump($_POST);
            // die();
            $id = $_POST['id'];
            $email = $_POST['email'];
            $alamat = $_POST['alamat'];
            $password = md5($_POST['password']);

            // Perform the update query
            $query = "UPDATE user SET email = '$email', alamat = '$alamat', password = '$password' WHERE id = $id";

            $result = mysqli_query($koneksi, $query);

            if ($result) {
                echo 'l';
                // Redirect to the page where you display the users
                header("Location: ../admin/module/profile/editProfile.php");
                exit();
            } else {
                echo "Error updating user: " . mysqli_error($koneksi);
            }
        }
    }
} else {
    echo "Anda tidak masuk.";
    // Mungkin ingin mengarahkan pengguna ke halaman login atau mengambil tindakan yang sesuai
}
