
<div class="cart-barang w-100 bg-gradient-primary">
    <div class="d-flex text-white shadow" style="align-items: center; justify-content: center;">
        Keranjang Barang
    </div>
    <div class="listItem" style="overflow: auto;">
        <?php $total = 0; while($row = mysqli_fetch_object($dataCart)) {?>
        <div class="item-cart">
            <div>
                <img class="" src="../img/gedung_jti.jpg" alt="" style="width: 50px; height: 50px; border-radius: 6px;">
            </div>
            <div data-bs-toggle="tooltip" data-placement="left" title="stok: <?= $row->stok ?>">
                <?= $row->namaBarang ?>
            </div>
            <div class="quantity-item">
                <span id="minus">-</span>
                <span style="cursor: auto;"><?= $row->qty ?></span>
                <span id="plus" onclick="plus(<?= $row->idBarang ?>)">+</span>
            </div>
        </div>
        <?php } ?>
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr;">
        <button class="btn-primary border border-0" data-toggle="modal" data-target="#exampleModal">Pinjam</button>
        <button class="btn-dark border border-0" id="close">Close</button>
    </div>
</div>