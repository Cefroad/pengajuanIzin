<?php
session_start();
include 'koneksi.php'; 

if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Sesi Telah Habis Silahkan Login Kembali');window.location='../';</script>";
    exit;
}
$id = $_SESSION['id_admin'];


if (isset($_POST['delete'])) {
    $query = "UPDATE admin SET profile_picture = NULL, image_type = NULL WHERE id_admin = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $id_karyawan);

    if ($stmt->execute()) {

        echo "<script>
                alert('Gambar berhasil dihapus.');
                window.location.href = 'view-settings.php';
              </script>";
    } else {
 
        echo "<script>
                alert('Gagal menghapus gambar.');
                window.location.href = 'view-settings.php';
              </script>";
    }

    $stmt->close();
    $connect->close();
    exit;
}


if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['fileInput'];
    $fileData = file_get_contents($file['tmp_name']);
    $fileType = $file['type'];


    $allowedTypes = ['image/jpeg', 'image/png'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>
                alert('Hanya file JPEG atau PNG yang diperbolehkan.');
                window.location.href = 'view-settings.php'; 
              </script>";
        exit;
    }

    $query = "UPDATE karyawan SET profile_picture = ?, image_type = ? WHERE id_karyawan = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("bsi", $fileData, $fileType, $id_karyawan);
    $stmt->send_long_data(0, $fileData);

    if ($stmt->execute()) {
  
        echo "<script>
                alert('Gambar berhasil diunggah.');
                window.location.href = 'view-settings.php'; 
              </script>";
    } else {
   
        echo "<script>
                alert('Gagal mengunggah gambar.');
                window.location.href = 'view-settings.php'; 
              </script>";
    }

    $stmt->close();
    $connect->close();
    exit;
}
?>
