<?php
session_start();
include "koneksi.php";

// Ambil ID karyawan dari sesi
$id_karyawan = $_SESSION['id_karyawan'];

// Query untuk menghitung total izin
$queryTotalIzin = "SELECT COUNT(*) AS totalIzin FROM pengajuan_izin WHERE id_karyawan = $id_karyawan";
$resultTotalIzin = mysqli_query($connect, $queryTotalIzin);
$rowTotalIzin = mysqli_fetch_assoc($resultTotalIzin);
$totalIzin = $rowTotalIzin['totalIzin'];

// Query untuk menghitung total izin yang ditolak
$queryTotalDitolak = "SELECT COUNT(*) AS totalDitolak FROM pengajuan_izin WHERE id_karyawan = $id_karyawan AND status = 'Ditolak'";
$resultTotalDitolak = mysqli_query($connect, $queryTotalDitolak);
$rowTotalDitolak = mysqli_fetch_assoc($resultTotalDitolak);
$totalDitolak = $rowTotalDitolak['totalDitolak'];

// Query untuk menghitung total izin yang diterima
$queryTotalDiterima = "SELECT COUNT(*) AS totalDiterima FROM pengajuan_izin WHERE id_karyawan = $id_karyawan AND status = 'Diterima'";
$resultTotalDiterima = mysqli_query($connect, $queryTotalDiterima);
$rowTotalDiterima = mysqli_fetch_assoc($resultTotalDiterima);
$totalDiterima = $rowTotalDiterima['totalDiterima'];
?>

<!DOCTYPE html>
<html lang="en">
<style>
    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-3px);
        }
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
            /* Geser dari bawah */
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-in-out;
        /* Durasi dan jenis easing */
    }

    .animate-bounce {
        animation: bounce 0.7s infinite;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Dashboard</title>
    <style>

    </style>
</head>

<body class="text-gray-800 font-inter">
    <!-- Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full toggle bg-gray-900 p-4 z-50 sidebar-menu transition-transform" id="sidebar">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="view-image.php?id=<?php echo $_SESSION['id_karyawan']; ?>" alt="User Avatar" class="w-8 h-8 rounded object-cover">
            <span class="text-lg font-bold text-white ml-3 sidebar-text"><?= $_SESSION['nama'] ?></span>
        </a>
        <ul class="mt-4">
            <li class="mb-1">
                <a href="user.php" class="flex items-center py-2 px-4 scale-105 ring-1 ring-gray-800 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-home-2-line mr-3 text-lg sidebar-icon"></i>
                    <span class="text-sm sidebar-text">Home</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="pengajuan.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-inbox-line mr-3 text-lg sidebar-icon"></i>
                    <span class="text-sm sidebar-text">Pengajuan</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="riwayat.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-chat-history-line mr-3 text-lg sidebar-icon"></i>
                    <span class="text-sm sidebar-text">Riwayat Pengajuan</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="user-settings.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-settings-2-line mr-3 text-lg sidebar-icon"></i>
                    <span class="text-sm sidebar-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 sidebar-overlay md:hidden"></div>

    <!-- Main Content -->
    <main class="flex-1 w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50  min-h-screen transition-all main pb-16">
        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">
            <button type="button" class="sidebar-toggle text-lg text-gray-600">
                <i class="ri-menu-line"></i>
            </button>
            <div id="breadcrumb" class="flex items-center text-sm ml-4">
                <span id="breadcrumb-item" class="text-gray-400">Home</span>
            </div>
            <ul class="ml-auto flex items-center">
                <li class="mr-1 dropdown">
                    <button type="button" id="DropdownToggle" class="flex items-center">
                        <img src="view-image.php?id=<?php echo $_SESSION['id_karyawan']; ?>" class="profile-img w-8 h-8 rounded object-cover" alt="Profile Picture">
                    </button>
                    <ul id="submenu" class="absolute shadow-md hidden py-1.5 right-5 rounded-md bg-white border border-gray-100 w-full max-w-[120px]">
                        <li><a href="user-settings.php" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a></li>
                        <li><a href="logout.php" onclick="confirmLogout();return false;" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="p-6">
            <div class="bg-gray-900 rounded-md items-center h-[230px]">
                <div class="flex flex-col animate-fade-in">
                    <h1 class="text-white text-4xl p-6 mt-10 font-extrabold mb-0 xs:p-3 md:mt-6 xs:mt-4 xs:ml-3 xs:text-3xl">
                        Selamat Datang <?= $_SESSION['nama'] ?> !
                    </h1>
                    <p class="text-white text-lg ml-6 xs:text-sm">
                        Anda dapat melakukan pengajuan secara online
                    </p>
                </div>
            </div>
        </div>

        <div class="p-6 flex flex-col space-y-2">
            <!-- Box untuk Total Products -->
            <div class="h-auto w-full">
                <div class="grid gap-4 lg:gap-8 md:grid-cols-3 sm:grid-cols-1 p-3 pt-2">

                    <!-- Box untuk Total Pengajuan 1 -->
                    <div class="relative p-6 rounded-lg bg-white shadow">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">
                                <span>Total Pengajuan</span>
                            </div>
                            <div class="text-3xl">
                                <?= $totalIzin ?>
                            </div>
                        </div>
                    </div>

                    <!-- Box untuk Total Pengajuan 2 -->
                    <div class="relative p-6 rounded-lg bg-white shadow">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">
                                <span>Total Diterima</span>
                                <!-- Ikon Persetujuan -->
                                <svg class="w-6 h-6 text-green-500 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="text-3xl">
                                <?= $totalDiterima?>
                            </div>
                        </div>
                    </div>

                    <!-- Box untuk Total Pengajuan 3 -->
                    <div class="relative p-6 rounded-lg mr-3 bg-white shadow">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">
                                <span>Total Ditolak</span>
                                <!-- Ikon Penolakan -->
                                <svg class="w-6 h-6 text-red-500 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="text-3xl">
                                <?= $totalDitolak ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Box untuk Data Pribadi -->
            <div class="bg-white rounded-lg border border-gray-100  p-6 ml-3 lg:w-[40%] shadow-md shadow-black/5">
                <div class="flex mb-4">
                    <!-- Profile Section -->
                    <div class="flex-shrink-0 flex flex-col items-center mb-6">
                        <img src="view-image.php?id=<?php echo $_SESSION['id_karyawan']; ?>" class="animate-fade-in profile-img  h-[8rem] w-[8rem] lg:h-[11rem] lg:w-[11rem]" alt="Profile Picture">
                    </div>

                    <!-- User Detail Section -->
                    <div class="flex flex-col ml-4 animate-fade-in "> <!-- Tambahkan margin kiri untuk jarak -->
                        <h4 class="font-bold text-lg mb-2">Profil Pribadi</h4>
                        <!-- Garis bawah setelah judul -->
                        <hr class="border-gray-300 mb-2">
                        <div class="text-sm text-gray-700 mb-1"><strong>Nama Lengkap: </strong><?= $_SESSION['nama'] ?></div>
                        <div class="text-sm text-gray-700 mb-1"><strong>Email Address: </strong><?= $_SESSION['email'] ?></div>
                        <div class="text-sm text-gray-700 mb-1"><strong>Departemen: </strong><?= $_SESSION['departemen'] ?></div>
                    </div>
                </div>
            </div>
            </div>




    </main>
    <footer class="bg-white">
        <hr class="border-gray-300"> <!-- Garis bawah -->
        <div class="w-full mx-auto max-w-screen-xl p-4 text-center">
            <!-- Copyright Section -->
            <span class="text-sm text-gray-500 dark:text-gray-400">
                © 2023 <a href="#" class="hover:underline">PBL-114™</a>. All Rights Reserved.
            </span>
        </div>
    </footer>



    <script src="../script.js" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
</body>

</html>