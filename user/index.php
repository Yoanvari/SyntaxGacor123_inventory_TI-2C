<?php
session_start();
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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        #add-row {
            padding-top: 0;
            padding-bottom: 0;
        }

        .container-barang{
            max-width: 1200px;
            width: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            padding: 0 2rem;
        }

        .cart-barang{
            position: fixed;
            inset: 0 0 0 auto;
            left: 100%;
            max-width: 350px;
            display: grid;
            grid-template-rows: 70px 1fr 70px;
            transition: 0.5s;
        }

        .active .cart-barang {
            left: calc(100% - 350px);
        }

        .item-cart{
            padding: 10px 0;
            display: grid; 
            grid-template-columns: 70px 150px 100px 1fr;
            gap: 10px;
            text-align: center;
            align-items: center;
            color: #eee;
        }

        .quantity-item span{
            display: inline-block;
            width: 25px;
            height: 25px;
            background-color: #eee;
            color: #555;
            border-radius: 50%;
            cursor: pointer;
        }

        .quantity-item span:nth-child(2){
            background-color: transparent;
            cursor: none;
            color: #eee;
        }

        .listItem::-webkit-scrollbar{
            width: 0;
        }

        .active .container-awal{
            padding-right: 350px;
            transition: 0.5s;
        }

        .container-awal{
            transition: 0.5s;
        }

        #img-item{
            width: 100px; 
            height:100px;
            border-radius: 6px;
            overflow: hidden;
        }

        #img-item img{
            object-fit: cover;
            width: 100%;
            transition: transform .5s ease-in-out;
        }

        #img-item:hover img{
            transform: scale(1.5) rotate(25deg);
        }

        .icon-cart{
            position: relative;
        }

        .icon-cart span{
            display: flex;
            width: 25px;
            height: 25px;
            background-color: red;
            justify-content: center;
            align-content: center;
            color: #fff;
            position: absolute;
            border-radius: 50%;
            top: 40%;
            right: -10px;
        }

        .form-control:hover{
            box-shadow: none;
        }

        .containerGrid{
            display: grid;
            grid-template-rows: 100px 1fr;
        }

        .card:hover{
            transform: scale(1);
        }

        .cardItems{
            display: grid;
            grid-template-rows: 100px 1fr 1fr 35px;
        }
    </style>
</head>

<body class="" id="page-top">

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
            <!-- <li class="nav-item">
                <a class="nav-link menu" id="dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link menu" id="pinjamBarang">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Pinjam Barang</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link menu" id="list">
                    <i class="fas fa-fw fa-table"></i>
                    <span>List Peminjaman</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link menu" id="history">
                    <i class="fas fa-fw fa-table"></i>
                    <span>History</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="min-width:650px; overflow: auto;">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

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
                                <img class="img-profile rounded-circle"
                                    src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="data/profile/profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/login.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <main id="pageContent">
                
                </main>
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
    <!-- Modal Notifikasi -->
    <div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="notifModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifModalLabel">Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten notifikasi akan ditampilkan di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <!-- <script src="../vendor/chart.js/Chart.min.js"></script> -->
    <!--Datatables-->
    <!-- <script src="../vendor/bootstrap/js/plugin/datatables/datatables.min.js"></script> -->
    <!-- Page level custom scripts -->
    <!-- <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script> -->
    <!-- <script src="jquery-3.6.0.min.js"></script> -->
    <script>
        function hapusPinjam($id) {
            $.ajax({
                type: "POST",
                url: "proses-cart.php",
                data: {"proses" : "hapusPinjam","id" : $id},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if (response.message === "success") {
                        showNotificationModal("Pembatalan Berhasil", "Pinjaman telah dibatalkan.");

                        setTimeout(function() {
                            $("#pageContent").load("data/listPeminjaman.php");
                        }, 500);
                    }
                }
            });
        }

        function kembalikan($id) {
            $.ajax({
                type: "POST",
                url: "proses-cart.php",
                data: {"proses" : "kembalikan","id" : $id},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if (response.message === "success") {
                        showNotificationModal("Pengembalian Berhasil", "Barang berhasil dikembalikan.");

                        setTimeout(function() {
                            $("#pageContent").load("data/history.php");
                        }, 500);
                    }
                }
            });
        }

        function pinjam() {
            var tglMulai = document.getElementsByName("tgl_mulai")[0].value;
            var tglSelesai = document.getElementsByName("tgl_selesai")[0].value;
            if (tglMulai > tglSelesai) {
                alert("Tanggal Mulai tidak boleh lebih besar dari Tanggal Selesai");
                return;
            }
            $.ajax({
                type: "POST",
                url: "proses-cart.php",
                data: {"proses" : "pinjam", "tgl_mulai" : tglMulai, "tgl_selesai" : tglSelesai},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if (response.message === "success") {                        
                        showNotificationModal("Peminjaman Berhasil", "Tunggu persetujuan dari admin.");

                        setTimeout(function() {
                            $("#pageContent").load("data/listPeminjaman.php");
                        }, 500);
                    }
                }
            });
        }
        
        function countCart() {
            $.ajax({
                type: "GET",
                url: "proses-cart.php",
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    var count = response;
                    $("#countCart").text(count);
                }
            });
        };

        function addCart($id) {
            $.ajax({
                type: "POST",
                url: "proses-cart.php",
                data: {"proses" : "add","id" : $id},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if (response.message === "rusak") {
                        alert('Barang tidak dapat dipinjam karena rusak');
                    } else if (response.message === "success") {
                        reloadContent();
                    } else if (response.message === "Stok_Kurang") {
                        alert('Stok Kurang Dari Jumlah Pinjam');
                    }
                }
            });
        }

        function plusCart($id) {
            $.ajax({
                type: "POST",
                url: "proses-cart.php",
                data: {"proses" : "plus","id" : $id},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);

                    if (response.message === "Stok_Kurang") {
                        alert('Stok Kurang Dari Jumlah Pinjam');
                    } else if (response.message === "success") {
                        reloadContent();
                    }
                }
            });
        }

        function minusCart($id) {
            $.ajax({
                type: "POST",
                url: "proses-cart.php",
                data: {"proses" : "minus","id" : $id},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    reloadContent();
                }
            });
        }

        function reloadContent() {
            $("#pageContent").load("data/pinjamBarang.php");
            setTimeout(function() {
                countCart();
            }, 100);
        }

        $(document).ready(function () {
            let body = document.querySelector("body");

            // Tambahkan event listener untuk membuka cart
            $(document).on("click", ".icon-cart", function () {
                body.classList.toggle('active');
            });

            // Tambahkan event listener untuk menutup cart
            $(document).on("click", "#close", function () {
                body.classList.toggle('active');
            });

            // Load content dan countCart
            reloadContent();

            $('.menu').click(function (e) { 
                e.preventDefault();

                var menu = $(this).attr('id');

                if(menu == "dashboard") {
                    $('#pageContent').load('data/dashboard.php');
                } else if(menu == "pinjamBarang") {
                    reloadContent();
                } else if(menu == "list") {
                    $('#pageContent').load('data/listPeminjaman.php');
                } else if(menu == "history") {
                    $('#pageContent').load('data/history.php');
                }
                
            });

        });

        function showNotificationModal(title, message) {
            // Mengganti konten modal dengan pesan notifikasi
            $("#notifModalLabel").text(title);
            $(".modal-body").html("<p>" + message + "</p>");

            // Menampilkan modal
            $("#notifModal").modal("show");
        }

        // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        // return new bootstrap.Tooltip(tooltipTriggerEl)
        // });
	</script>
</body>
</html>