<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";
include "function/pesan_kilat.php";
include "function/anti_injection.php";

// Ambil username dan password yang diinputkan oleh pengguna
$username = antiinjection($koneksi, $_POST['username']);
$password = antiinjection($koneksi, $_POST['password']);

// Query untuk mendapatkan informasi pengguna berdasarkan username
$query = "SELECT id, username, level, email, nama_lengkap, salt, password as hashed_password FROM user WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    mysqli_close($koneksi);

    if ($data) {
        $salt = $data['salt'];
        $hashed_password = $data['hashed_password'];

        if ($salt !== null && $hashed_password !== null) {
            // Kombinasikan salt dengan password yang diinputkan
            $combined_password = $salt . $password;

            // Verifikasi password
            if (password_verify($combined_password, $hashed_password)) {
                // Set session untuk pengguna yang berhasil login
                $_SESSION['id'] = $data['id'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['level'] = $data['level'];
                $_SESSION['email'] = $data['email'];

                if ($data['level'] == 'admin') {
                    $_SESSION['logged_in'] = true;
                    header("location:admin/");
                } else {
                    $_SESSION['logged_in_user'] = true;
                    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
                    header('location:user/');
                }
            } else {
                // Password tidak cocok
                pesan('danger', "Login gagal. Password Anda Salah.");
                header("Location: login.php");
            }
        } else {
            // Password atau salt tidak valid
            pesan('danger', "Login gagal. Password tidak valid.");
            header("Location: login.php");
        }
    } else {
        // Pengguna tidak ditemukan
        pesan('danger', "Login gagal. Pengguna tidak ditemukan.");
        header("Location: login.php");
    }
} else {
    // Kesalahan dalam mengakses data pengguna
    pesan('danger', "Terjadi kesalahan dalam mengakses data pengguna.");
    header("Location: login.php");
}
?>
