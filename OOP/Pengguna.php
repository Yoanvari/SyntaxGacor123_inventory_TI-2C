<?php
class Pengguna
{
    private $conn;

    public function __construct($koneksi)
    {
        $this->conn = $koneksi->getConnection();
    }

    public function updateProfile($data)
    {
        $foto = $_FILES['foto']['name'];
        $tmpFile = $_FILES['foto']['tmp_name'];
        $targetDirImg = $_SERVER['DOCUMENT_ROOT'] . '../../img/';
        $maxFileSize = 3 * 1024 * 1024;

        $this->uploadFile($tmpFile, $targetDirImg, $foto);

        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $result = $this->conn->query("UPDATE user SET 
        email = '{$data['email']}', 
        password = '{$password}', 
        foto = '{$foto}', 
        alamat = '{$data['alamat']}' 
        WHERE id = {$data['id']}");
        return $result;
    }

    private function uploadFile($tmpFile, $targetDir, $fileName)
    {
        move_uploaded_file($tmpFile, $targetDir . $fileName);
    }

    public function getAvatarByGender($gender)
    {
        // Logika untuk menentukan avatar berdasarkan jenis kelamin
        if ($gender === 'laki-laki') {
            return 'avatar_laki.png'; // Ganti dengan nama file avatar laki-laki
        } elseif ($gender === 'perempuan') {
            return 'avatar_cewe.png'; // Ganti dengan nama file avatar perempuan
        } else {
            return 'default_avatar.png'; // Avatar default jika jenis kelamin tidak diketahui
        }
    }
    public function get_user($userId)
    {
        $result = $this->conn->query("SELECT jenis_kelamin FROM user WHERE id = {$userId}");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['jenis_kelamin'];
        }
        return null; // Pengguna tidak ditemukan atau terjadi kesalahan lainnya
    }

    public function countCart($idUser, Cart $cart)
    {
        $query = $cart->countCart($idUser);
        echo json_encode($query);
    }

    public function addCart($idUser, $id, barang $barang, Cart $cart)
    {
        $qty = 0;
        $query = $cart->tampilCart($id, $idUser);
        $checkCount = $query->num_rows;
        while ($row = mysqli_fetch_object($query)) {
            $qty = $row->qty;
        }

        $query = $barang->tampilBarang($id);
        while ($row = mysqli_fetch_object($query)) {
            $desk = $row->deskripsi;
            $stok = $row->stok;
        }

        if ($desk == "rusak") {
            echo json_encode(["message" => "rusak"]);
        } elseif ($qty == $stok) {
            echo json_encode(["message" => "Stok_Kurang"]);
        } else {
            if ($checkCount == 0) {
                $insert = $cart->tambahCart($id, $idUser);
                if ($insert) {
                    echo json_encode(["message" => "success"]);
                } else {
                    echo json_encode(["massage" => "failed"]);
                }
            } else if ($checkCount > 0) {
                $qty += 1;
                $update = $cart->updateCart($qty, $id, $idUser);
                if ($update) {
                    echo json_encode(["message" => "success"]);
                } else {
                    echo json_encode(["massage" => "failed"]);
                }
            }
        }
    }

    public function minusCart($idUser, $id, Cart $cart)
    {
        $query = $cart->tampilCart($id, $idUser);

        while ($row = mysqli_fetch_object($query)) {
            $qty = $row->qty;
        }
        if ($qty == 1) {
            $delete = $cart->hapusCart($id, $idUser);
            if ($delete) {
                echo json_encode(["message" => "success"]);
            } else {
                echo json_encode(["massage" => "failed"]);
            }
        } else if ($qty > 1) {
            $qty -= 1;
            $update = $cart->updateCart($qty, $id, $idUser);
            if ($update) {
                echo json_encode(["message" => "success"]);
            } else {
                echo json_encode(["massage" => "failed"]);
            }
        }
    }

    public function plusCart($idUser, $id, Cart $cart)
    {
        $query = $cart->cartBarang($idUser, $id);
        while ($row = mysqli_fetch_object($query)) {
            $qty = $row->qty;
            $stok = $row->stok;
        }
        if ($qty == $stok) {
            echo json_encode(["message" => "Stok_Kurang"]);
        } else if ($stok > $qty) {
            $qty += 1;
            $update = $cart->updateCart($qty, $id, $idUser);
            if ($update) {
                echo json_encode(["message" => "success"]);
            } else {
                echo json_encode(["massage" => "failed"]);
            }
        }
    }

    public function pinjamCart($idUser, Cart $cart, barang $barang)
    {
        $tglMulai = $_POST['tgl_mulai'];
        $tglSelesai = $_POST['tgl_selesai'];
        $query = $cart->cartBarang($idUser);
        while ($row = mysqli_fetch_object($query)) {
            $qty = $row->qty;
            $id = $row->idBarang;
            // $stok = $row->stok;

            // $sisa = $stok - $qty;

            $insert = $barang->insertPinjam($id, $qty, $tglMulai, $tglSelesai, $idUser);

            if ($insert) {
                $cart->hapusCart($id, $idUser);
                // $cart->updateSisa($sisa, $id);
            } else {
                echo json_encode(["message" => "failed"]);
            }
        }

        echo json_encode(["message" => "success"]);
    }

    public function hapusPinjam($id, barang $barang)
    {
        $query = $barang->tampilPinjam($id);
        while ($row = mysqli_fetch_object($query)) {
            $delete = $barang->hapusPinjam($id);
            if ($delete) {
                echo json_encode(["message" => "success"]);
            } else {
                echo json_encode(["message" => "failed"]);
            }
        }
    }

    public function kembalikan($id, barang $barang)
    {   
        $sisa = 0;
        $stok = 0;
        $tampil = $barang->tampilBarangPinjam($id);
        while ($row = mysqli_fetch_object($tampil)) {
            $qty = $row->qty;
            $stok = $row->stok;
            $sisa = $stok + $qty;
            $idBarang = $row->idBarang;
            $update = $barang->updateSisa($sisa,$idBarang);
            
        }

        $query = $barang->tampilPinjam($id);
        while ($row = mysqli_fetch_object($query)) {
            $update = $barang->updatePinjam($id);
            if ($update) {
                echo json_encode(["message" => "success"]);
            } else {
                echo json_encode(["message" => "failed"]);
            }
        }
    }

    public function approve($id, barang $barang)
    {   
        $sisa = 0;
        $stok = 0;
        $query = $barang->tampilBarangPinjam($id);
        while ($row = mysqli_fetch_object($query)) {
            $qty = $row->qty;
            $stok = $row->stok;
            $sisa = $stok - $qty;
            $idBarang = $row->idBarang;
            $barang->updateSisa($sisa,$idBarang);
        }

        $query = $barang->tampilPinjam($id);
        while ($row = mysqli_fetch_object($query)) {
            $update = $barang->updatePinjam($id, 'approve');
            if ($update) {
                echo json_encode(["message" => "success"]);
            } else {
                echo json_encode(["message" => "failed"]);
            }
        }
    }

    public function reject($id, barang $barang) {
        $query = $barang->tampilPinjam($id);
        while ($row = mysqli_fetch_object($query)) {
            $update = $barang->updatePinjam($id, 'rejected');
            if ($update) {
                echo json_encode(["message" => "success"]);
            } else {
                echo json_encode(["message" => "failed"]);
            }
        }
    }
}
?>