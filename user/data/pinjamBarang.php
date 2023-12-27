<?php
session_start();
$idUser = $_SESSION['id'];
include '../../config/koneksi.php';
$koneksi = new DatabaseConnection();
$dataProduct = mysqli_query($koneksi->getConnection(),"SELECT * FROM barang ORDER BY namaBarang ASC");
$dataCart = mysqli_query($koneksi->getConnection(),"SELECT * FROM cart c JOIN barang b ON c.id_barang = b.idBarang WHERE c.id_user = '$idUser' ORDER BY c.id_cart ASC");
?>
<div class="container-awal w-100" style="height: calc(100% - 70px);">
    <div class="d-flex p-3 justify-content-between mx-4 my-3 bg-gradient-primary text-white shadow" style="border-radius: 12px; min-width: 232px;">
        <p class="m-0" style="font-size: 30px;">Product</p>
        <div class="icon-cart" style="cursor: pointer;">
            <i class="bi-cart" style="font-size: 30px;"></i>
            <span id="countCart"></span>
        </div>
    </div>

    <div class="d-flex" style="justify-content: center;">
        <div class="container-barang">
            <!--Product-->
            <?php while($row = mysqli_fetch_object($dataProduct)) { ?>
            <div style="max-width: 500px;">
                <div class="card" style="height: 100%;">
                    <div class="card-body p-0 cardItems">
                        <div class="row align-item-center m-0">
                            <div id="img-item">
                                <img src="../img/<?= $row->foto ?>" alt="<?= $row->foto ?>" style="width: 100px; height:100px;">
                            </div>
                        </div>
                        <div class="row align-item-center m-0" style="color: black;">
                            <?= $row->namaBarang ?>
                        </div>
                        <div class="row align-item-center m-0">
                            ket: <?= $row->deskripsi ?>
                        </div>
                        <button class="btn btn-primary py-1 px-0" data-bs-toggle="tooltip" data-placement="bottom" title="stok: <?= $row->stok ?>" onclick="addCart(<?= $row->idBarang ?>)">Pinjam</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    
</div>
<!--Cart-->
<div class="cart-barang w-100 bg-gradient-primary">
    <div class="d-flex text-white shadow" style="align-items: center; justify-content: center;">
        Keranjang Barang
    </div>
    <div class="listItem" style="overflow: auto;">
        <?php $total = 0; while($row = mysqli_fetch_object($dataCart)) {?>
        <div class="item-cart">
            <div>
                <img class="" src="../img/<?= $row->foto ?>" alt="" style="width: 50px; height: 50px; border-radius: 6px;">
            </div>
            <div data-bs-toggle="tooltip" data-placement="left" title="stok: <?= $row->stok ?>">
                <?= $row->namaBarang ?>
            </div>
            <div class="quantity-item">
                <span id="minus" onclick="minusCart(<?= $row->id_barang ?>)">-</span>
                <span style="cursor: auto;"><?= $row->qty ?></span>
                <span id="plus" onclick="plusCart(<?= $row->id_barang ?>)">+</span>
            </div>
        </div>
        <?php } ?>
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr;">
        <button class="btn-primary border border-0" data-toggle="modal" data-target="#exampleModal">Pinjam</button>
        <button class="btn-dark border border-0" id="close">Close</button>
    </div>
</div>
  
<!-- Modal -->
<?php
$jumlahCart = mysqli_query($koneksi->getConnection(),"SELECT SUM(qty) AS total_qty FROM cart WHERE id_user = '$idUser' ");
$row = $jumlahCart->fetch_assoc();
$totalQyt = $row['total_qty'];
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Peminjaman</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label>Jumlah Pinjam Barang</label>
                        <input type="text" class="form-control" value="<?php echo $totalQyt ?>" disabled readonly>
                    </div>
                    <div class="form-group">
                        <label>Tgl Mulai Pinjam</label>
                        <input type="date" name="tgl_mulai" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label>Tgl Selesai Pinjam</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="pinjam()">Confirm</button>
            </div>
        </div>
    </div>
</div>
