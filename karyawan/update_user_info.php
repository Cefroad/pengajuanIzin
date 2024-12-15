<?php
include "koneksi.php";  // Include the database connection file
session_start();         // Start the session

// Cek jika user sudah login
if (!isset($_SESSION['id_karyawan'])) {
    header("Location: ../index.php");
    exit();
}

// Cek jika form dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form dan melindungi terhadap SQL injection
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $name = mysqli_real_escape_string($connect, $_POST['nama']);  // 'name' sesuai dengan name di input form
    $email = mysqli_real_escape_string($connect, $_POST['email']);

    // Ambil ID karyawan dari session
    $user_id = $_SESSION['id_karyawan'];

    // Query untuk update data
    $query = "UPDATE karyawan SET username='$username', nama='$name', email='$email'  WHERE id_karyawan='$user_id'";

    // Eksekusi query
    if (mysqli_query($connect, $query)) {
        // Jika berhasil, update session
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $name;
        $_SESSION['email'] = $email;

        // Redirect ke halaman user-settings dengan status success
        echo "<script>alert('Data Berhasil Di ubah');window.location='user-settings.php';</script>";
        exit();  // Pastikan selalu menggunakan exit setelah header untuk menghentikan eksekusi skrip
    } else {
        // Jika gagal, tampilkan error
        echo "Error updating record: " . mysqli_error($connect);
    }
}

// Tutup koneksi database
mysqli_close($connect);
?>
