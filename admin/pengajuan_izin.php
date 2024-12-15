<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Sesi Telah Habis Silahkan Login Kembali');window.location='../';</script>";
    exit;
}
$id = $_SESSION['id_admin'];

$limit = 5;  
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit;  

$total_query = "SELECT COUNT(*) FROM pengajuan_izin p 
                JOIN karyawan k ON p.id_karyawan = k.id_karyawan 
                JOIN jenis_izin j ON p.id_jenis = j.id_jenis";
$total_result = mysqli_query($connect, $total_query);
$total_records = mysqli_fetch_row($total_result)[0];
$total_pages = ceil($total_records / $limit);

$queryAdmin = mysqli_query($connect, "SELECT id_departemen FROM admin WHERE id_admin = $id");
$rowAdmin = mysqli_fetch_assoc($queryAdmin);
$id_departemen_admin = $rowAdmin['id_departemen'];


$query = "SELECT * FROM pengajuan_izin p 
          JOIN karyawan k ON p.id_karyawan = k.id_karyawan 
          JOIN jenis_izin j ON p.id_jenis = j.id_jenis WHERE k.id_departemen = '$id_departemen_admin'
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($connect, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['id_pengajuan'])) {
        $id_pengajuan = $_POST['id_pengajuan'];

        if (isset($_POST['terima'])) {
            $status = 'Diterima';
        } elseif (isset($_POST['tolak'])) {
            $status = 'Ditolak';
        }
        $query2 = "UPDATE pengajuan_izin SET status = '$status' WHERE id_pengajuan = $id_pengajuan";

        if (mysqli_query($connect, $query2)) {
            echo "<script>
                alert('Pengajuan Telah $status'); window.location='pengajuan_izin.php';
                </script>";
        } else {
            echo "Terjadi kesalahan saat memperbarui status.";
        }


        mysqli_close($connect);
    }
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

    </style>
</head>

<body class="text-gray-800 font-inter">
    <!-- start: Sidebar -->
    <!-- Start: Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full toggle bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="view-image.php?id=<?php echo $id ?>" alt="" class="w-8 h-8 rounded object-cover">
            <span class="text-lg font-bold text-white ml-3"><?= $_SESSION['namaAdmin'] ?></span>
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
                        <a href="jenis_izin.php"class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Data Izin</a>
                    </li>
                    <li class="mb-4">
                        <a href="departemen.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Departemen</a>
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
                <span id="breadcrumb-item" class="text-gray-400">Pengajuan</span>
            </div>
            <ul class="ml-auto flex items-center">
                <li class="mr-1 dropdown">
                    <button type="button" id="DropdownToggle" class="dropdown-toggle flex items-center">
                        <img src="view-image.php?id=<?php echo $id ?>" alt="" class="w-8 h-8 rounded block object-cover align-middle">
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
                                $no = 1;
                                while ($user = mysqli_fetch_assoc($result)): ?>
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
                                            <?php if (!empty($user['lampiran'])): ?>
                                                <a href="download-lampiran.php?id=<?= $user['id_pengajuan'] ?>" class="flex items-center text-blue-500 hover:text-blue-700">
                                                    <i class="ri-file-pdf-2-line text-gray-800 text-lg mr-2"></i>
                                                    <?= $user['filename'] ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-500 italic">Tidak ada lampiran</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <?php
                                            // Tentukan warna berdasarkan status
                                            $status = $user['status'];
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
                                        <button class="openModal text-sm bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-4 rounded" data-id="modal-<?php echo $user['id_pengajuan']; ?>">
                                                Action
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Modal Approve -->
                                    <div id="modal-<?php echo $user['id_pengajuan']; ?>" class="modal fixed inset-0 z-50 hidden">
                                        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
                                            <div class="modalContent relative w-full max-w-[50rem] h-full max-h-[35rem] transform opacity-0 translate-y-[-100%] bg-gray-100 rounded-xl shadow-2xl transition-all duration-500 ease-out">
                                                <div class="rounded-t bg-white mb-0 px-6 py-6">
                                                    <h6 class="text-blueGray-700 text-xl font-bold"><?php echo $user['nama']; ?></h6>
                                                    <p class="text-blueGray-500 text-sm mt-2">Tanggal Pengajuan: <?php echo $user['tanggal_pengajuan']; ?></p>
                                                    <button class="closeModal absolute top-4 right-4 bg-gray-800 text-white active:bg-gray-900 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                                X    
                                                </button>
                                                </div>
                                                <div class="flex-auto px-4 lg:px-6 py-8 pt-0 overflow-y-auto max-h-[30rem]">
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        <!-- Tanggal Izin Section -->
                                                        <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Tanggal Izin</h6>
                                                        <div class="flex flex-wrap">
                                                            <div class="w-full lg:w-6/12 px-4">
                                                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Tanggal Izin Mulai</label>
                                                                <input type="date"  value="<?= $user['tanggal_izin_mulai'] ?>" disabled class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" required>
                                                            </div>
                                                            <div class="w-full lg:w-6/12 px-4">
                                                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Tanggal Izin Berakhir</label>
                                                                <input type="date" value="<?= $user['tanggal_izin_selesai'] ?>" disabled class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" required>
                                                            </div>
                                                        </div>

                                                        <!-- Jenis Izin Section with Select Box -->
                                                        <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Jenis Izin</h6>
                                                        <div class="w-full lg:w-12/12 px-4">
                                                            <input disabled value="<?= $user['jenis_izin']?>" class="border-2 border-gray-300 px-3 py-3 text-blueGray-600 appearance-none bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" required>
                                                        </div>

                                                        <!-- Alasan Section -->
                                                        <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Alasan</h6>
                                                        <div class="w-full lg:w-12/12 px-4">
                                                            <input name="reason" value="<?= $user['alasan']?>" disabled class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" rows="4">
                                                        </div>
                                                            <input type="text" name="id_pengajuan" hidden value="<?=$user['id_pengajuan']?>">
                                                        <!-- Submit Button -->
                                                        <div class="flex justify-start ml-4 mt-6">
                                                            <button type="submit" name="terima" class="bg-gray-800 text-white font-bold uppercase px-6 py-3 rounded shadow hover:shadow-md ease-linear transition-all duration-150">Terima</button>
                                                            <button type="submit" name="tolak" class="bg-white ml-4 ring-2 ring-gray-800 text-gray-800 font-bold uppercase px-6 py-3 rounded shadow hover:shadow-md ease-linear transition-all duration-150">Tolak</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </tbody>

                        </table>
                        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                            <span class="text-xs xs:text-sm text-gray-900">
                                Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $limit, $total_records); ?> of <?php echo $total_records; ?> Entries
                            </span>
                            <div class="inline-flex mt-2 xs:mt-0">
                                <!-- Previous Page Button -->
                                <a href="?page=<?php echo max($page - 1, 1); ?>" class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                                    Prev
                                </a>
                                <!-- Next Page Button -->
                                <a href="?page=<?php echo min($page + 1, $total_pages); ?>" class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
        </div>
        <!-- Modal -->



    </main>
    <!-- end: Main -->

    <script src="../script.js" defer></script>
    <script src="script.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
</body>

</html>