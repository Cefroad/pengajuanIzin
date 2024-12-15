<?php
session_start();
include "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT profile_picture, image_type FROM admin WHERE id_admin = '$id'";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_data = $row['profile_picture'];
        $image_type = $row['image_type'];

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

        echo $image_data;
    } else {
        echo "Gambar tidak ditemukan!";
    }
} else {
    echo "ID karyawan tidak ditemukan!";
}
?>
