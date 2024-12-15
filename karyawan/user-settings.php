<?php
session_start();
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta'); // Koneksi database

// Pastikan user sudah login
if (!isset($_SESSION['id_karyawan'])) {
    header("Location: login.php");
    exit;
}

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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari form
    $current_password = $_POST['current-password'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Memastikan admin sudah login dan ID admin tersedia di session
    if (!isset($_SESSION['id_karyawan'])) {
        echo "<script>alert('Anda harus login terlebih dahulu!'); window.location='../';</script>";
        exit();
    }

    // Mengambil ID admin dari session
    $karyawan_id = $_SESSION['id_karyawan'];  // ID admin yang login

    // Cek apakah password baru dan konfirmasi password cocok
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Password baru dan konfirmasi password tidak cocok!');</script>";
    } else {
        // Mengambil password lama yang terhash dari database
        $query = "SELECT password FROM karyawan WHERE id_karyawan = '$karyawan_id'";
        $result = mysqli_query($connect, $query);
        
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];

            // Verifikasi password lama
            if (password_verify($current_password, $hashed_password)) {
                // Hash password baru
                $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

                // Update password di database
                $update_query = "UPDATE karyawan SET password = '$hashed_new_password' WHERE id_karyawan = '$karyawan_id'";
                if (mysqli_query($connect, $update_query)) {
                    echo "<script>alert('Password berhasil diperbarui!'); window.location='user-settings.php';</script>";
                } else {
                    echo "<script>alert('Gagal memperbarui password!');</script>";
                }
            } else {
                echo "<script>alert('Password lama salah!');</script>";
            }
        } else {
            echo "<script>alert('Error saat mengambil data password lama.');</script>";
        }
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
    <title>Settings</title>
    <style>
        /* Tambahkan gaya khusus jika diperlukan */
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
                <a href="pengajuan.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-inbox-line mr-3 text-lg"></i>
                    <span class="text-sm">Pengajuan</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="riwayat.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-chat-history-line mr-3 text-lg"></i>
                    <span class="text-sm">Riwayat Pengajuan</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="user-settings.php" class="flex items-center py-2 px-4 scale-105 ring-1 ring-gray-800 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-settings-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Settings</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 sidebar-overlay md:hidden"></div>

    <!-- Main Content -->
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
                        <img src="<?= $profile_image ?>" alt="" class="w-8 h-8 rounded block object-cover align-middle">
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

        <div class="grid grid-cols-1 gap-4 px-4 pt-6 xl:grid-cols-1 xl:gap-4 space-x-6">
            <h1 class="text-xl mb-2 font-semibold text-gray-900 sm:text-2xl ">User Settings</h1>
        </div>

        <!-- Full Width Content Area -->
        <div class="col-span-full px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Content Area: General Information -->
                <div class="mb-4">
                    <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <h3 class="mb-4 text-xl font-semibold ">General Information</h3>
                        <form action="update_user_info.php" method="POST">
                            <div class="space-y-4">
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-900">Username</label>
                                    <input type="text" name="username" id="username" value="<?= $row['username'] ?>" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-900">Nama</label>
                                    <input type="text" name="nama" id="name" value="<?= $row['nama'] ?>" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                                    <input type="email" name="email" id="email" value="<?= $row['email'] ?>" class="w-full p-2.5 mt-2 text-sm bg-gray-50 border border-gray-300 rounded-lg">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="col-span-1">
                                        <button class="text-white p-2.5 mt-6 bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Save all</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Content Area: Profile Picture & Language Settings -->
                <div class="mb-4">
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <form action="profile-picture.php" method="POST" enctype="multipart/form-data">
                            <div class="sm:flex sm:space-x-4 items-center">
                                <img class="rounded-lg w-28 h-28 sm:mb-0" src="<?= $profile_image ?>" alt="Profile Picture">
                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-gray-900">Profile Picture</h3>
                                    <div class="mb-4 text-sm text-gray-500">
                                        <?php echo $_SESSION['nama']; ?>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <!-- Input file tersembunyi -->
                                        <input type="file" id="fileInput" name="fileInput" class="hidden" onchange="updateFileName()">

                                        <!-- Label untuk input file (Tombol Upload) -->
                                        <label for="fileInput" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:ring-blue-300 cursor-pointer">
                                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                                <path d="M0 0h20v20H0z" fill="none"></path>
                                            </svg> Upload
                                        </label>

                                        <!-- Menampilkan nama file yang dipilih -->
                                        <span id="fileName" class="ml-2 text-sm text-gray-500">No file chosen</span>

                                        <!-- Tombol Delete -->
                                        <button type="submit" name="delete" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                            Delete
                                        </button>

                                        <!-- Tombol Submit -->
                                        <button type="submit" name="submit" class="py-2 px-3 text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none rounded-lg">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Language & Timezone Settings -->
                    <div class="p-4 mt-2 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <h3 class="mb-4 text-xl font-semibold">Language & Timezone</h3>
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
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2">
                <h3 class="mb-4 text-xl font-semibold">Password information</h3>
                <form action="" method="POST">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <label for="current-password" class="block mb-2 text-sm font-medium text-gray-900">Current password</label>
                            <input type="text" name="current-password" id="current-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="••••••••" required>
                        </div>
                        <div class="col-span-1">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">New password</label>
                            <input name="password" data-popover-target="popover-password" data-popover-placement="bottom" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="••••••••" required>
                        </div>
                        <div class="col-span-1">
                            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
                            <input type="text" name="confirm-password" id="confirm-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="••••••••" required>
                        </div>
                        <div class="col-span-1">
                            <button class="text-white bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Save all</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </main>
    <footer class="bg-white">
        <hr class="border-gray-300">
        <div class="w-full mx-auto max-w-screen-xl p-4 text-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">© 2023 <a href="#" class="hover:underline">PBL-114™</a>. All Rights Reserved.</span>
        </div>
    </footer>
    <script src="../script.js" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script>
        // Fungsi untuk menampilkan nama file setelah file dipilih
        function updateFileName() {
            const fileInput = document.getElementById('fileInput');
            const fileName = document.getElementById('fileName');
            fileName.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'No file chosen';
        }
        document.getElementById('fileInput').addEventListener('change', function(event) {
    var fileName = event.target.files[0] ? event.target.files[0].name : 'No file chosen';
    var maxLength = 20; // Batas maksimum karakter nama file

    // Jika nama file lebih panjang dari maxLength, potong dan tambahkan "..."
    if (fileName.length > maxLength) {
        fileName = fileName.substring(0, maxLength) + '...';
    }

    // Tampilkan nama file yang dipilih atau 'No file chosen' jika tidak ada file
    document.getElementById('fileName').textContent = fileName;
});

    </script>
</body>

</html>