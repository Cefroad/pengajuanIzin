<?php
session_start();
include "koneksi.php";
$id = $_SESSION['id_admin'];
// Ambil data karyawan dan departemen
$result = mysqli_query($connect, "SELECT k.*, d.nama_departemen FROM karyawan k JOIN departemen d ON k.id_departemen = d.id_departemen WHERE status_akun = 'aktif'");
$row = mysqli_num_rows($result);

// Query untuk Karyawan
$query_karyawan = "SELECT k.id_karyawan, k.nama, d.nama_departemen, k.created_at
                   FROM karyawan k
                   JOIN departemen d ON k.id_departemen = d.id_departemen
                   WHERE k.status_akun = 'nonaktif'";

// Query untuk Admin
$query_admin = "SELECT a.id_admin, a.nama, NULL AS nama_departemen, a.created_at
                FROM admin a
                WHERE a.status_akun = 'nonaktif'";


if (isset($_POST['activate'])) {
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type']; // 'karyawan' atau 'admin'

    if ($user_type == 'karyawan') {
        $update_query = "UPDATE karyawan SET status_akun = 'aktif' , remaining_izin = '20' , max_izin = '20' WHERE id_karyawan = ?";
    } else {
        $update_query = "UPDATE admin SET status_akun = 'aktif' WHERE id_admin = ?";
    }

    if ($stmt = mysqli_prepare($connect, $update_query)) {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<script>alert('Akun Berhasil Di aktifkan');window.location = 'karyawan.php';</script>;";
    }
}

// Proses hapus data
if (isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type']; // 'karyawan' atau 'admin'

    if ($user_type == 'karyawan') {
        $delete_query = "DELETE FROM karyawan WHERE id_karyawan = ?";
    } else {
        $delete_query = "DELETE FROM admin WHERE id_admin = ?";
    }

    if ($stmt = mysqli_prepare($connect, $delete_query)) {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
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
    <title>Document</title>
    <style>
        /* Import animate.css library for animations */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

        .buttonCek {
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .buttonCek:hover {
            transform: scale(1.1);
            /* Scale up when hover */
            opacity: 0.8;
            /* Fade effect */
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body class="font-inter">
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
                        <a href="jenis_izin.php" class="text-gray-300 text-sm flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3">Data Izin</a>
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
    <main class="flex-1 w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
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
        <!-- karyawan.php -->
        <!-- Card -->
        <div class="container mx-auto px-4 sm:px-8">
            <div class="py-8">
                <div>
                    <h2 class="text-2xl font-semibold leading-tight">Users</h2>
                </div>
                <!-- Filters Section -->
                <div class="my-2 flex sm:flex-row flex-col items-center space-x-2">
                    <div class="relative flex items-center w-full sm:w-auto">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                                <path d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"></path>
                            </svg>
                        </span>
                        <input placeholder="Search"
                            class="appearance-none rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                    </div>
                    <button id="openModalBtn" class="bg-gray-800 text-white font-bold p-2 rounded shadow hover:shadow-md ease-linear transition-all duration-150 sm:ml-2 mt-2 sm:mt-0">
                        Permintaan Pendaftaran
                    </button>
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
                                        Departemen
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created at
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1; // Initialize counter variable
                                while ($user = mysqli_fetch_assoc($result)) {
                                    $image_data = base64_encode($user['profile_picture']);
                                    $image_type = $user['image_type'];
                                    $image_src = "data:$image_type;base64,$image_data";
                                ?>
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
                                                    <img class="w-8 h-8 rounded object-cover" src="<?php echo $image_src; ?>" alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        <?php echo htmlspecialchars($user['nama']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <?php echo $user['nama_departemen']; ?>
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <?php echo $user['created_at']; ?>
                                            </p>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                            <span class="text-xs xs:text-sm text-gray-900">
                                Showing 1 to <?php echo $row; ?> of <?php echo $row; ?> Entries
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

        <!-- Modal dan Tabel Data -->
        <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden opacity-0">
            <div class="relative flex flex-col w-11/12 sm:w-8/12 md:w-6/12 bg-white shadow-md rounded-lg fade-in">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-700">Permintaan Pendaftaran</h3>
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-800 font-bold text-lg">&times;</button>
                </div>

                <!-- Tabel Karyawan -->
                <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white">
                    <h4 class="text-lg font-semibold text-gray-700 p-4">Karyawan</h4>
                    <table class="w-full text-left table-auto min-w-max">
                        <thead>
                            <tr>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">Name</th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">Departemen</th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">Created At</th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result_karyawan = mysqli_query($connect, "SELECT k.id_karyawan, k.nama, d.nama_departemen, k.created_at FROM karyawan k JOIN departemen d ON k.id_departemen = d.id_departemen WHERE k.status_akun = 'nonaktif'");
                            while ($row_karyawan = mysqli_fetch_assoc($result_karyawan)): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="p-4 border-b border-slate-200"><?php echo $row_karyawan['nama']; ?></td>
                                    <td class="p-4 border-b border-slate-200"><?php echo $row_karyawan['nama_departemen']; ?></td>
                                    <td class="p-4 border-b border-slate-200"><?php echo date('d/m/Y', strtotime($row_karyawan['created_at'])); ?></td>
                                    <td class="p-4 border-b border-slate-200">
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $row_karyawan['id_karyawan']; ?>">
                                            <input type="hidden" name="user_type" value="karyawan">
                                            <button type="submit" name="activate" class="text-green-600 buttonCek hover:text-green-800">
                                                <i class="ri-check-line text-lg"></i>
                                            </button>
                                        </form>
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $row_karyawan['id_karyawan']; ?>">
                                            <input type="hidden" name="user_type" value="karyawan">
                                            <button type="submit" name="delete" class="text-red-600 buttonCek hover:text-red-800">
                                                <i class="ri-delete-bin-2-line text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Admin -->
                <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white mt-6">
                    <h4 class="text-lg font-semibold text-gray-700 p-4">Admin</h4>
                    <table class="w-full text-left table-auto min-w-max">
                        <thead>
                            <tr>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">Name</th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">Created At</th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result_admin = mysqli_query($connect, "SELECT a.id_admin, a.nama, a.created_at FROM admin a WHERE a.status_akun = 'nonaktif'");
                            while ($row_admin = mysqli_fetch_assoc($result_admin)): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="p-4 border-b border-slate-200"><?php echo $row_admin['nama']; ?></td>
                                    <td class="p-4 border-b border-slate-200"><?php echo date('d/m/Y', strtotime($row_admin['created_at'])); ?></td>
                                    <td class="p-4 border-b border-slate-200">
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $row_admin['id_admin']; ?>">
                                            <input type="hidden" name="user_type" value="admin">
                                            <button type="submit" name="activate" class="text-green-600 buttonCek hover:text-green-800">
                                                <i class="ri-check-line text-lg"></i>
                                            </button>
                                        </form>
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $row_admin['id_admin']; ?>">
                                            <input type="hidden" name="user_type" value="admin">
                                            <button type="submit" name="delete" class="text-red-600 buttonCek hover:text-red-800">
                                                <i class="ri-delete-bin-2-line text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-200">
                    <button id="closeModalBtnFooter" class="bg-gray-500 text-white font-bold p-2 rounded hover:shadow-md">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                    © 2023 <a href="#" class="hover:underline">PBL-114™</a>. All Rights Reserved.
                </span>
            </div>
        </footer>

        <script src="../script.js"></script>
        <script>
            const modal = document.getElementById('modal');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtns = document.querySelectorAll('#closeModalBtn, #closeModalBtnFooter');

            openModalBtn.addEventListener('click', () => {
                modal.classList.remove('hidden', 'opacity-0');
                modal.classList.add('fade-in');
            });

            closeModalBtns.forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            });
        </script>

        <script src="https://unpkg.com/@popperjs/core@2"></script>
</body>

</html>