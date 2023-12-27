<?php
session_start(); // Add session start

include('koneksi.php'); // Make sure to include your database connection file

var_dump($_POST);

if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../function/pesan_kilat.php';
    require '../function/anti_injection.php';

    $result = mysqli_query($koneksi, "SELECT * FROM anggaran");

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['asal'] . "</td>";
                // Add other columns as needed
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Tidak ada data</td></tr>";
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Handle the case when the user is not logged in
    echo "You are not logged in.";
    // You might want to redirect the user to a login page or take appropriate action
}
?>
