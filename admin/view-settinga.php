<?php
session_start();
include "koneksi.php";
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Document</title>
</head>
<style>
    .custom-card{
        width:900px;
    }
</style>
<body class="text-gray-800 font-inter">
    <!-- start: Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full toggle bg-gray-900 p-4 z-50 sidebar-menu transition-transform md:block ">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="../img/32x32.svg" alt="" class="w-8 h-8 rounded object-cover">
            <span class="text-lg font-bold text-white ml-3"><?=$_SESSION['namaAdmin']?></span>
        </a>
        <ul class="mt-4">
            <li class="mb-1 group">
                <a href="admin-panel.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-home-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Recently</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="#" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle">
                    <i class="ri-inbox-archive-line mr-3 text-lg"></i>
                    <span class="text-sm">Manage Data</span>
                    <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
                </a>
                <ul class="pl-7 mt-2 hidden group-[.selected]:block">
                    <li class="mb-4">
                        <a href="karyawan.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Karyawan</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Data Izin</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Departemen</a>
                    </li>
                </ul>
            </li>
            <!-- <li class="mb-1 group">
                <a href="karyawan.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-user-line mr-3 text-lg"></i>
                    <span class="text-sm">Karyawan</span>
                </a>
            </li> -->
            <li class="mb-1 group">
                <a href="pengajuan_izin.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-inbox-line mr-3 text-lg"></i>
                    <span class="text-sm">Pengajuan</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="view-setting.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-settings-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Settings</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 sidebar-overlay md:hidden"></div>
    <!-- end: Sidebar -->

    <!-- start: Main -->
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">
            <button type="button" class="sidebar-toggle text-lg text-gray-600">
                <i class="ri-menu-line"></i>
            </button>
            <div id="breadcrumb" class="flex items-center text-sm ml-4">
                <span class="text-gray-400">Dashboard &nbsp;</span>
                <span class="text-gray-400 mx-2"> / &nbsp; </span>
                <span id="breadcrumb-item" class="text-gray-400">Setting</span>
            </div>
            <ul class="ml-auto flex items-center">
                <li class="mr-1 dropdown">
                    <button type="button" id="DropdownToggle" class="dropdown-toggle flex items-center">
                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                    </button>
                    <ul id="submenu" class="absolute shadow-md hidden py-1.5 right-5 rounded-md bg-white border border-gray-100 w-full max-w-[120px]">
                        <li>
                            <a href="#" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Setting</a>
                        </li>
                        <li>
                        <a href="logout.php" onclick="confirmLogout();return false;" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="p-6">
    <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md flex">
        <div class="flex flex-col items-center">
            <img src="https://placehold.co/180x180" class="object-cover" alt="">
            <div class="pt-2 text-lg font-bold text-center"><?=$_SESSION['namaAdmin']?></div>
        </div>
        
        <div class="flex justify-between pl-6 space-x-6">
    <!-- Card Kiri -->
    <div class="bg-white border border-gray-200 custom-card rounded-md p-4">
        <h4 class="font-bold text-lg">User Detail</h4>
        <div class="font-bold pt-4 text-base">Email Address</div>
        <div class="text-sm text-blue-600"><?=$_SESSION['email']?></div>
        
        <!-- Menambahkan zona waktu -->
        <div class="font-bold pt-4 text-base">Timezone</div>
        <div class="text-sm text-gray-600"><?=date_default_timezone_get();?></div>
        
        <div class="pt-4">
            <a href="edit_profil.php" class="text-blue-600 text-sm hover:underline">Edit Profil</a>
        </div>
    </div>

    <!-- Card Kanan -->
    <div class="bg-white border border-gray-200 w-full max-w-xs rounded-md p-4">
        <h4 class="font-bold text-lg">Settings</h4>
        
        <div class="pt-4">
            <a href="logout.php" class="text-red-600 text-sm hover:underline">Logout</a>
        </div>
    </div>
</div>


    </div>
</div>






        </div>
    </main>
    <!-- end: Main -->

    <script src="../script.js" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
</body>
</html>





<!-- <div class="p-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
        <div class="flex justify-between mb-4 items-start">
        
        <div class="overflow-x-auto">

        </div>
    </div>
        </div> -->