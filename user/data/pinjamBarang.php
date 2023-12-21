<?php
include '../../config/koneksi.php';

$dataProduct = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY namaBarang ASC");
$dataCart = mysqli_query($koneksi, "SELECT * FROM cart c JOIN barang b ON c.kdBarang = b.kdBarang ORDER BY b.namaBarang ASC");

?>

<div class="container-awal w-100" style="height: calc(100% - 70px);">
    <div class="d-flex p-3 justify-content-between mx-4 my-3 bg-gradient-primary text-white shadow"
        style="border-radius: 12px; min-width: 232px;">
        <p class="m-0" style="font-size: 30px;">Product</p>
        <div class="icon-cart" style="cursor: pointer;">
            <i class="bi-cart" style="font-size: 30px;"></i>
            <span id="countCart"></span>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="container-barang">
            <!-- Product -->
            <?php while ($row = mysqli_fetch_object($dataProduct)) { ?>
                <div style="max-width: 500px;">
                    <div class="card" style="height: 100%;">
                        <div class="card-body p-0 cardItems">
                            <div class="row align-item-center m-0">
                                <?php
                                $gambarPath = "../img/" . $row->foto;
                                ?>
                                <a href="<?= $gambarPath ?>" data-lightbox="gallery" data-title="<?= $row->namaBarang ?>">
                                    <img class="img-item" src="<?= $gambarPath ?>" alt="<?= $row->foto ?>">
                                </a>
                            </div>
                            <div class="row align-item-center m-0" style="color: black;">
                                <br><br><br>
                                <?= $row->namaBarang ?>
                            </div>
                            <div>
                                <br><br><br>
                                ket:
                                <?= $row->deskripsi ?>
                            </div>
                            <button class="btn btn-primary py-1 px-0" data-bs-toggle="tooltip" data-placement="bottom"
                                title="stok: <?= $row->stok ?>" onclick="addCart(<?= $row->idBarang ?>)">Pinjam</button>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Cart -->
<div class="cart-barang w-100 bg-gradient-primary">
    <div class="d-flex text-white shadow" style="align-items: center; justify-content: center;">
        Keranjang Barang
    </div>
    <div class="listItem" style="overflow: auto;">
        <?php
        $total = 0;
        while ($row = mysqli_fetch_object($dataCart)) {
            ?>
            <div class="item-cart">
                <div>
                    <img class="" src="../img/gedung_jti.jpg" alt="" style="width: 50px; height: 50px; border-radius: 6px;">
                </div>
                <div data-bs-toggle="tooltip" data-placement="left" title="stok: <?= $row->stok ?>">
                    <?= $row->namaBarang ?>
                </div>
                <div class="quantity-item">
                    <span id="minus" onclick="minusCart(<?= $row->idBarang ?>)">-</span>
                    <span style="cursor: auto;">
                        <?= $row->qty ?>
                    </span>
                    <span id="plus" onclick="plusCart(<?= $row->idBarang ?>)">+</span>
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
$jumlahCart = mysqli_query($koneksi, "SELECT SUM(qty) AS total_qty FROM cart");
$row = $jumlahCart->fetch_assoc();
$totalQty = $row['total_qty'];
?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Peminjaman</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label>Jumlah Pinjam Barang</label>
                        <input type="text" name="qty" class="form-control" value="<?php echo $totalQty ?>" disabled
                            readonly>
                    </div>
                    <div class="form-group">
                        <label>Tgl Mulai Pinjam</label>
                        <input type="text" name="tgl_mulai" class="form-control" value="<?php echo date('Y-m-d') ?>"
                            disabled readonly>
                    </div>
                    <div class="form-group">
                        <label>Tgl Selesai Pinjam</label>
                        <input type="date" name="tgl_selesai" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="../login.php">Confirm</a>
            </div>
        </div>
    </div>
</div>