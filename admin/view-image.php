<?php
session_start();
include "koneksi.php";

// Pastikan ada ID karyawan yang valid di URL
if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    // Query untuk mengambil gambar berdasarkan ID karyawan
    $query = "SELECT profile_picture, image_type FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_data = $row['profile_picture'];
        $image_type = $row['image_type'];

        // Tentukan header sesuai tipe gambar
        if ($image_type == 'image/jpeg') {
            header("Content-Type: image/jpeg");
        } elseif ($image_type == 'image/png') {
            header("Content-Type: image/png");
        } elseif ($image_type == 'image/svg+xml') {
            header("Content-Type: image/svg+xml");
        } else {
            echo "Tipe gambar tidak dikenali!";
            exit;
        }

        // Output gambar
        echo $image_data;
    } else {
        echo "Gambar tidak ditemukan!";
    }
} else {
    echo "ID karyawan tidak ditemukan!";
}
?>
