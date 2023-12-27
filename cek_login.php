<?php
session_start();
include "config/koneksi.php";
include "function/pesan_kilat.php";

$koneksi = new DatabaseConnection();
$username = $_POST['username'];
$password = $_POST['password'];

$filter = mysqli_query($koneksi->getConnection(), "SELECT * FROM user WHERE username='$username'");
$cek = mysqli_num_rows($filter);
$data = mysqli_fetch_array($filter);
if ($cek > 0) {
    if ($data['status'] == 'active') {
        // Check if the password is correct
        if (password_verify($password, $data['password'])) {
            if ($data['level'] == 'admin') {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $data['username'];
                $_SESSION['password'] = $data['password'];
                $_SESSION['level'] = 'admin';
                $_SESSION['id'] = $data['id'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
                $_SESSION['alamat'] = $data['alamat'];
                if ($username == $username && $password == $username) {
                    $alertMessage = "Anda masih menggunakan username dan password default. Silakan ganti password Anda untuk keamanan akun.";
                    echo "<script>alert('$alertMessage'); window.location.href = 'admin/';</script>";
                } else {
                    header('location:admin/');
                    exit();
                }
            } else if ($data['level'] == 'user') {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $data['username'];
                $_SESSION['level'] = 'user';
                $_SESSION['id'] = $data['id'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
                $_SESSION['alamat'] = $data['alamat'];
                if ($username == $username && $password == $username) {
                    $alertMessage = "Anda masih menggunakan username dan password default. Silakan ganti password Anda untuk keamanan akun.";
                    echo "<script>alert('$alertMessage'); window.location.href = 'user/';</script>";
                } else {
                    header('location:user/');
                    exit();
                }
            }
        } else {
            pesan('danger', 'Username atau password salah. Silakan coba lagi.');
            header("location:login.php");
            exit(); // Add exit() after the header redirect to stop further execution
        }
    } else {
        pesan('danger', 'Akun tidak aktif. Hubungi administrator.');
        header("location:login.php");
        exit(); // Add exit() after the header redirect to stop further execution
    }
} else {
    pesan('danger', 'Username atau password salah. Silakan coba lagi.');
    header("location:login.php");
    exit(); // Add exit() after the header redirect to stop further execution
}

// Tambahkan kode berikut untuk menampilkan pesan alert jika ada
if (isset($alertMessage)) {
    echo "<script>alert('$alertMessage')</script>";
}

// Pastikan untuk menutup koneksi setelah digunakan
$databaseConnection->closeConnection();
?>