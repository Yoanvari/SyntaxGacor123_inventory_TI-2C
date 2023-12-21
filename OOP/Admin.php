<?php
require_once '../../config/koneksi.php';
include 'User.php';
class Admin extends User
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }
    private function antiinjection($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return mysqli_real_escape_string($this->koneksi, $data);
    }
    public function tambahBarang()
    {
        $koneksi = new DatabaseConnection();
        if (isset($_POST['addnewbarang'])) {
            $kdBarang = $this->antiinjection($_POST['kdBarang']);
            $namaBarang = $this->antiinjection($_POST['namaBarang']);
            $deskripsi = $this->antiinjection($_POST['deskripsi']);
            $stok = $this->antiinjection($_POST['stok']);
            $gambar_barang = $_FILES['foto']['name'];
            $tmpFile = $_FILES['foto']['tmp_name'];
            $targetDirImg = $_SERVER['DOCUMENT_ROOT'] . '../img/';
            $this->uploadFile($tmpFile, $targetDirImg, $gambar_barang);
            $foto = $this->antiinjection($gambar_barang);
            $asal = $this->antiinjection($_POST['asal']);
            $tahun_penerimaan = $this->antiinjection($_POST['tahun_penerimaan']);

            // Insert data into the database
            $query = "INSERT INTO barang (kdBarang, namaBarang, deskripsi, stok, foto, asal, tahun_penerimaan) 
                      VALUES ('$kdBarang', '$namaBarang', '$deskripsi', '$stok', '$foto', '$asal', '$tahun_penerimaan')";

            if (mysqli_query($koneksi->getConnection(), $query)) {
                // Data inserted successfully
                echo "Data inserted successfully.";
            } else {
                // Handle the error
                echo "Error: " . mysqli_error($koneksi->getConnection());
            }
        }
    }

    private function uploadFile($tmpFile, $targetDir, $fileName)
    {
        move_uploaded_file($tmpFile, $targetDir . $fileName);
    }

    public function tabelBarang()
    {
        $koneksi = new DatabaseConnection();
        $result = mysqli_query($koneksi->getConnection(), "SELECT * FROM barang");

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['kdBarang'] . "</td>";
                    echo "<td>" . $row['namaBarang'] . "</td>";
                    echo "<td>" . $row['deskripsi'] . "</td>";
                    echo "<td>" . $row['stok'] . "</td>";
                    echo "<td>" . $row['asal'] . "</td>";
                    echo "<td>" . $row['tahun_penerimaan'] . "</td>";
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
        } else {
            echo "Error: " . mysqli_error($koneksi->getConnection());
        }
    }

    public function asalBarang()
    {
        $koneksi = new DatabaseConnection();
        $result_anggaran = mysqli_query($koneksi->getConnection(), "SELECT * FROM anggaran");
        while ($row_anggaran = mysqli_fetch_assoc($result_anggaran)) {
            echo "<option value='" . $row_anggaran['asal'] . "' data-tahun='" . $row_anggaran['tahun_penerimaan'] . "'>" . $row_anggaran['asal'] . "</option>";
        }
    }

    public function hapusBarang($id)
    {
        // Prepare the DELETE statement with placeholders to prevent SQL injection
        $stmt = $this->koneksi->prepare("DELETE FROM barang WHERE idBarang = ?");

        // Bind the parameter to the statement
        $stmt->bind_param("i", $id); // 'i' denotes the type of the parameter, which is integer

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Data barang berhasil dihapus.";
            header('Location: http://localhost:3000/admin/module/barang.php');
            exit();
        } else {
            echo "Gagal menghapus data barang: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    public function editBarang()
    {
        if (isset($_POST['editbarang'])) { // Make sure this matches your submit button's name attribute
            $idBarang = $this->antiinjection($_POST['idBarang']);
            $namaBarang = $this->antiinjection($_POST['namaBarang']);
            $deskripsiBarang = $this->antiinjection($_POST['deskripsi']);
            $stokBarang = $this->antiinjection($_POST['stok']);
            $asalBarang = $this->antiinjection($_POST['asal']);
            $tahun_penerimaan = $this->antiinjection($_POST['tahun_penerimaan']);

            $foto = $_FILES['foto']['name'] ? $_FILES['foto']['name'] : $this->antiinjection($_POST['existingFoto']);
            $tmpFile = $_FILES['foto']['tmp_name'];
            $targetDirImg = "../../img/";

            if ($foto) {
                $this->uploadFile($tmpFile, $targetDirImg, $foto);
            }

            $stmt = $this->koneksi->prepare("UPDATE barang SET namaBarang = ?, deskripsi = ?, stok = ?, asal = ?, tahun_penerimaan = ?, foto = ? WHERE idBarang = ?");
            $stmt->bind_param("ssisssi", $namaBarang, $deskripsiBarang, $stokBarang, $asalBarang, $tahun_penerimaan, $foto, $idBarang);

            if ($stmt->execute()) {
                echo "Data barang berhasil diupdate.";
                header('Location: ../admin/module/barang.php'); // Make sure this location is correct
                exit();
            } else {
                echo "Gagal update data barang: " . $stmt->error;
            }

            $stmt->close();
        }
    }
    public function addUser($data)
    {
        ob_start(); // Mulai output buffering

        // Extract user data
        $nama_lengkap = $data['nama_lengkap'];
        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];
        $alamat = $data['alamat'];
        $jabatan = $data['jabatan'];
        $level = $data['level'];
        $status = $data['status'];

        // Use prepared statements to prevent SQL injection
        $stmt = $this->koneksi->prepare("INSERT INTO user (nama_lengkap, email, username, password, alamat, jabatan, level, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Determine parameter types dynamically
            $paramTypes = str_repeat('s', count($data));

            // Bind parameters to the prepared statement
            $stmt->bind_param($paramTypes, $nama_lengkap, $email, $username, $hashedPassword, $alamat, $jabatan, $level, $status);

            if ($stmt->execute()) {
                ob_end_clean(); // Hapus semua output buffering sebelumnya
                header("Location: http://localhost:3000/admin/module/list_user/list.php");
                exit();
            } else {
                ob_end_clean(); // Hapus semua output buffering sebelumnya
                $this->handleError("Menambahkan Data User Gagal: " . $stmt->error);
            }
        } else {
            ob_end_clean(); // Hapus semua output buffering sebelumnya
            $this->handleError("Prepared statement error: " . $this->koneksi->error);
        }
    }
    private function handleError($errorMessage)
    {
        pesan('danger', $errorMessage);
        echo "Error: " . $errorMessage;
        die();
    }

    private function pesan($type, $message)
    {
        // Define CSS classes for different message types
        $cssClasses = [
            'success' => 'alert-success', // Example class for success messages
            'danger' => 'alert-danger',  // Example class for error messages
            // Add more types as needed
        ];

        // Check if the specified type exists in the CSS classes array
        if (array_key_exists($type, $cssClasses)) {
            $class = $cssClasses[$type];
        } else {
            // Default class if type is not found
            $class = 'alert-info';
        }

        // Display the message
        echo "<div class='alert {$class}'>{$message}</div>";
    }
    public function addNewAnggaran($asal, $tahun_penerimaan)
    {
        $asal = $this->antiinjection($asal);
        $tahun_penerimaan = $this->antiinjection($tahun_penerimaan);

        $query = "INSERT INTO anggaran (asal, tahun_penerimaan) VALUES (?, ?)";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("ss", $asal, $tahun_penerimaan);

        if ($stmt->execute()) {
            $this->pesan('success', "Data Anggaran Baru Ditambahkan.");
        } else {
            $this->pesan('danger', "Menambahkan Data Anggaran Gagal: " . $stmt->error);
        }
    }
    public function updateAnggaran($idAnggaran, $asalAnggaran, $tahun_penerimaan)
    {
        // Validate inputs
        if (empty($idAnggaran) || empty($asalAnggaran) || empty($tahun_penerimaan)) {
            echo "Error: Invalid input data";
            return;
        }

        $query = "UPDATE anggaran SET asal = ?, tahun_penerimaan = ? WHERE idAnggaran = ?";
        $stmt = $this->koneksi->prepare($query);

        // Check if prepare was successful
        if ($stmt === false) {
            echo "Error in prepare statement: " . $this->koneksi->error;
            return;
        }

        $stmt->bind_param("ssi", $asalAnggaran, $tahun_penerimaan, $idAnggaran);

        if ($stmt->execute()) {
            header('Location: ../admin/module/anggaran.php');
            exit();
        } else {
            echo "Gagal update data anggaran: " . $stmt->error;
        }
    }
    public function deleteAnggaran($id)
    {
        $query = "DELETE FROM anggaran WHERE idAnggaran = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Data anggaran berhasil dihapus.";
            header('Location: http://localhost:3000/admin/module/anggaran.php');
            exit();
        } else {
            echo "Gagal menghapus data anggaran: " . $stmt->error;
        }
    }
    public function tabelAnggaran()
    {
        $result = mysqli_query($this->koneksi, "SELECT * FROM anggaran");

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['asal'] . "</td>";
                    echo "<td>" . $row['tahun_penerimaan'] . "</td>";
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
        } else {
            echo "Error: " . mysqli_error($this->koneksi);
        }
    }

    public function tabelUser()
    {
        $koneksi = new DatabaseConnection();
        $result = mysqli_query($koneksi->getConnection(), "SELECT * FROM user");

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
                    echo "<td>" . $row['jabatan'] . "</td>";
                    echo "<td>" . $row['level'] . "</td>";
                    echo "<td style='color: $statusColor;'>" . $row['status'] . "</td>";
                    echo "<td>
                            <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $row['id'] . "'>Edit</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
            }
        } else {
            echo "Error: " . mysqli_error($koneksi->getConnection());
        }
    }
    // Overriding method 'aksi'
    public function aksi($approveOrReject)
    {
        if ($approveOrReject) {
            // Approve logic
        } else {
            // Reject logic
        }
    }
}
?>