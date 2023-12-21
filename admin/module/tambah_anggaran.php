<?php
include '../../config/koneksi.php';
include '../../OOP/Admin.php';
$koneksi = new DatabaseConnection();
$Admin = new Admin($koneksi->getConnection());
if (isset($_POST['addnewanggaran'])) {

    $asal = $_POST['asal'];
    $tahun_penerimaan = $_POST['tahun_penerimaan'];

    // Call the method to add a new anggaran
    $Admin->addNewAnggaran($asal, $tahun_penerimaan);

    header('Location: http://localhost/dasarweb/inventory_JTI/SyntaxGacor123_inventory_TI-2C%20(3)/SyntaxGacor123_inventory_TI-2C/admin/module/anggaran.php');
    // Redirect to the same page or a different page
    // exit();
}
