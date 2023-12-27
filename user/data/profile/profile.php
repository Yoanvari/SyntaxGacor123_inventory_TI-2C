<?php
session_start();
require_once '../../../OOP/CRUD.php';
require_once '../../../config/koneksi.php';
require_once '../../../OOP/user.php';
require_once '../../../OOP/Pengguna.php';
$koneksi = new DatabaseConnection();
$user = new User($koneksi);
$pengguna = new Pengguna($koneksi);
// untuk admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika tidak, redirect ke login.php
    header('Location: ../login.php');
    exit();
}
$userId = $_SESSION['id']; // Ambil userId dari sesi
$jenisKelamin = $pengguna->get_user($userId);

if (isset($_SESSION['jenis_kelamin'])) {
    $avatarFile = $pengguna->getAvatarByGender($_SESSION['jenis_kelamin']);
} else {
    // Handle jika 'jenis_kelamin' tidak ada dalam sesi
    $avatarFile = 'default_avatar.png'; // Atur avatar default
}

if (isset($_SESSION['alert'])) {
    $alertType = $_SESSION['alert']['type'];
    $alertMessage = $_SESSION['alert']['message'];

    echo "<script>alert('$alertMessage');</script>";

    // Hapus session setelah ditampilkan
    unset($_SESSION['alert']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>profile with data and skills - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
        }

        .main-body {
            padding: 15px;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-body">
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../../index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User</li>
                </ol>
            </nav>

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <?php
                                if ($jenisKelamin) {
                                    if ($jenisKelamin === 'laki-laki') {
                                        echo '<img src="https://cdn.icon-icons.com/icons2/3708/PNG/512/man_person_people_avatar_icon_230017.png" width="200" height="200">';
                                    } elseif ($jenisKelamin === 'perempuan') {
                                        echo '<img src="http://localhost/xampp/lkqodnwnefiwneufoin/inventaris/inventaris/img/woman3.png" width="200" height="200">';
                                    } else {
                                        // Handle jika jenis kelamin tidak dikenali
                                        echo "Avatar tidak tersedia.";
                                    }
                                } else {
                                    // Handle jika data pengguna tidak ditemukan
                                    echo "Data pengguna tidak ditemukan.";
                                }
                                ?>
                                <div class="mt-3">
                                    <h4>
                                        <?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'Nama Pengguna'; ?>
                                    </h4>
                                    <p class="text-secondary mb-1">
                                        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'username'; ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'Nama Pengguna'; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'email'; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Username</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'username'; ?>
                                </div>
                            </div>
                            <hr>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo isset($_SESSION['alamat']) ? $_SESSION['alamat'] : 'alamat'; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="editProfile.php" class="btn btn-info">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>