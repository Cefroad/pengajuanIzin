<?php
session_start();
include 'koneksi.php';
$id_karyawan = $_SESSION['id_karyawan'];

// Query untuk mendapatkan gambar profil
$query = "SELECT * FROM karyawan k JOIN departemen d ON k.id_departemen = d.id_departemen WHERE id_karyawan = '$id_karyawan'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

// Tentukan gambar profil yang akan ditampilkan
if ($row['profile_picture']) {
    // Jika gambar profil ada, tampilkan gambar dari database
    $profile_image = 'data:' . $row['image_type'] . ';base64,' . base64_encode($row['profile_picture']);
} else {
    // Jika tidak ada gambar profil, gunakan gambar placeholder
    $profile_image = 'https://placehold.co/32x32';
}
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
        @media (max-width: 768px) {

            /* Aturan untuk ukuran layar kecil */
            .table-responsive {
                overflow-x: auto;
                display: block;
            }
        }
    </style>
</head>

<body class="text-gray-800 font-inter flex flex-col min-h-screen">
    <!-- Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="<?= $profile_image ?>" alt="User  Avatar" class="w-8 h-8 rounded object-cover">
            <span class="text-lg font-bold text-white ml-3"><?= $_SESSION['nama'] ?></span>
        </a>
        <ul class="mt-4">
            <li class="mb-1">
                <a href="user.php" class="flex items-center py-2 px-4  text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-home-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Home</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="pengajuan.php" class="flex items-center py-2 px-4 text-gray-300  hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-inbox-line mr-3 text-lg"></i>
                    <span class="text-sm">Pengajuan</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="riwayat.php" class="flex items-center py-2 px-4 scale-105 ring-1 ring-gray-800 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-chat-history-line mr-3 text-lg"></i>
                    <span class="text-sm">Riwayat Pengajuan</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="user-settings.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-settings-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Settings</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 sidebar-overlay md:hidden"></div>
    <!-- Main Content -->
    <main class="flex-1 w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main pb-16">
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
        <!-- table riwayat -->
        <!-- Container yang membungkus tabel dengan overflow-x-auto -->
        <div class="container mx-auto px-4 sm:px-8">
            <div class="py-8">
                <div>
                    <h2 class="text-2xl font-semibold leading-tight">Pengajuan Izin</h2>
                </div>

                <!-- Filters Section -->
                <div class="my-2 flex sm:flex-row flex-col">
                    <div class="flex flex-row mb-1 sm:mb-0">
                        <!-- Buat filter-->
                    </div>
                    <div class="block relative">
                        <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                                <path d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"></path>
                            </svg>
                        </span>
                        <input placeholder="Search"
                            class="  appearance-none rounded-l-xl rounded-r-xl border border-gray-400 block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                    </div>
                </div>

                <!-- Table Section -->
                <div class="overflow-x-auto -mx-4 sm:-mx-8 px-4 sm:px-8 py-4">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal table-fixed">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Jenis Izin
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-1/4">
                                        Lampiran
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-1/6">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">1</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">2024-12-07</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">Sakit</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="path-to-lampiran/lampiran.pdf" download class="flex items-center text-blue-500 hover:text-blue-700">
                                            <!-- Ikon PDF -->
                                            <i class="ri-file-pdf-2-line text-gray-800 text-lg mr-2"></i>
                                            <!-- Nama file -->
                                            lampiran.pdf
                                        </a>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-white bg-green-500 rounded-full px-3 py-1 text-center inline-block">Disetujui</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <button class="text-sm bg-white border border-gray-800 hover:bg-gray-700 hover:text-white text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>

                        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                            <span class="text-xs xs:text-sm text-gray-900">
                                Showing 1 to 1 of 1 Entries
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