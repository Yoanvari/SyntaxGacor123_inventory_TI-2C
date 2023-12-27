<?php
require_once 'Controller.php';
class barang extends Controller
{
    public function __construct($koneksi)
    {
        parent::__construct($koneksi->getConnection());
    }

    public function read()
    {
        $result = $this->connection->query("select * from barang");
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $row;
    }

    public function create($data)
    {

        $foto = $_FILES['foto']['name'];
        $tmpFile = $_FILES['foto']['tmp_name'];
        $targetDirImg = $_SERVER['DOCUMENT_ROOT'] . '../../img/';
        $maxFileSize = 3 * 1024 * 1024;

        if ($_FILES['foto']['size'] > $maxFileSize) {
            return false;
        }

        $this->uploadFile($tmpFile, $targetDirImg, $foto);

        $result = $this->connection->query("INSERT INTO barang (kd_Barang, namaBarang, deskripsi, stok, foto, asal) 
    VALUES ('" . $data['kd_Barang'] . "','" . $data['namaBarang'] . "','" . $data['deskripsi'] . "','" . $data['stok'] . "','" . $foto . "','" . $data['asal'] . "')");

        return $result;
    }

    private function uploadFile($tmpFile, $targetDir, $fileName)
    {
        move_uploaded_file($tmpFile, $targetDir . $fileName);
    }

    public function update($data)
    {
        $foto = $_FILES['foto']['name'];
        $tmpFile = $_FILES['foto']['tmp_name'];
        $targetDirImg = $_SERVER['DOCUMENT_ROOT'] . '../../img/';
        $maxFileSize = 3 * 1024 * 1024;

        // Periksa ukuran berkas
        if ($_FILES['foto']['size'] > $maxFileSize) {
            return false;
        }

        $this->uploadFile($tmpFile, $targetDirImg, $foto);

        $result = $this->connection->query("UPDATE barang SET 
        namaBarang = '" . $data['namaBarang'] . "', 
        deskripsi = '" . $data['deskripsi'] . "', 
        stok = '" . $data['stok'] . "', 
        asal = '" . $data['asal'] . "', 
        kd_Barang = '" . $data['kd_Barang'] . "', 
        foto = '" . $foto . "' 
        WHERE idBarang = " . $data['idBarang']);

        return $result;
    }

    public function delete($id)
    {
        $result = $this->connection->query("DELETE FROM barang WHERE idBarang='$id'");
        return $result;

    }
    public function tampilBarang($id)
    {
        $query = mysqli_query($this->connection, "SELECT * FROM barang WHERE idBarang = '$id' ");
        return $query;
    }

    public function tampilPinjam($id)
    {
        $query = mysqli_query($this->connection, "SELECT * FROM pinjambarang WHERE id = '$id'");
        return $query;
    }

    public function hapusPinjam($id)
    {
        $delete = mysqli_query($this->connection, "DELETE FROM  pinjambarang WHERE id = '$id'");
        return $delete;
    }

    public function updatePinjam($id, $status = null)
    {
        if ($status === null) {
            // Regular update
            $update = mysqli_query($this->connection, "UPDATE pinjambarang SET status='completed' WHERE id = '$id'");
        } else {
            // Handle additional case
            // You can extend this logic based on the additional parameter
            $update = mysqli_query($this->connection, "UPDATE pinjambarang SET status='$status' WHERE id = '$id'");
        }

        return $update;
    }

    public function insertPinjam($id, $qty, $tglMulai, $tglSelesai, $idUser)
    {
        $insert = mysqli_query($this->connection, "INSERT INTO pinjambarang (id_barang,qty,tgl_mulai,tgl_selesai,status,id_user) VALUES ($id,$qty,'$tglMulai','$tglSelesai','waiting',$idUser) ");
        return $insert;
    }

    public function tampilBarangPinjam($id) {
        $query = mysqli_query($this->connection, "SELECT * FROM barang b JOIN pinjambarang p ON b.idBarang = p.id_barang WHERE p.id = '$id' ");
        return $query;
    }

    public function updateSisa($sisa, $id)
    {
        mysqli_query($this->connection, "UPDATE barang SET stok='$sisa' WHERE idBarang = '$id' ");
    }
}