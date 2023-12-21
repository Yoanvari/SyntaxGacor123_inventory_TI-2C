<?php
session_start();
var_dump($_POST);

if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../function/pesan_kilat.php';
    require '../function/anti_injection.php';

    if (isset($_POST['addnewbarang'])) {
        $kdBarang = antiinjection($koneksi, $_POST['kdBarang']);
        $namaBarang = antiinjection($koneksi, $_POST['namaBarang']);
        $deskripsi = antiinjection($koneksi, $_POST['deskripsi']);
        $stok = antiinjection($koneksi, $_POST['stok']);
        $gambar_barang = $_FILES['foto']['name'];
        $tmpFile = $_FILES['foto']['tmp_name'];
        $targetDirImg = $_SERVER['DOCUMENT_ROOT'] . '../img/';
        move_uploaded_file($tmpFile, $targetDirImg . $gambar_barang);
        $foto = antiinjection($koneksi, $gambar_barang);
        $asal = antiinjection($koneksi, $_POST['asal']);
        $tahun_penerimaan = antiinjection($koneksi, $_POST['tahun_penerimaan']);

        // Check if kdBarang already exists
        $checkDuplicate = mysqli_query($koneksi, "SELECT * FROM barang WHERE kdBarang='$kdBarang'");
        if (mysqli_num_rows($checkDuplicate) > 0) {
            $alertMessage = "Kode Barang " . htmlspecialchars($kdBarang) . " sudah ada. Silakan pilih Kode Barang lain.";
            echo "<script>alert('$alertMessage');</script>";
            echo "<script>$('#myModal').modal('show');</script>"; // Menampilkan kembali modal tambah barang
            exit(); // Hentikan eksekusi script PHP
        }

        // Query SQL for barang
        $addtotable_barang = mysqli_query($koneksi, "INSERT INTO barang (kdBarang, namaBarang, deskripsi, stok, foto, asal, tahun_penerimaan) VALUES ('$kdBarang', '$namaBarang', '$deskripsi', '$stok', '$foto', '$asal', '$tahun_penerimaan')");
        if ($addtotable_barang) {
            pesan('success', "Data Barang Baru Ditambahkan.");
        } else {
            pesan('danger', "Menambahkan Data Barang Gagal: " . mysqli_error($koneksi));
            echo "Query error: " . mysqli_error($koneksi);
            die(mysqli_error($koneksi));
        }

        header("Location: ../admin/module/barang.php");
        exit();
    } else if (isset($_POST['addnewanggaran'])) {
        $asal = antiinjection($koneksi, $_POST['asal']);
        $tahun_penerimaan = antiinjection($koneksi, $_POST['tahun_penerimaan']);

        var_dump($asal, $tahun_penerimaan);

        // Query SQL untuk anggaran
        $addtotable_anggaran = mysqli_query($koneksi, "INSERT INTO anggaran (asal, tahun_penerimaan) VALUES ('$asal', '$tahun_penerimaan')");

        if ($addtotable_anggaran) {
            pesan('success', "Data Anggaran Baru Ditambahkan.");
        } else {
            pesan('danger', "Menambahkan Data Anggaran Gagal: " . mysqli_error($koneksi));
            echo "Query error: " . mysqli_error($koneksi);
            die(mysqli_error($koneksi));
        }

        header("Location: ../admin/module/anggaran.php");
        exit();
    } else if (isset($_POST['addnewuser'])) {
        $nama_lengkap = $_POST['nama_lengkap'];
        // $kdBarang = $_POST['kdBarang'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $alamat = $_POST['alamat'];
        $level = $_POST['level'];
        $status = $_POST['status'];

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($koneksi, "INSERT INTO user (nama_lengkap, email, username, password, alamat, level, status) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssss", $nama_lengkap, $email, $username, $password, $alamat, $level, $status);
            $addUserResult = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($addUserResult) {
                pesan('success', "Data User Baru Ditambahkan.");
            } else {
                pesan('danger', "Menambahkan Data User Gagal: " . mysqli_error($koneksi));
                echo "Query error: " . mysqli_error($koneksi);
                die(mysqli_error($koneksi));
            }

            // Redirect to the same page to refresh the table with the new data
            header("Location: ../admin/module/list_user/list.php");
            exit();
        } else {
            pesan('danger', "Error dalam membuat pernyataan SQL: " . mysqli_error($koneksi));
            echo "Query error: " . mysqli_error($koneksi);
            die(mysqli_error($koneksi));
        }
    }
}
