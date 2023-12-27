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
                <div class="card-body" >
                    <table class="table table-striped table-hover my-0">
                        <thead class="border border-0">
                            <tr>
                                <th class="border-0" scope="col">No</th>
                                <th class="border-0" scope="col">Nama Barang</th>
                                <th class="border-0" scope="col">Tgl Mulai</th>
                                <th class="border-0" scope="col">Tgl Selesai</th>
                                <th class="border-0" scope="col">Jumlah Pinjam</th>
                                <th class="border-0" scope="col">Status</th>
                                <th class="border-0" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $list = mysqli_query($koneksi->getConnection(),"SELECT * FROM pinjambarang p JOIN barang b ON p.id_barang = b.idBarang WHERE p.id_user = '$idUser' AND status IN ('waiting', 'approve') ");
                                while ($row = mysqli_fetch_object($list)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->namaBarang ?></td>
                                <td><?= $row->tgl_mulai ?></td>
                                <td><?= $row->tgl_selesai ?></td>
                                <td><?= $row->qty ?></td>
                                <td>
                                    <?php if($row->status == 'waiting') { ?>
                                    <div class="badge badge-danger" style="font-size: 1.2rem;"><?= $row->status ?></div>
                                    <?php }else { ?>
                                    <div class="badge badge-success" style="font-size: 1.2rem;"><?= $row->status ?></div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($row->status == 'waiting') { ?>
                                    <a href="#hapusPinjam<?= $row->id ?>" data-toggle="modal" title="Batal Pinjam" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Batal</a>
                                <?php }elseif($row->status == 'approve') { ?>
                                    <a href="#kembalikan<?= $row->id ?>" data-toggle="modal" title="Kembalikan" class="btn btn-xs btn-warning"><i class="fa fa-warning"></i>Kembalikan</a>
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

<?php
$hapus = mysqli_query($koneksi->getConnection(),"SELECT * FROM pinjambarang p JOIN barang b ON p.id_barang = b.idBarang WHERE p.id_user = '$idUser' AND status = 'waiting' ");
while ($row = mysqli_fetch_object($hapus)) {
?>
<div class="modal fade" id="hapusPinjam<?= $row->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header no-bd">
				<h5 class="modal-title">
                <h5 class="modal-title">
					<span>
					    Batalkan Pinjaman
                    </span> 
				</h5>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" enctype="multipart/form-data" action="">
			<div class="modal-body">
				<span>Apakah Anda Ingin Membatalkan Pinjamanan Ini?</span>
			</div>
			<div class="modal-footer no-bd">
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="hapusPinjam(<?= $row->id ?>)"><i class="fa fa-trash"></i> Batal Pinjam</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php } ?>
<?php
$kembali = mysqli_query($koneksi->getConnection()   ,"SELECT * FROM pinjambarang p JOIN barang b ON p.id_barang = b.idBarang WHERE p.id_user = '$idUser' AND status = 'approve' ");
while ($row = mysqli_fetch_object($kembali)) {
?>
<div class="modal fade" id="kembalikan<?= $row->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header no-bd">
				<h5 class="modal-title">
					<span>
					    Kembalikan Pinjaman
                    </span> 
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" enctype="multipart/form-data" action="">
			<div class="modal-body">
				<span >Apakah Anda Ingin Mengembalikan Pinjamanan Ini?</span>
			</div>
			<div class="modal-footer no-bd">
				<button type="button" class="btn btn-success" data-dismiss="modal" onclick="kembalikan(<?= $row->id ?>)"><i class="fa fa-check"></i> Kembalikan Pinjaman</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php } ?>