<?php
session_start();
include 'koneksi.php'; // File koneksi database

// Pastikan user sudah login
if (!isset($_SESSION['id_karyawan'])) {
    header("Location: ../index.php");
    exit;
}

$id_karyawan = $_SESSION['id_karyawan'];

// Jika tombol Delete ditekan
if (isset($_POST['delete'])) {
    $query = "UPDATE karyawan SET profile_picture = NULL, image_type = NULL WHERE id_karyawan = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $id_karyawan);

    if ($stmt->execute()) {
        // Jika berhasil
        echo "<script>
                alert('Gambar berhasil dihapus.');
                window.location.href = 'user-settings.php'; // Redirect ke user-settings.php
              </script>";
    } else {
        // Jika gagal
        echo "<script>
                alert('Gagal menghapus gambar.');
                window.location.href = 'user-settings.php'; // Redirect ke user-settings.php
              </script>";
    }

    $stmt->close();
    $connect->close();
    exit;
}

// Jika file diunggah
if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['fileInput'];
    $fileData = file_get_contents($file['tmp_name']);
    $fileType = $file['type'];

    // Validasi tipe file
    $allowedTypes = ['image/jpeg', 'image/png'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>
                alert('Hanya file JPEG atau PNG yang diperbolehkan.');
                window.location.href = 'user-settings.php'; // Redirect ke user-settings.php
              </script>";
        exit;
    }

    // Simpan gambar ke database
    $query = "UPDATE karyawan SET profile_picture = ?, image_type = ? WHERE id_karyawan = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("bsi", $fileData, $fileType, $id_karyawan);
    $stmt->send_long_data(0, $fileData);

    if ($stmt->execute()) {
        // Jika berhasil
        echo "<script>
                alert('Gambar berhasil diunggah.');
                window.location.href = 'user-settings.php'; // Redirect ke user-settings.php
              </script>";
    } else {
        // Jika gagal
        echo "<script>
                alert('Gagal mengunggah gambar.');
                window.location.href = 'user-settings.php'; // Redirect ke user-settings.php
              </script>";
    }

    $stmt->close();
    $connect->close();
    exit;
}
?>
