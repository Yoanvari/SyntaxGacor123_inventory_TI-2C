<?php
require_once 'CRUD.php';
require_once 'Controller.php';
include 'user.php';
include 'barang.php';
include 'anggaran.php';
include 'Pengguna.php';

class Admin
{
    private $anggaran;
    private $barang;
    private $user;
    private $pengguna;
    private $koneksi;

    public function __construct()
    {
        require 'auth.php';
        $this->koneksi = new DatabaseConnection();
        $this->anggaran = new anggaran($this->koneksi);
        $this->barang = new barang($this->koneksi);
        $this->user = new user($this->koneksi);
        $this->pengguna = new Pengguna($this->koneksi);
    }

    public function tambahAnggaran($data = [])
    {
        $cek = $this->anggaran->create($data);
        return $cek;
    }

    public function updateAnggaran($data = [])
    {
        $cek = $this->anggaran->update($data);
        return $cek;
    }

    public function deleteAnggaran($data = [])
    {
        $cek = $this->anggaran->delete($data);
        return $cek;
    }

    public function tambahBarang($data = [])
    {
        $cek = $this->barang->create($data);
        return $cek;
    }

    public function updateBarang($data = [])
    {
        $cek = $this->barang->update($data);
        return $cek;
    }
    public function deleteBarang($id = '')
    {
        $cek = $this->barang->delete($id);
        return $cek;
    }

    public function tambahUser($data = [])
    {
        $cek = $this->user->create($data);
        return $cek;
    }

    public function updateUser($data = [])
    {
        $cek = $this->user->update($data);
        return $cek;

    }

    public function updateProfile($data = [])
    {
        $cek = $this->pengguna->updateProfile($data);
        return $cek;

    }


    public function tabelBarang()
    {
        $result = $this->barang->read();

        if ($result) {
            $no = 1;
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['kd_Barang'] . "</td>";
                echo "<td>" . $row['namaBarang'] . "</td>";
                echo "<td>" . $row['deskripsi'] . "</td>";
                echo "<td>" . $row['stok'] . "</td>";
                echo "<td>" . $row['asal'] . "</td>";
                // echo "<td>" . $row['tahun_pengadaan'] . "</td>";
                $gambarPath = "../../img/" . $row['foto'];

                // Tampilkan gambar dengan link ke detail modal
                echo "<td><a href='$gambarPath' data-lightbox='barang' data-title='$row[namaBarang]'><img src='$gambarPath' alt='Gambar Barang' width='100px'></a></td>";

                // Tombol Edit dan Delete
                echo "<td>
                                <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['idBarang'] . "'>Edit</button>
                                <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal" . $row['idBarang'] . "'>Delete</button>
                                                </td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
        }
    }


    public function asalBarang()
    {
        $result_anggaran = mysqli_query($this->koneksi->getConnection(), "SELECT DISTINCT asal FROM anggaran");
        while ($row_anggaran = mysqli_fetch_assoc($result_anggaran)) {
            $selected = '';

            echo "<option value='" . $row_anggaran['asal'] . "' $selected>" . $row_anggaran['asal'] . "</option>";
        }
    }


    public function tabelAnggaran()
    {

        $result = $this->anggaran->read();

        if ($result) {
            $no = 1;
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['asal'] . "</td>";
                echo "<td>" . $row['tahun_pengadaan'] . "</td>";
                // Add action buttons with icons
                echo "<td>
                                <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['idAnggaran'] . "'>Edit</button>
                                <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal" . $row['idAnggaran'] . " '>Delete</button>
                                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
        }
    }
    public function tabelUser()
    {
        $result = $this->user->read();

        if ($result) {
            $no = 1;
            foreach ($result as $row) {
                if (!$this->user->isUserAdmin($row['id'])) {
                    // Hanya menampilkan pengguna yang bukan admin
                    $statusColor = (strtolower($row['status']) == 'active') ? '#00FF00' : 'red';
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nama_lengkap'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['alamat'] . "</td>";
                    echo "<td>" . $row['jabatan'] . "</td>";
                    echo "<td>" . $row['jenis_kelamin'] . "</td>";
                    echo "<td>" . $row['level'] . "</td>";
                    echo "<td style='color: $statusColor;'>" . $row['status'] . "</td>";
                    echo "<td>
                        <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id'] . "'>Edit</button></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
        }
    }


    public function get_anggaran()
    {

        $result = $this->anggaran->read();
        return $result;
    }
    public function get_barang()
    {

        $result = $this->barang->read();
        return $result;
    }
    public function get_user()
    {

        $result = $this->user->read();
        return $result;
    }


    function pesan($jenis, $pesan)
    {
        $_SESSION['pesan'] = [
            'jenis' => $jenis,
            'pesan' => $pesan
        ];
    }

    function tampilkanPesan()
    {
        if (isset($_SESSION['pesan'])) {
            $jenis_pesan = $_SESSION['pesan']['jenis'];
            $pesan = $_SESSION['pesan']['pesan'];

            // Hapus pesan dari session agar tidak ditampilkan lagi
            unset($_SESSION['pesan']);

            // Menambahkan kode HTML, CSS, dan JavaScript untuk menampilkan pesan sebagai elemen tumpang tindih
            echo "<div id='pesan' class='$jenis_pesan'>$pesan</div>";
            echo "<style>
            #pesan {
                position: fixed;
                top: 10px;
                left: 50%;
                transform: translateX(-50%);
                background-color: #3498db;
                color: white;
                padding: 10px;
                border-radius: 5px;
                box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
                z-index: 999;
                text-align: center;
                display: none;
            }

            #pesan.success {
                background-color: #2ecc71;
            }

            #pesan.failed {
                background-color: #e74c3c;
            }
        </style>";

            echo "<script>
            var elem = document.getElementById('pesan');
            elem.style.display = 'block';
            
            setTimeout(function() {
                elem.style.display = 'none';
            }, 3000); // Pesan akan hilang setelah 3 detik
        </script>";
        }
    }

    public function fetchPinjamBarang()
    {
        $mysqliConnection = $this->koneksi->getConnection();

        $query = "SELECT p.*, b.namaBarang, b.kd_barang 
                  FROM pinjambarang p 
                  JOIN barang b ON p.id_barang = b.idBarang 
                  WHERE p.status IN ('waiting','approve')";
        $result = mysqli_query($mysqliConnection, $query);

        $pinjamBarangData = [];
        while ($row = mysqli_fetch_object($result)) {
            $pinjamBarangData[] = $row;
        }

        return $pinjamBarangData;

    }
    public function displayPinjamBarangModals()
    {
        $pinjamBarangData = $this->fetchPinjamBarang();

        foreach ($pinjamBarangData as $row) {
            echo "<div class='modal fade' id='approve" . $row->id . "' tabindex='-1' role='dialog' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header no-bd'>
                            <h5 class='modal-title'>
                                <span>Approve Pinjaman</span>
                            </h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <form method='POST' enctype='multipart/form-data' action=''>
                            <div class='modal-body'>
                                <span>Approve Pinjaman?</span>
                            </div>
                            <div class='modal-footer no-bd'>
                                <button type='button' class='btn btn-primary' data-dismiss='modal' onclick='approve(" . $row->id . ")'><i class='fa fa-check-circle'></i> Approve</button>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'><i class='fa fa-undo'></i> Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>";
            echo "<div class='modal fade' id='reject" . $row->id . "' tabindex='-1' role='dialog' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header no-bd'>
                            <h5 class='modal-title'>
                                <span>Approve Pinjaman</span>
                            </h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <form method='POST' enctype='multipart/form-data' action=''>
                            <div class='modal-body'>
                                <span>Reject Pinjaman?</span>
                            </div>
                            <div class='modal-footer no-bd'>
                                <button type='button' class='btn btn-danger' data-dismiss='modal' onclick='reject(" . $row->id . ")'><i class='fa fa-check-circle'></i> Reject</button>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'><i class='fa fa-undo'></i> Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>";
        }
    }

    public function displayCompletedPinjamBarangTable()
    {
        $mysqliConnection = $this->koneksi->getConnection();

        $query = "SELECT * FROM pinjambarang p JOIN barang b ON p.id_barang = b.idBarang WHERE status IN ('completed','rejected') ";
        $result = mysqli_query($mysqliConnection, $query);

        $no = 1;
        while ($row = mysqli_fetch_object($result)) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $row->namaBarang . "</td>";
            echo "<td>" . $row->tgl_mulai . "</td>";
            echo "<td>" . $row->tgl_selesai . "</td>";
            echo "<td>" . $row->qty . "</td>";
            echo "<td>";
                    if ($row->status == 'rejected') {
                        echo "<div class='badge badge-danger' style='font-size: 1.2rem;'>"
                            . $row->status .
                        "</div>";
                    } else {
                        echo "<div class='badge badge-success' style='font-size: 1.2rem;'>"
                            .$row->status.
                        "</div>";
                    }
                "</td>";
            echo "</tr>";
        }
    }

    // public function approve($id, barang $barang)
    // {   
    //     $sisa = 0;
    //     $stok = 0;
    //     $query = $barang->tampilBarangPinjam($id);
    //     while ($row = mysqli_fetch_object($query)) {
    //         $qty = $row->qty;
    //         $stok = $row->stok;
    //         $sisa = $stok - $qty;
    //         $idBarang = $row->idBarang;
    //         $barang->updateSisa($sisa,$idBarang);
    //     }

    //     $query = $barang->tampilPinjam($id);
    //     while ($row = mysqli_fetch_object($query)) {
    //         $update = $barang->updatePinjam($id, 'approve');
    //         if ($update) {
    //             echo json_encode(["message" => "success"]);
    //         } else {
    //             echo json_encode(["message" => "failed"]);
    //         }
    //     }
    // }

    // public function reject($id, barang $barang) {
    //     $query = $barang->tampilPinjam($id);
    //     while ($row = mysqli_fetch_object($query)) {
    //         $update = $barang->updatePinjam($id, 'rejected');
    //         if ($update) {
    //             echo json_encode(["message" => "success"]);
    //         } else {
    //             echo json_encode(["message" => "failed"]);
    //         }
    //     }
    // }
}
?>