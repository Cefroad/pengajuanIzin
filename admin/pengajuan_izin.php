<?php
session_start();
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
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
    <!-- start: Sidebar -->
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
        <div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Pengajuan Izin</h2>
        </div>
        <!-- Filters Section -->
        <div class="my-2 flex sm:flex-row flex-col">
            <div class="flex flex-row mb-1 sm:mb-0">
            </div>
            <div class="block relative">
                <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                        <path d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"></path>
                    </svg>
                </span>
                <input placeholder="Search"
                    class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
            </div>
        </div>
        <!-- Table Section -->
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Jenis Izin
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Lampiran
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($connect,"SELECT * FROM pengajuan_izin p JOIN karyawan k ON p.id_karyawan = k.id_karyawan JOIN jenis_izin j ON p.id_jenis = j.id_jenis");

                        if ($result) {
                            $no = 1; 
                            while ($user = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    <?php echo $no++; ?> <!-- Display serial number -->
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                <!-- Image from database -->
                                                <img class="w-8 h-8 rounded object-cover" src="view-image.php?id=<?php echo $user['id_karyawan']; ?>" alt="" />
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    <?php echo $user['nama']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            <?php echo $user['tanggal_pengajuan']; ?>
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            <?php echo $user['jenis_izin']; ?>
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="path-to-lampiran/<?php echo $user['lampiran']; ?>" class="text-blue-500">Download</a>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            <?php echo $user['status']; ?>
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <button class="text-sm bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                            Action
                                        </button>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "Error fetching data: " . mysqli_error($connect);
                        }
                        ?>
                    </tbody>
                </table>
                <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                    <span class="text-xs xs:text-sm text-gray-900">
                        Showing 1 to <?php echo mysqli_num_rows($result); ?> of <?php echo mysqli_num_rows($result); ?> Entries
                    </span>
                    <div class="inline-flex mt-2 xs:mt-0">
                        <button class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                            Prev
                        </button>
                        <button class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
                            Next
                        </button>
                    </div>
                </div>
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
