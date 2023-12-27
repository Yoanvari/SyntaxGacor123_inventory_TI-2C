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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profile with data and skills - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
                    <li class="breadcrumb-item"><a href="./profile.php">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
            </nav>

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <input type="file" class="form-control-file" id="foto" name="foto"
                                    style="display: none;">
                                <label for="foto" class="edit-photo-icon" style="position: relative; cursor: pointer;">
                                    <?php
                                    if ($jenisKelamin) {
                                        if ($jenisKelamin === 'laki-laki') {
                                            echo '<img src="https://cdn.icon-icons.com/icons2/3708/PNG/512/man_person_people_avatar_icon_230017.png" width="200" height="200">';
                                        } elseif ($jenisKelamin === 'perempuan') {
                                            echo '<img src="http://localhost/xampp/lkqodnwnefiwneufoin/inventaris/inventaris/img/woman3.png" width="200" height="200">';
                                        } else {
                                            echo "Avatar tidak tersedia.";
                                        }
                                    } else {
                                        echo "Data pengguna tidak ditemukan.";
                                    }
                                    ?>
                                    <i class="fas fa-camera" style="position: absolute; bottom: 5px; right: 5px;"></i>
                                </label>

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
                            <form action="../../../function/update.php?jenis=updateProfile" method="post"
                                enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="alamat"
                                        value="<?php echo isset($_SESSION['alamat']) ? $_SESSION['alamat'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password"
                                            value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                                id="togglePassword">
                                                <i class="fas fa-eye" id="passwordIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="foto" name="foto"
                                        style="display: none;">
                                </div>
                                <div class="mt-3">
                                    <input type="hidden" name="id"
                                        value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>">
                                    <button type="submit" name="editProfile" value="editProfile"
                                        class="btn btn-primary">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <!-- Tambahkan script JavaScript untuk mengaktifkan pengeditan foto -->
    <script>
        // Fungsi untuk memicu klik pada elemen input file ketika ikon gambar diklik
        document.querySelector(".edit-photo-icon").addEventListener("click", function () {
            document.getElementById("foto").click();
        });
    </script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            var passwordInput = document.getElementById("password");
            var passwordIcon = document.getElementById("passwordIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            }
        });

    </script>


</body>

</html>