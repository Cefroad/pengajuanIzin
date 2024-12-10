<?php
session_start();
include "koneksi.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Mengambil ID gambar dari parameter URL
$id_karyawan = $_SESSION['id_karyawan']; 

// Pastikan ID karyawan tidak kosong
if (!$id_karyawan) {
    echo "ID Karyawan tidak ditemukan!";
    exit;
}

// Query untuk mengambil data gambar BLOB dan tipe gambar berdasarkan ID karyawan
$query = "SELECT profile_picture, image_type FROM karyawan WHERE id_karyawan = '$id_karyawan'";
$result = mysqli_query($connect, $query);

// Periksa apakah query berhasil
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $image_data = $row['profile_picture'];
    $image_type = $row['image_type']; // Mendapatkan tipe gambar dari database

    // Debug: Periksa apakah data gambar dan tipe gambar ditemukan
    if (empty($image_data)) {
        echo "Data gambar tidak ditemukan!";
        exit;
    }

    if (empty($image_type)) {
        echo "Tipe gambar tidak ditemukan!";
        exit;
    }

    // Menentukan header berdasarkan tipe gambar yang ditemukan
    if ($image_type == 'image/jpeg') {
        header("Content-Type: image/jpeg");
    } elseif ($image_type == 'image/png') {
        header("Content-Type: image/png");
    } elseif ($image_type == 'image/jpg') {
        header("Content-Type: image/jpg");
    } elseif ($image_type == 'image/svg+xml') {
        header("Content-Type: image/svg+xml");
    } else {
        echo "Tipe gambar tidak dikenali!";
        exit;
    }

    // Menampilkan gambar sesuai tipe
    echo $image_data;
} else {
    echo "Gambar tidak ditemukan!";
}
?>
