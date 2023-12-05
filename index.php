<?php
// Mulai sesi jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
if (!empty($_SESSION['level'])) {
    require 'config/koneksi.php';
    require 'function/pesan_kilat.php';

    // Jika sudah login, arahkan ke halaman sesuai dengan level
    if ($_SESSION['level'] === 'admin' && basename($_SERVER['PHP_SELF']) !== 'admin/index.php') {
        // Jika pengguna mencoba mengakses halaman admin tanpa login
        header("Location: admin/index.php");
        exit();
    } elseif ($_SESSION['level'] === 'user' && basename($_SERVER['PHP_SELF']) !== 'user/index.php') {
        // Jika pengguna mencoba mengakses halaman user tanpa login
        header("Location: user/index.php");
        exit();
    } elseif (basename($_SERVER['PHP_SELF']) === 'index.php' && empty($_SESSION['login_from_login'])) {
        // Jika pengguna mencoba mengakses index.php secara langsung tanpa login dari login.php, kembalikan ke halaman login
        header("Location: login.php");
        exit();
    }
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
?>
