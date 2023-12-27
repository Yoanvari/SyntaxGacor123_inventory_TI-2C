<?php
session_start();
include '../../OOP/Admin.php';
$Admin = new Admin();
$Admin->tampilkanPesan();
// untuk admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika tidak, redirect ke login.php
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>INVENTORY JTI</title>
    <!-- Bootstrap CSS -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Tambahkan stylesheet lightbox2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css"
        integrity="sha512-sJQUOWoQhM7QKx9ImhAA8Q3HgjPfS6IK9zUnGThQQTj8tSCBD1VjMy7fmiA51Ph3eYjOui8a+3IViECitp4hA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tambahkan script lightbox2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"
        integrity="sha512-j4L1+lXf5e+ipFMpD9U2E9zZ+ZmRQYPk+trPHb2s0pM9ln3udKtKVI2vl0rS38cCf+2u65buX4jG3e3Yp7EImA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">Inventory JTI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../../index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="/admin/datamaster.php" data-toggle="collapse"
                    data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Components:</h6>
                        <a class="collapse-item" href="anggaran.php">Anggaran</a>
                        <a class="collapse-item" href="barang.php">Barang</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="peminjaman.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Peminjaman</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="history.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>History Peminjaman</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="./list_user/list.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>List User</span></a>
            </li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Data Barang</h1>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'Nama Pengguna'; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../module/profile/profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout.php" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div class="card-1 shadow mb-4">
                    <div class="card-1-body">
                        <div class="card-1-body d-flex align-items-center justify-content-between">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#myModal">
                                Tambah Barang
                            </button>

                        </div>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title text-primary">Tambah Barang</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">

                                        <form action="../../function/tambah.php?jenis=tambahBarang" method="post"
                                            enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="kd_Barang" class="form-label">Kode Barang</label>
                                                <input type="text" name="kd_Barang" id="kd_barang" class="form-control"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="namaBarang" class="form-label">Nama Barang</label>
                                                <input type="text" name="namaBarang" id="namabarang"
                                                    class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                                                <select name="deskripsi" id="deskripsi" class="form-control" required>
                                                    <option value="bagus">Bagus</option>
                                                    <option value="rusak">Rusak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="stok" class="form-label">Stok Barang</label>
                                                <input type="number" name="stok" id="stok" class="form-control"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="asal" class="form-label">Asal Barang</label>
                                                <select name="asal" id="asal" class="form-control">
                                                    <?php
                                                    $Admin->asalBarang();
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="mb-3">
                                                <label for="tahun_pengadaan" class="form-label">Tahun
                                                    Penerimaan</label>
                                                <input type="date" name="tahun_pengadaan" id="tahun_pengadaan"
                                                    class="form-control" value="">
                                            </div>
                                            <script>
                                                function coba() {
                                                    var selected = document.getElementById('asal');
                                                    var selected1 = document.getElementById('asall');
                                                    const coba = selected.value.split(', ');
                                                    selected1.value = coba[0];
                                                    var tahun = document.getElementById('tahun_penerimaan');
                                                    tahun.value = coba[1];
                                                    const $options = Array.from(selected.options);
                                                    const optionToSelect = $options.find(item => item.text === coba[0]);
                                                    optionToSelect.selected = true;
                                                    console.log(selected1.value);
                                                }
                                            </script> -->
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Foto Barang</label><br>
                                                <input type="file" name="foto" id="foto" class="" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                name="addnewbarang">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tabelBarang" width="100%"
                                cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th>Stok</th>
                                        <th>Asal</th>
                                        <!-- <th>Tahun Penerimaan</th> -->
                                        <th>Foto</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $Admin->tabelBarang();
                                    ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
                <script>
                    function searchTable() {
                        const searchText = document.getElementById('search').value.toLowerCase();
                        const table = document.getElementById('dataTable');
                        const rows = table.getElementsByTagName('tr');

                        for (let i = 0; i < rows.length; i++) {
                            const cells = rows[i].getElementsByTagName('td');
                            let found = false;

                            for (let j = 0; j < cells.length; j++) {
                                const cellText = cells[j].innerText.toLowerCase();

                                if (cellText.includes(searchText)) {
                                    found = true;
                                    break;
                                }
                            }

                            if (found) {
                                rows[i].style.display = '';
                            } else {
                                rows[i].style.display = 'none';
                            }
                        }
                    }
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var popupLinks = document.querySelectorAll('.popup-link');

                        popupLinks.forEach(function (link) {
                            link.addEventListener('click', function (e) {
                                e.preventDefault();

                                var imageUrl = this.getAttribute('data-image');

                                // Open a popup window with the image
                                window.open(imageUrl, '_blank', 'width=800,height=600,resizable=yes');
                            });
                        });
                    });
                </script>

                <!-- Modal Edit -->
                <?php
                $result = $Admin->get_barang();
                foreach ($result as $rowEdit) {

                    ?>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $rowEdit['idBarang'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title text-primary">Edit Barang</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <form action="../../function/update.php?jenis=updateBarang" method="post"
                                        enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <input type="hidden" name="idBarang" value="<?= $rowEdit['idBarang'] ?>">
                                            <label for="namaBarang" class="form-label">Nama Barang</label>
                                            <input type="text" name="namaBarang" id="namabarang" class="form-control"
                                                required value="<?= $rowEdit['namaBarang'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <input type="hidden" name="idBarang" value="<?= $rowEdit['idBarang'] ?>">
                                            <label for="kd_Barang" class="form-label">Kode Barang</label>
                                            <input type="text" name="kd_Barang" id="kd_barang" class="form-control" required
                                                value="<?= $rowEdit['kd_Barang'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                                            <select name="deskripsi" id="deskripsi" class="form-control" required>
                                                <option value="bagus">Bagus</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stok" class="form-label">Stok Barang</label>
                                            <input type="number" name="stok" id="stok" class="form-control" required
                                                value="<?= $rowEdit['stok'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="asal" class="form-label">Asal Barang</label>
                                            <select name="asal" id="asalEdit" class="form-control">
                                                <?php
                                                $Admin->asalBarang();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Foto Barang</label><br>
                                            <input type="file" name="foto" id="foto" class="" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="editbarang">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal<?= $rowEdit['idBarang'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title text-danger">Delete Barang</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this barang?</p>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="../../function/delete.php?id=<?= $rowEdit['idBarang'] ?>&type=barang"
                                        class="btn btn-danger">delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- <script>
                    document.getElementById('asal').addEventListener('input', function () {
                        var selectedOption = this.options[this.selectedIndex];
                        var tahunPenerimaan = selectedOption.getAttribute('data-tahun');
                        document.getElementById('tahun_penerimaan').value = tahunPenerimaan;
                    });
                </script>
                <script>
                    document.getElementById('asalEdit').addEventListener('input', function () {
                        var selectedOption = this.options[this.selectedIndex];
                        var tahunPenerimaan = selectedOption.getAttribute('data-tahun');
                        document.getElementById('tahun_penerimaan').value = tahunPenerimaan;
                    });
                </script> -->

                <!-- Begin Page Content -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#tabelBarang');
    </script>

</body>

</html>