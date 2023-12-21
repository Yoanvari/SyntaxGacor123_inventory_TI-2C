<div class="w-100 vh-100" style="height: 100%;">
    <div class="">
        
        <div class="px-3">
            <div class="card">
                <div class="card-header">
                    Data Peminjaman
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover my-0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Tgl Mulai</th>
                                <th scope="col">Tgl Selesai</th>
                                <th scope="col">Jumlah Pinjam</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $query = mysqli_query($koneksi,'SELECT pinjambarang.id, pinjambarang.id_barang, pinjambarang.id_user, pinjambarang.tgl_mulai, pinjambarang.tgl_selesai, pinjambarang.qty, pinjambarang.lokasi_barang, pinjambarang.status, barang.namaBarang from pinjambarang inner join barang on barang.idBarang=pinjambarang.id_barang inner join user on user.id=pinjambarang.id_user');
                                while ($pinjambarang = mysqli_fetch_array($query)) {
                            ?>
                            <?php if($_SESSION['id'] == $pinjambarang['id_user']) { ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $pinjambarang['namaBarang'] ?></td>
                                <td><?php echo $pinjambarang['tgl_mulai'] ?></td>
                                <td><?php echo $pinjambarang['tgl_selesai'] ?></td>
                                <td><?php echo $pinjambarang['qty'] ?></td>
                                <td>
                                    <?php if($pinjambarang['status'] == 'menunggu') { ?>
                                    <div class="badge badge-danger"><?php echo $pinjambarang['status'] ?></div>
                                    <?php }else { ?>
                                        <div class="badge badge-success"><?php echo $pinjambarang['status'] ?></div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($pinjambarang['status'] == 'menunggu') { ?>
                                    <a href="?view=detailpinjambarang&id=<?php echo $pinjambarang['id'] ?>" title="Detail" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                    <a href="#modalHapusPinjamBarang<?php echo $pinjambarang['id'] ?>" data-toggle="modal" title="Batal Pinjam" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Batal</a>
                                <?php }elseif($pinjambarang['status'] == 'approve') { ?>
                                    <a href="?view=detailpinjambarang&id=<?php echo $pinjambarang['id'] ?>" title="Detail" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                    <a href="#modalKembalikanPinjamBarang<?php echo $pinjambarang['id'] ?>" data-toggle="modal" title="Kembalikan" class="btn btn-xs btn-warning"><i class="fa fa-warning"></i> Kembalikan</a>
                                <?php }else { ?>
                                    <a href="?view=detailpinjambarang&id=<?php echo $pinjambarang['id'] ?>" title="Detail" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                    <div class="badge badge-success"><?php echo $pinjambarang['status'] ?></div>
                                <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>