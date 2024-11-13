<?php
session_start();
include "koneksi.php";

$result = mysqli_query($connect, "SELECT * FROM karyawan");
$row = mysqli_num_rows($result);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body class="font-inter">
    <!-- Start: Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full toggle bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover">
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
                <a href="karyawan.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-user-line mr-3 text-lg"></i>
                    <span class="text-sm">Karyawan</span>
                </a>
            </li>
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
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
    <!-- End: Sidebar -->
    
    <!-- Start: Main -->
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">
            <button type="button" class="sidebar-toggle text-lg text-gray-600">
                <i class="ri-menu-line"></i>
            </button>
            <div id="breadcrumb" class="flex items-center text-sm ml-4">
                <span class="text-gray-400">Dashboard &nbsp;</span>
                <span class="text-gray-400 mx-2"> / &nbsp; </span>
                <span id="breadcrumb-item" class="text-gray-400">Karyawan</span>
            </div>
            <ul class="ml-auto flex items-center">
                <li class="mr-1 dropdown">
                    <button type="button" id="DropdownToggle" class="dropdown-toggle flex items-center">
                        <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded block object-cover align-middle">
                    </button>
                    <ul id="submenu" class="absolute shadow-md hidden py-1.5 right-5 rounded-md bg-white border border-gray-100 w-full max-w-[120px]">
                        <li>
                            <a href="" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Setting</a>
                        </li>
                        <li>
                        <a href="logout.php" onclick="confirmLogout();return false;" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    <!-- karyawan.php -->
<div class="p-6">
<div class="my-2 flex justify-end ">
    <a href="" class="p-2 bg-cyan-500  text-white text-sm rounded-md hover:bg-cyan-600 ">
        <i class="ri-add-line  font-inter">  </i>
        Create
    </a>
</div>

<!-- Card -->
<div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
        <div class="flex justify-between mb-4 items-start">
            <div class="font-medium">Data Karyawan</div>
        </div>
        <form action="karyawan.php" method="get" class="flex items-center mb-4">
                        <div class="relative w-full mr-2">
                            <input type="text" name="cari" class="py-2 pr-4 pl-10 bg-gray-50 w-full outline-none border border-gray-100 rounded-md text-sm focus:border-blue-500" placeholder="Search...">
                            <i class="ri-search-line absolute top-1/2 left-4 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </form>
        
        <div class="overflow-x-auto">
            <table class="w-full min-w-[540px]">
                <thead>
                    <tr>
                        <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">Nama</th>
                        <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Email</th>
                        <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Status</th>
                        <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php 
                     if(isset($_GET['cari'])) {
                        $cari = mysqli_real_escape_string($connect, $_GET['cari']);
                        $result = mysqli_query($connect, "SELECT * FROM karyawan WHERE nama LIKE '%$cari%'");
                    } else {
                        $result = mysqli_query($connect, "SELECT * FROM karyawan");
                    }
                        $no = 1;
                        while($data = mysqli_fetch_assoc($result)){ ?>
                        <td class="py-2 px-4 border-b border-b-gray-50">
                            <div class="flex items-center">
                                <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover block">
                                <span href="#" class="text-gray-600 text-sm font-medium ml-2"><?=$data['nama']?></span>
                            </div>
                        </td>
                        <td class="py-2 px-4 border-b border-b-gray-50">
                            <span class="text-[13px] font-medium text-gray-400"><?=$data['email']?></span>
                        </td>
                        <td class="py-2 px-4 border-b border-b-gray-50">
                            <span class="text-[13px] font-medium text-gray-400"><?=$data['status']?></span>
                        </td>
                        <td class="py-2 px-4 border-b border-b-gray-50">
    <div class="flex flex-col sm:flex-row sm:items-center">
        <a href="" class="p-2 text-sm bg-blue-700 text-white rounded-md hover:bg-blue-800 hover:outline hover:outline-1 hover:outline-offset-2 hover:outline-blue-700 transition-all duration-100">
            Edit <i class="ri-edit-box-line" style="color:#FFFFFF;"></i>
        </a>
        <a href="" class="mt-2 sm:mt-0 sm:ml-2 text-white text-sm bg-red-700 rounded-md hover:bg-red-800 hover:outline hover:outline-1 hover:outline-offset-2 hover:outline-red-700 p-2 transition-all duration-100">
            Delete <i class="ri-delete-bin-7-fill" style="color:#FFFFFF;"></i>
        </a>
    </div>
</td>
                        <?php
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<!-- Card -->


    
</div>
<script src="../script.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
</body>
</html>