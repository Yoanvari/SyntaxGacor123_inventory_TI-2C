<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iventaris";

$koneksi = mysqli_connect("localhost","root","","inventaris");
if(mysqli_connect_errno()){
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>  