<?php
session_start();
include '../config/koneksi.php';
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

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <!-- Sertakan Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



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
            <li class="nav-item active" id="dashboardItem">
                <a class="nav-link" href="index.php">
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
            <li class="nav-item" id="dataMasterItem">
                <a class="nav-link collapsed" href="datamaster.php" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Components:</h6>
                        <a class="collapse-item" href="./module/anggaran.php">Anggaran</a>
                        <a class="collapse-item" href="./module/barang.php">Barang</a>

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
            <li class="nav-item" id="">
                <a class="nav-link" href="./module/peminjaman.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Peminjaman</span></a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="./module/history.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>History Peminjaman</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="./module/list_user/list.php">
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

                    <!-- Topbar Search -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
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
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>

                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="./module/profile/profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div> -->

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Data Anggaran Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="./module/anggaran.php" class="card-link text-decoration-none">
                                <div class="card custom-card border-left-primary shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Data Anggaran</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <i class="fas fa-money-bill-wave fa-lg text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Data Barang Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="./module/barang.php" class="card-link text-decoration-none">
                                <div class="card custom-card border-left-success shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Data Barang</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <i class="fas fa-box fa-lg text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Data Peminjaman Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="./module/peminjaman.php" class="card-link text-decoration-none">
                                <div class="card custom-card border-left-peminjaman shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="text-xs font-weight-bold text-peminjaman text-uppercase mb-1">
                                                    Data Peminjaman</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <i class="fas fa-handshake fa-lg text-peminjaman"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Data User Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href="./module/list_user/list.php" class="card-link text-decoration-none">
                                <div class="card custom-card border-left-warning shadow h-100 py-2">
                                    <div class="card-body text-center">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Data User</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <i class="fas fa-users fa-lg text-warning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <style>
                            /* Bar Chart Styles */
                            #barChartContainer {
                                max-width: 800px;
                                margin: 20px auto;
                                border: 1px solid #ddd;
                                border-radius: 8px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            }

                            #barChartCanvas {
                                width: 100%;
                                height: 400px;
                            }

                            /* Pie Chart Styles */
                            #pieChartContainer {
                                max-width: 400px;
                                margin: 20px auto;
                                border: 1px solid #ddd;
                                border-radius: 8px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            }

                            #pieChartCanvas {
                                width: 100%;
                                height: 300px;
                            }
                        </style>

                        <!-- Bar Chart -->
                        <div class="col-xl-6 col-md-12 mb-4" id="barChartContainer">
                            <canvas id="barChartCanvas"></canvas>
                            <?php
                            // Fetch data for the bar chart
                            $barChartResult = mysqli_query($koneksi, "SELECT asal, COUNT(*) as total FROM barang GROUP BY asal");
                            $barChartLabels = [];
                            $barChartValues = [];

                            while ($row = mysqli_fetch_assoc($barChartResult)) {
                                $barChartLabels[] = $row['asal'];
                                $barChartValues[] = $row['total'];
                            }
                            ?>
                            <script>
                                // Bar chart
                                var ctxB = document.getElementById("barChartCanvas").getContext('2d');
                                var myBarChart = new Chart(ctxB, {
                                    type: 'bar',
                                    data: {
                                        labels: <?php echo json_encode($barChartLabels); ?>,
                                        datasets: [{
                                            label: 'Total Barang',
                                            data: <?php echo json_encode($barChartValues); ?>,
                                            backgroundColor: [
                                                'rgba(75, 192, 192, 0.7)',
                                                'rgba(255, 99, 132, 0.7)',
                                                'rgba(255, 206, 86, 0.7)',
                                                'rgba(54, 162, 235, 0.7)',
                                                'rgba(153, 102, 255, 0.7)',
                                            ],
                                            borderColor: [
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(153, 102, 255, 1)',
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                display: false
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>

                        <!-- Pie Chart -->
                        <div id="pieChartContainer">
                            <canvas id="pieChartCanvas"></canvas>
                            <?php
                            // Fetch data for the pie chart
                            $statusCounts = [
                                'active' => 0,
                                'inactive' => 0,
                            ];

                            $query = mysqli_query($koneksi, 'SELECT status, COUNT(*) as total FROM user GROUP BY status');
                            while ($row = mysqli_fetch_assoc($query)) {
                                $statusCounts[$row['status']] = $row['total'];
                            }
                            ?>
                            <script>
                                // Pie chart
                                var ctxP = document.getElementById("pieChartCanvas").getContext('2d');
                                var myPieChart = new Chart(ctxP, {
                                    type: 'pie',
                                    data: {
                                        labels: ['Active', 'Inactive'],
                                        datasets: [{
                                            data: [<?php echo $statusCounts['active']; ?>, <?php echo $statusCounts['inactive']; ?>],
                                            backgroundColor: [
                                                '#36A2EB',
                                                '#FF6384',
                                            ],
                                            hoverBackgroundColor: [
                                                '#36A2EB',
                                                '#FF6384',
                                            ]
                                        }]
                                    },
                                    options: {
                                        responsive: true
                                    }
                                });
                            </script>
                        </div>






                    </div>

                </div>
                <!-- /.container-fluid -->
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
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Dapatkan semua elemen nav-item
        const navItems = document.getElementsByClassName("nav-item");

        // Tambahkan event listener klik pada setiap elemen nav-item
        for (let i = 0; i < navItems.length; i++) {
            navItems[i].addEventListener("click", function() {
                // Hapus kelas "active" dari semua elemen nav-item
                for (let j = 0; j < navItems.length; j++) {
                    navItems[j].classList.remove("active");
                }

                // Tambahkan kelas "active" ke elemen nav-item yang diklik
                this.classList.add("active");
            });
        }
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

</body>

</html>