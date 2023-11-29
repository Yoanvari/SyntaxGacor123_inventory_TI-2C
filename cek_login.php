<?php
session_start();
include "./config/koneksi.php";
include "function/pesan_kilat.php";
$username = $_POST['username'];
$password = $_POST['password'];

$filter = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($filter);
$data = mysqli_fetch_array($filter);

if ($cek > 0) {
    if ($data['level'] == 'admin') {
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = 'admin';
        $_SESSION['id'] = $data['id'];
        $_SESSION['email'] = $data['email'];
        
        header("location:admin/");
    } else if ($data['level'] == 'user') {
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = 'user';
        $_SESSION['id'] = $data['id'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        
        header("location:user/");
    } else {
        pesan('danger', 'Akun tidak valid. Silakan coba lagi.');
        header("location:login.php");
    }
} else {
    pesan('danger', 'Username atau password salah atau tidak ditemukan. Silakan coba lagi.');
    header("location:login.php");
}
?>
