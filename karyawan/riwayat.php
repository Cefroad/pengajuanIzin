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
    $profile_image = 'data:' . $row['image_type'] . ';base64,' . base64_encode($row['profile_picture']);
} else {
    $profile_image = 'https://placehold.co/32x32';
}

$limit = 5;

// Dapatkan halaman saat ini (default halaman 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;  

$queryCount = "SELECT COUNT(*) AS total FROM pengajuan_izin p JOIN karyawan k ON p.id_karyawan = k.id_karyawan JOIN jenis_izin j ON p.id_jenis = j.id_jenis WHERE k.id_karyawan = $id_karyawan";
$resultCount = mysqli_query($connect, $queryCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalData = $rowCount['total'];  

$totalPages = ceil($totalData / $limit);
$statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '';

$query1 = "SELECT * FROM pengajuan_izin p 
          JOIN karyawan k ON p.id_karyawan = k.id_karyawan 
          JOIN jenis_izin j ON p.id_jenis = j.id_jenis 
          WHERE k.id_karyawan = $id_karyawan";

// Tambahkan filter status jika ada
if (!empty($statusFilter)) {
    $query1 .= " AND p.status = '$statusFilter'";
}
$query1 .= " LIMIT $limit OFFSET $offset";

$result = mysqli_query($connect, $query1);

// Variabel untuk rentang data
$start = $offset + 1;
$end = min($offset + $limit, $totalData);
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
                <!-- Filter Status -->
                <div class="my-2 flex sm:flex-row flex-col">
                    <div class="flex flex-row mb-1 sm:mb-0">
                        <form method="GET" action="">
                            <label for="statusFilter" class="mr-2">Filter Status:</label>
                            <select name="statusFilter" id="statusFilter" class="border px-4 py-2 rounded-lg text-sm">
                                <option value="">Semua Status</option>
                                <option value="Sedang Menunggu" <?= isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Sedang Menunggu' ? 'selected' : '' ?>>Sedang Menunggu</option>
                                <option value="Disetujui" <?= isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                <option value="Ditolak" <?= isset($_GET['statusFilter']) && $_GET['statusFilter'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                            <button type="submit" class="ml-2 bg-gray-800 text-white px-4 py-2 rounded-lg">Terapkan</button>
                        </form>
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
                                <?php
                                $no = $start;

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap"><?= $no++ ?></p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap"><?= $row['tanggal_pengajuan'] ?></p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap"><?= $row['jenis_izin'] ?></p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <?php if (!empty($row['lampiran'])): ?>
                                                <a href="download-lampiran.php?id=<?= $row['id_pengajuan'] ?>" class="flex items-center text-blue-500 hover:text-blue-700">
                                                    <i class="ri-file-pdf-2-line text-gray-800 text-lg mr-2"></i>
                                                    <?= $row['filename'] ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-500 italic">Tidak ada lampiran</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <?php
                                            // Tentukan warna berdasarkan status
                                            $status = $row['status'];
                                            if ($status == 'Sedang Menunggu') {
                                                $bgColor = 'bg-orange-500'; // Warna oranye untuk menunggu
                                            } elseif ($status == 'Ditolak') {
                                                $bgColor = 'bg-red-500'; // Warna merah untuk ditolak
                                            } elseif ($status == 'Diterima') {
                                                $bgColor = 'bg-green-500'; // Warna hijau untuk disetujui
                                            } else {
                                                $bgColor = 'bg-gray-500'; // Default jika status tidak terdeteksi
                                            }
                                            ?>
                                            <p class="text-white <?php echo $bgColor; ?> rounded-full px-3 py-1 text-center inline-block"><?php echo $status; ?></p>
                                        </td>

                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <button class="text-sm bg-white border border-gray-800 hover:bg-gray-700 hover:text-white text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>

                        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                            <span class="text-xs xs:text-sm text-gray-900">
                                Showing <?= $start ?> to <?= $end ?> of <?= $totalData ?> Entries
                            </span>
                            <div class="inline-flex mt-2 xs:mt-0">
                                <!-- Previous Button -->
                                <a href="?page=<?= max($page - 1, 1) ?>&statusFilter=<?= urlencode($statusFilter) ?>" class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l <?= $page <= 1 ? 'cursor-not-allowed' : '' ?>" <?= $page <= 1 ? 'disabled' : '' ?>>
                                    Prev
                                </a>
                                <!-- Next Button -->
                                <a href="?page=<?= min($page + 1, $totalPages) ?>&statusFilter=<?= urlencode($statusFilter) ?>" class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r <?= $page >= $totalPages ? 'cursor-not-allowed' : '' ?>" <?= $page >= $totalPages ? 'disabled' : '' ?>>
                                    Next
                                </a>
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