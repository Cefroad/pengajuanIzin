<?php
include "koneksi.php";  
session_start();         

if (!isset($_SESSION['id_admin'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $name = $_POST['nama'];  
    $email = $_POST['email'];

    $user_id = $_SESSION['id_admin'];

    $query = "UPDATE admin SET username='$username', nama='$name', email='$email' WHERE id_admin='$user_id'";

    if (mysqli_query($connect, $query)) {
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $name;
        $_SESSION['email'] = $email;

        echo "<script>alert('Data Berhasil Diubah');window.location='view-setting.php';</script>";
        exit(); 
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}

mysqli_close($connect);
?>
