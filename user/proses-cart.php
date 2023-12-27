<?php
require_once '../OOP/Pengguna.php';
require_once '../OOP/barang.php';
require_once '../OOP/Cart.php';
session_start();
$idUser = $_SESSION['id'];
require_once '../OOP/auth.php';
$koneksi = new DatabaseConnection();
$prosesCart = new Pengguna($koneksi);
$barang = new barang($koneksi);
$cart = new Cart();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $prosesCart->countCart($idUser,$cart);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['proses']) {
        case 'add':
            $id = $_POST['id'];
            $prosesCart->addCart($idUser,$id,$barang,$cart);
            break;
        case 'minus':
            $id = $_POST['id'];
            $prosesCart->minusCart($idUser,$id,$cart);
            break;
        case 'plus':
            $id = $_POST['id'];
            $prosesCart->plusCart($idUser,$id,$cart);
            break;
        case 'pinjam':
            $prosesCart->pinjamCart($idUser,$cart,$barang);
            break;
        case 'hapusPinjam':
            $id = $_POST['id'];
            $prosesCart->hapusPinjam($id,$barang);
            break;
        case 'kembalikan':
            $id = $_POST['id'];
            $prosesCart->kembalikan($id,$barang);
            break;
        case 'approve':
            $id = $_POST['id'];
            $prosesCart->approve($id,$barang);
            break;
        case 'reject':
            $id = $_POST['id'];
            $prosesCart->reject($id,$barang);
            break;
    }
}