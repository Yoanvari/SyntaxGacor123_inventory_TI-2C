<?php
require_once 'auth.php';
class Cart extends DatabaseConnection
{   

    public function countCart($idUser)
    {
        $query = mysqli_query($this->getConnection(), "SELECT * FROM cart WHERE id_user = '$idUser' ")->num_rows;
        return $query;
    }

    public function tampilCart($id, $idUser)
    {
        $query = mysqli_query($this->getConnection(), "SELECT * FROM cart WHERE id_barang = '$id' AND id_user = '$idUser' ");
        return $query;
    }

    public function tambahCart($id, $idUser)
    {
        $insert = mysqli_query($this->getConnection(), "INSERT INTO cart (id_barang,qty,id_user) VALUES ('$id','1','$idUser') ");
        return $insert;
    }

    public function updateCart($qty, $id, $idUser)
    {
        $update = mysqli_query($this->getConnection(), "UPDATE cart SET qty = '$qty' WHERE id_barang = '$id' AND id_user = '$idUser' ");
        return $update;
    }

    public function hapusCart($id, $idUser)
    {
        $delete = mysqli_query($this->getConnection(), "DELETE FROM cart WHERE id_barang = '$id' AND id_user = '$idUser' ");
        return $delete;
    }

    // public function cartBarang($id,$idUser) {
    //     $query = mysqli_query($this->getConnection(),"SELECT * FROM cart c JOIN barang b ON c.id_barang = b.idBarang WHERE b.idBarang = '$id' AND c.id_user = '$idUser' ");
    //     return $query;
    // }

    public function cartBarang($idUser, $id = null)
    {
        if ($id === null) {
            $query = mysqli_query($this->getConnection(), "SELECT * FROM cart c JOIN barang b ON c.id_barang = b.idBarang WHERE c.id_user = '$idUser' ");
        } else {
            $query = mysqli_query($this->getConnection(), "SELECT * FROM cart c JOIN barang b ON c.id_barang = b.idBarang WHERE b.idBarang = '$id' AND c.id_user = '$idUser' ");
        }

        return $query;
    }

}