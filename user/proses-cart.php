<?php
include '../config/koneksi.php';

$request = $_SERVER['REQUEST_METHOD'];

switch ($request) {
    case 'GET':
        $query = mysqli_query($koneksi,"SELECT * FROM cart")->num_rows;

        echo json_encode($query);
        break;
    
    case 'POST':

        switch ($_POST['proses']) {
            case 'add':
                $id = $_POST['id'];

                $query = mysqli_query($koneksi,"SELECT * FROM cart WHERE idBarang = '$id' ");
                $checkCount = $query->num_rows;
                while($row = mysqli_fetch_object($query)) {
                    $qty = $row->qty;
                }
                if ($checkCount == 0) {

                    $save = mysqli_query($koneksi,"INSERT INTO cart (idBarang,qty) VALUES ('$id','1') ");
    
                    if ($save) {
                        echo json_encode(["message" => "success"]);
                    } else {
                        echo json_encode(["massage" => "failed"]);
                    }
                } else if ($checkCount > 0) {
                    $qty += 1;

                    $update = mysqli_query($koneksi,"UPDATE cart SET qty = '$qty' WHERE idBarang = '$id' ");
    
                    if ($update) {
                        echo json_encode(["message" => "success"]);
                    } else {
                        echo json_encode(["massage" => "failed"]);
                    }
                }

                break;
            
            case 'minus':
                $id = $_POST['id'];

                $query = mysqli_query($koneksi,"SELECT * FROM cart WHERE idBarang = '$id' ");
                
                while($row = mysqli_fetch_object($query)) {
                    $qty = $row->qty;
                }
                if ($qty == 1) {

                    $delete = mysqli_query($koneksi,"DELETE FROM cart WHERE idBarang = '$id' ");
    
                    if ($delete) {
                        echo json_encode(["message" => "success"]);
                    } else {
                        echo json_encode(["massage" => "failed"]);
                    }
                } else if ($qty > 1) {
                    $qty -= 1;

                    $update = mysqli_query($koneksi,"UPDATE cart SET qty = '$qty' WHERE idBarang = '$id' ");
    
                    if ($update) {
                        echo json_encode(["message" => "success"]);
                    } else {
                        echo json_encode(["massage" => "failed"]);
                    }
                }
                break;
            
            case 'plus':
                $id = $_POST['id'];
                
                $query = mysqli_query($koneksi,"SELECT * FROM cart c JOIN barang b ON c.idBarang = b.idBarang WHERE c.idBarang = '$id' ");

                while($row = mysqli_fetch_object($query)) {
                    $qty = $row->qty;
                    $stok = $row->stok;
                }
                if ($qty == $stok ) {
                    echo json_encode(["message" => "Stok_Kurang"]);
                } else if ($stok > $qty) {
                    $qty += 1;

                    $update = mysqli_query($koneksi,"UPDATE cart SET qty = '$qty' WHERE idBarang = '$id' ");
    
                    if ($update) {
                        echo json_encode(["message" => "success"]);
                    } else {
                        echo json_encode(["massage" => "failed"]);
                    }
                }
                break;
        }

        break;
}