<?php
session_start();
include "koneksi.php";
$id = $_SESSION['id_admin'];
$result = mysqli_query($connect, "SELECT * FROM jenis_izin");
$row = mysqli_num_rows($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $jenis_izin = $_POST['jenis_izin'];
    $maks_hari = $_POST['maks_hari'];

    $query = "INSERT INTO jenis_izin (jenis_izin, maks_hari) VALUES ('$jenis_izin', '$maks_hari')";


    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Data berhasil ditambahkan!');window.location='jenis_izin.php';</script>";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($connect);
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $deleteId = $_GET['id'];

    if (is_numeric($deleteId)) {
        $stmt = $connect->prepare("DELETE FROM jenis_izin WHERE id_jenis = ?");
        $stmt->bind_param("i", $deleteId); 
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil dihapus!');</script>";
            echo "<script>window.location.href='jenis_izin.php';</script>"; 
        } else {
            echo "<script>alert('Gagal menghapus data!');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('ID tidak valid!');</script>";
    }
}

if (isset($_POST['update'])) {
    $id_izin = $_POST['id_izin'];
    $jenis_izin = $_POST['jenis_izin'];
    $maks_hari = $_POST['maks_hari'];

    if (!empty($jenis_izin) && !empty($maks_hari)) {
        $stmt = $connect->prepare("UPDATE jenis_izin SET jenis_izin = ?, maks_hari = ? WHERE id_jenis = ?");
        $stmt->bind_param("ssi", $jenis_izin, $maks_hari, $id_izin);
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil diperbarui!');</script>";
            echo "<script>window.location.href='jenis_izin.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data!');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Semua field harus diisi!');</script>";
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
                <span id="breadcrumb-item" class="text-gray-400">Jenis Izin</span>
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
                <button id="openModal" class="bg-gray-800 text-white font-bold  p-2 rounded shadow hover:shadow-md ease-linear transition-all duration-150">Tambah Data</button>
                <!-- Table Section -->
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-1/3">
                                        Jenis Izin
                                    </th>
                                    <th class="px-5 py-3 border-b-2 text-center border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1; // Initialize counter variable
                                while ($user = mysqli_fetch_assoc($result)):
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
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm w-1/3">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <?php echo $user['jenis_izin']; ?>
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="text-center space-x-3">
                                                <button
                                                    class="bg-gray-800 text-white font-bold uppercase p-2 rounded shadow hover:shadow-md ease-linear transition-all duration-150 openModal"
                                                    data-id="editModal<?php echo $user['id_jenis']; ?>">
                                                    Edit
                                                </button>
                                                <a 
                                                    class="bg-white ring-1 ring-gray-800 text-gray-800 font-bold uppercase p-2 rounded shadow hover:shadow-md ease-linear transition-all duration-150" 
                                                    href="jenis_izin.php?action=delete&id=<?php echo $user['id_jenis']?>"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                >
                                                    Delete
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                    <!-- modal Edit -->
                                    <div id="editModal<?php echo $user['id_jenis']; ?>"  class="modal fixed inset-0 z-50 hidden">
                                        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
                                            <div class="modalContent relative w-full max-w-[50rem] h-full max-h-[25rem] transform opacity-0 translate-y-[-100%] bg-gray-100 rounded-xl shadow-2xl transition-all duration-500 ease-out">
                                                <div class="rounded-t bg-white mb-0 px-6 py-6">
                                                    <h6 class="text-blueGray-700 text-xl font-bold">Edit Data</h6>
                                                    <button class="closeModal absolute top-4 right-4 bg-gray-800 text-white active:bg-gray-900 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                                X    
                                                </button>
                                                </div>
                                                <div class="flex-auto px-4 lg:px-6 py-8 pt-0">
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="id_izin" value="<?php echo $user['id_jenis']; ?>">
                                                        <div class="mb-4">
                                                            <label class="block text-sm font-bold mb-2">Jenis Izin</label>
                                                            <input type="text" name="jenis_izin" value="<?php echo $user['jenis_izin']; ?>" class="border-2 border-gray-300 px-3 py-3 text-gray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block text-sm font-bold mb-2">Maksimal Hari</label>
                                                            <input type="number" name="maks_hari" value="<?php echo $user['maks_hari']; ?>" class="border-2 border-gray-300 px-3 py-3 text-gray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full">
                                                        </div>
                                                        <div class="flex justify-end">
                                                            <button type="submit" name="update" class="bg-gray-800 text-white font-bold uppercase px-6 py-3 rounded shadow hover:shadow-md transition-all duration-150">
                                                                Save
                                                            </button>
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
        <!-- Modal Tambah -->
        <div id="modal" class="fixed inset-0 z-50 hidden">
            <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
                <!-- Adjusted modal width and height for smaller size -->
                <div id="modalContent" class="relative w-full max-w-[50rem] h-full max-h-[25rem] transform opacity-0 translate-y-[-100%] bg-gray-100 rounded-xl shadow-2xl transition-all duration-500 ease-out">
                    <div class="rounded-t bg-white mb-0 px-6 py-6">
                        <div class="flex flex-col items-start">
                            <!-- Nama Pengguna -->
                            <h6 id="userName" class="text-blueGray-700 text-xl font-bold">Tambah Data</h6>
                        </div>
                        <button id="closeModal" class="absolute top-4 right-4 bg-gray-800 text-white active:bg-gray-900 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-auto px-4 lg:px-6 py-8 pt-0 overflow-y-auto max-h-[30rem]">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Jenis Izin</h6>
                            <div class="w-full lg:w-12/12 px-4">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Jenis Izin</label>
                                <input name="jenis_izin" class="border-2 border-gray-300 px-3 py-3 text-blueGray-600 appearance-none bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" required>
                            </div>
                            <div class="w-full lg:w-12/12 px-4 mt-4">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Maksimal Hari</label>
                                <input name="maks_hari" type="number" class="border-2 border-gray-300 px-3 py-3 text-blueGray-600 appearance-none bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end mt-6">
                                <button type="submit" name="tambah" class="bg-gray-800 text-white font-bold uppercase px-6 py-3 rounded shadow hover:shadow-md ease-linear transition-all duration-150">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>


    <footer class="bg-white">
        <hr class="border-gray-300">
        <div class="w-full mx-auto max-w-screen-xl p-4 text-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">© 2023 <a href="#" class="hover:underline">PBL-114™</a>. All Rights Reserved.</span>
        </div>
    </footer>
    
    <script src="script.js"></script>
    <script src="../karyawan/script.js"></script>
    <script src="../script.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
</body>

</html>