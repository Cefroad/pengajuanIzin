<?php
session_start();
include "koneksi.php";  // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user_type = $_POST["user_type"];  // Menyimpan pilihan user type dari dropdown

    // Memilih query berdasarkan jenis user (Karyawan atau Admin)
    if ($user_type == 'karyawan') {
        // Cek login untuk Karyawan
        $result = mysqli_query($connect, "SELECT * FROM karyawan WHERE username = '$username' AND password = '$password'");
        $cek = mysqli_num_rows($result);
        if ($cek > 0) {
            $data = mysqli_fetch_assoc($result);
            $_SESSION['id_karyawan'] = $data['id_karyawan'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['status'] = $data['status'];
            echo "<script>alert('Login Berhasil!'); window.location='user.php';</script>";
        } else {
            echo "<script>alert('Username atau Password Salah!'); window.location='index.php';</script>";
        }
    } else if ($user_type == 'admin') {
        // Cek login untuk Admin
        $result1 = mysqli_query($connect, "SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
        $cek1 = mysqli_num_rows($result1);
        if ($cek1 > 0) {
            $data1 = mysqli_fetch_assoc($result1);
            $_SESSION['id_admin'] = $data1['id_admin'];
            $_SESSION['username'] = $data1['username'];
            $_SESSION['namaAdmin'] = $data1['nama'];
            $_SESSION['email'] = $data1['email'];
            echo "<script>alert('Login Berhasil!'); window.location='./admin/admin-panel.php';</script>";
        } else {
            echo "<script>alert('Username atau Password Salah!'); window.location='index.php';</script>";
        }
    } else {
        // Jika user type tidak dipilih
        echo "<script>alert('Pilih Jenis User terlebih dahulu!'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Login Form</title>
    <style>
        /* Menambah styling untuk select box */
        select {
            padding-right: 2rem;  
            appearance: none;     
            -webkit-appearance: none; 
            -moz-appearance: none;    
        }
        select + span {
            font-size: 1.2rem;  
            pointer-events: none; 
            transition: color 0.3s ease;
        }
        select:focus + span {
            color: #4CAF50; 
        }

        input {
            padding-left: 2.5rem; 
        }
    </style>
</head>

<body class="text-gray-800 font-inter">
    <!-- Kode card box login -->
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-5 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <div class="flex flex-col justify-center items-center text-3xl">
    <!-- Teks PBL - 114 dalam satu baris -->
    <div class="flex items-center">
        <b>PBL</b> - 114
    </div>

    <!-- Teks Aplikasi Pengajuan Izin yang berada di bawah PBL 114 -->
    <p class="text-sm mt-2">Aplikasi Pengajuan Izin</p>
</div>


                    
                    <form class="space-y-4 md:space-y-6" action="" method="post">
                        <!-- Dropdown untuk memilih jenis user -->
                        <div class="relative">
                            <select id="user-type" name="user_type" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="#">Pilih Jenis User</option>
                                <option value="karyawan">Karyawan</option>
                                <option value="admin">Admin</option>
                            </select>
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="ri-arrow-drop-down-line"></i>
                            </span>
                        </div>

                        <!-- Input untuk username -->
                        <div class="relative">
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-user-fill"></i>
                            </span>
                            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Username" required>
                        </div>

                        <!-- Input untuk password -->
                        <div class="relative">
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-lock-fill"></i>
                            </span>
                            <input type="password" name="password" id="password" placeholder="Password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <!-- Tombol submit -->
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>




