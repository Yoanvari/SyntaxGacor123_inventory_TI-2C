<?php
session_start();
include "config/koneksi.php";
include "function/pesan_kilat.php";

class LoginController
{
    private $koneksi;

    public function __construct()
    {
        $this->koneksi = new DatabaseConnection();
    }

    public function login($username, $password)
    {
        $filter = mysqli_query($this->koneksi->getConnection(), "SELECT * FROM user WHERE username='$username'");
        $cek = mysqli_num_rows($filter);
        $data = mysqli_fetch_array($filter);

        if ($cek > 0) {
            if ($data['status'] == 'active' && password_verify($password, $data['password'])) {
                if ($data['level'] == 'admin') {
                    $this->setAdminSession($data);
                } else if ($data['level'] == 'user') {
                    $this->setUserSession($data);
                }
            } else {
                pesan('danger', 'Username atau password salah. Silakan coba lagi.');
                header("location:login.php");
                exit();
            }
        } else {
            pesan('danger', 'Username atau password salah. Silakan coba lagi.');
            header("location:login.php");
            exit();
        }
    }

    private function setAdminSession($data)
    {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['password'] = $data['password'];
        $_SESSION['level'] = 'admin';
        $_SESSION['id'] = $data['id'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['alamat'] = $data['alamat'];

        if ($data['username'] == $data['password']) {
            $alertMessage = "Anda masih menggunakan username dan password default. Silakan ganti password Anda untuk keamanan akun.";
            echo "<script>alert('$alertMessage'); window.location.href = 'admin/';</script>";
        } else {
            header('location:admin/');
            exit();
        }
    }

    private function setUserSession($data)
    {
        $_SESSION['logged_in_user'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = 'user';
        $_SESSION['id'] = $data['id'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['alamat'] = $data['alamat'];

        if ($data['username'] == $data['password']) {
            $alertMessage = "Anda masih menggunakan username dan password default. Silakan ganti password Anda untuk keamanan akun.";
            echo "<script>alert('$alertMessage'); window.location.href = 'user/';</script>";
        } else {
            header('location:user/');
            exit();
        }
    }
}

// Gunakan kelas LoginController
$loginController = new LoginController();
$loginController->login($_POST['username'], $_POST['password']);

// Pastikan untuk menutup koneksi setelah digunakan
$databaseConnection->closeConnection();
?>