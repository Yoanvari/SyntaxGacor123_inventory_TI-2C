<?php
session_start();
$idUser = $_SESSION['id'];
include '../../config/koneksi.php';
$koneksi = new DatabaseConnection();
?>
<div class="w-100" style="height: calc(100% - 70px);">
    <div class="">
        <div class="px-3">
            <div class="card p-0">
                <div class="card-header">
                    Data Peminjaman
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover my-0">
                        <thead>
                            <tr>
                                <th class="border-0" scope="col">No</th>
                                <th class="border-0" scope="col">Nama Barang</th>
                                <th class="border-0" scope="col">Tgl Mulai</th>
                                <th class="border-0" scope="col">Tgl Selesai</th>
                                <th class="border-0" scope="col">Jumlah Pinjam</th>
                                <th class="border-0" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $history = mysqli_query($koneksi->getConnection(),"SELECT * FROM pinjambarang p JOIN barang b ON p.id_barang = b.idBarang WHERE p.id_user = '$idUser' AND status IN ('completed','rejected') ");
                                while ($row = mysqli_fetch_object($history)) {
                            ?>
                            <tr>
                                <td><?=  $no++ ?></td>
                                <td><?= $row->namaBarang ?></td>
                                <td><?= $row->tgl_mulai ?></td>
                                <td><?= $row->tgl_selesai ?></td>
                                <td><?= $row->qty ?></td>
                                <td>
                                    <?php if ($row->status == 'rejected') { ?>
                                        <div class="badge badge-danger" style="font-size: 1.2rem;">
                                            <?= $row->status ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="badge badge-success" style="font-size: 1.2rem;">
                                            <?= $row->status ?>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>