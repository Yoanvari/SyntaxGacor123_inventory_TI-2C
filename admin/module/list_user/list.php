<?php
session_start();
include '../../../config/koneksi.php';
include '../../../OOP/user.php';
// untuk admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika tidak, redirect ke login.php
    header('Location: ../login.php');
    exit();
}
$user = new User($koneksi->getConnection());
$allUsers = $user->getAllUsers();
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

    <!-- Custom fonts for this template-->
    <link href="../../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../../../css/sb-admin-2.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link href="../../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
            <li class="nav-item">
                <a class="nav-link collapsed" href="/admin/datamaster.php" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Components:</h6>
                        <a class="collapse-item" href="../anggaran.php">Anggaran</a>
                        <a class="collapse-item" href="../barang.php">Barang</a>
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
                <a class="nav-link" href="../../module/peminjaman.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Peminjaman</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="../../module/history.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>History Peminjaman</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="../list.php">
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
                        <h1 class="h3 mb-0 text-gray-800">LIst User Inventory JTI</h1>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'Nama Pengguna'; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="../../../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../profile/profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout.php" data-toggle="modal" data-target="#logoutModal">
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah User
                            </button>
                            <div class="mb-3">
                                <input type="text" id="search" class="form-control" onkeyup="searchTable()" placeholder="Cari..." style="max-width: 200px;">
                            </div>
                        </div>
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title text-primary">Tambah User</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form action="../../../function/tambah.php" method="post">
                                            <div class="mb-3">
                                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" name="username" id="username" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" name="password" id="password" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <input type="alamat" name="alamat" id="alamat" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="level" class="form-label">Level</label>
                                                <select name="level" id="level" class="form-control" required>
                                                    <option value="admin">Admin</option>
                                                    <option value="user">User</option>
                                                    <!-- Tambahkan opsi sesuai kebutuhan -->
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                    <!-- Tambahkan opsi sesuai kebutuhan -->
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="addnewuser">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Alamat</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($koneksi, "SELECT * FROM user");

                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            $no = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $statusColor = (strtolower($row['status']) == 'active') ? '#00FF00' : 'red';
                                                echo "<tr>";
                                                echo "<td>" . $no++ . "</td>";
                                                echo "<td>" . $row['nama_lengkap'] . "</td>";
                                                echo "<td>" . $row['email'] . "</td>";
                                                echo "<td>" . $row['username'] . "</td>";
                                                echo "<td>" . $row['alamat'] . "</td>";
                                                echo "<td>" . $row['level'] . "</td>";
                                                echo "<td style='color: $statusColor;'>" . $row['status'] . "</td>";
                                                echo "<td>
                                                        <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id'] . "'>Edit</button>
                                                    </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                                        }
                                    } else {
                                        echo "Error: " . mysqli_error($koneksi);
                                    }
                                    ?>
                                </tbody>
                            </table>
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

                </div>
                <?php
                $result = mysqli_query($koneksi, "SELECT * FROM user");

                foreach ($result as $row) {
                ?>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $row['id'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title text-primary">Edit User</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <form action="../../../function/update.php" method="post">
                                        <div class="mb-3">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?= $row['nama_lengkap'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" value="<?= $row['email'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="username" id="username" class="form-control" value="<?= $row['username'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" name="alamat" id="alamat" class="form-control" value="<?= $row['alamat'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status" class="form-select" required>
                                                <option value="active" <?= ($row['status'] == 'active') ? 'selected' : ''; ?>>
                                                    Active</option>
                                                <option value="inactive" <?= ($row['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                <!-- Add other status options as needed -->
                                            </select>
                                        </div>
                                        <!-- Add other fields as needed -->
                                        <button type="submit" class="btn btn-primary" name="editUser">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>


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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <a class="btn btn-primary" href="../../../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../../vendor/jquery/jquery.min.js"></script>
    <script src="../../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../../js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="../../../vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../../../js/demo/chart-area-demo.js"></script>
    <script src="../../../js/demo/chart-pie-demo.js"></script>

</body>

</html>