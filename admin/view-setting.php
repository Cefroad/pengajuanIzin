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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body class="font-inter">
<div class="fixed left-0 top-0 w-64 h-full toggle bg-gray-900 p-4 z-50 sidebar-menu transition-transform md:block ">
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
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 ml-4 bg-gray-50 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">
            <button type="button" class="sidebar-toggle text-lg text-gray-600">
                <i class="ri-menu-line"></i>
            </button>
            <div id="breadcrumb" class="flex items-center text-sm ml-4">
                <span class="text-gray-400">Dashboard &nbsp;</span>
                <span class="text-gray-400 mx-2"> / &nbsp; </span>
                <span id="breadcrumb-item" class="text-gray-400">Home</span>
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

    <div class="grid grid-cols-1 gap-4 px-4 pt-6 xl:grid-cols-1 xl:gap-4  space-x-6">
            <h1 class="text-xl mb-2 font-semibold text-gray-900 sm:text-2xl ">User Settings</h1>
        </div>
        <!-- Full Width Content Area -->
        <div class="col-span-full px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Content Area: General Information -->
                <div class="mb-4">
                    <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <h3 class="mb-4 text-xl font-semibold ">General Information</h3>
                        <div class="space-y-4">
                        <div>
                                <label for="username" class="block text-sm font-medium text-gray-900">Username</label>
                                <input type="text" id="username" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-900">Nama</label>
                                <input type="text" id="name" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                                <input type="email" id="email" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg">
                            </div>
                            <div class="grid  grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <button class="text-white p-2.5 mt-6 bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Save all</button>
                            </div>
                            <div class="">
                                <label for="department" class="block text-sm font-medium text-gray-900">Departement</label>
                                <input type="text" id="department" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                            
                        </div>
                    </div>
                </div>

                <!-- Right Content Area: Profile Picture & Language Settings -->
                <div class="mb-4">
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <div class="sm:flex sm:space-x-4 items-center">
                            <img class="rounded-lg w-28 h-28 sm:mb-0" src="../img/32x32.svg" alt="Jese picture">
                            <div>
                                <h3 class="mb-1 text-xl font-bold text-gray-900">Profile Picture</h3>
                                <div class="mb-4 text-sm text-gray-500">
                                <?=$_SESSION['namaAdmin']?>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:ring-blue-300 ">
                                        <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M0 0h20v20H0z" fill="none"></path></svg> Upload
                                    </button>
                                    <button type="button" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                         Delete
                                     </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 mt-2 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 ">
                        <h3 class="mb-4 text-xl font-semibold ">Language & Timezone</h3>
                        <div class="space-y-4">
                            <!-- Language Selection -->
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-900">Language</label>
                                <select id="language" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg">
                                    <option selected>English</option>
                                </select>
                            </div>
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-900">Timezone</label>
                            <input id="timezone" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg" readonly value="<?= date_default_timezone_get(); ?>">
                        </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Card to Change Password -->
           <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 ">
            <h3 class="mb-4 text-xl font-semibold">Password information</h3>
            <form action="#">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="current-password" class="block mb-2 text-sm font-medium text-gray-900 ">Current password</label>
                        <input type="text" name="current-password" id="current-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="••••••••" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">New password</label>
                        <input data-popover-target="popover-password" data-popover-placement="bottom" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="••••••••" required>
                        <div data-popover id="popover-password" role="tooltip" class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72">
                            <div class="p-3 space-y-2">
                                <p>It’s better to have:</p>
                                <ul>
                                    <li class="flex items-center mb-1">
                                        <svg class="w-4 h-4 mr-2 text-green-400 " aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        Upper & lower case letters
                                    </li>
                                    <li class="flex items-center mb-1">
                                        <svg class="w-4 h-4 mr-2 text-gray-300" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        A symbol (#$&)
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-300" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        A longer password (min. 12 chars.)
                                    </li>
                                </ul>
                        </div>
                        <div data-popper-arrow></div>
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                        <input type="text" name="confirm-password" id="confirm-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="••••••••" required>
                    </div>
                    <div class="col-span-6 sm:col-full">
                        <button class="text-white bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Save all</button>
                    </div>
                </div>

        </div>
    </div>
    <footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
        <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                © 2023 <a href="" class="hover:underline">PBL-114™</a>. All Rights Reserved.
            </span>
        </div>
    </footer>

</body>
<script src="../script.js" defer></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const popover = document.getElementById('popover-password');

    passwordInput.addEventListener('focus', function () {
      popover.classList.remove('invisible');
      popover.classList.add('opacity-100', 'visible');
    });

    passwordInput.addEventListener('blur', function () {
      popover.classList.remove('opacity-100', 'visible');
      popover.classList.add('invisible');
    });
  });
</script>

</html>
