<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $password = $_POST["password"];
    $user_type = $_POST["user_type"];

    if ($user_type == 'karyawan') {
        $query = "SELECT k.*, d.nama_departemen FROM karyawan k 
                  JOIN departemen d ON k.id_departemen = d.id_departemen
                  WHERE k.username = '$username'";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);

            if ($data['status_akun'] == 'nonaktif') {
                echo "<script>alert('Akun Anda belum diaktifkan. Silakan hubungi admin.'); window.location='index.php';</script>";
                exit();
            }

            if (password_verify($password, $data['password'])) {
                $_SESSION['id_karyawan'] = $data['id_karyawan'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['departemen'] = $data['nama_departemen'];
                $_SESSION['id_departemen'] = $data['id_departemen'];
                $_SESSION['izin'] = $data['remaining_izin'];
                $_SESSION['login_success'] = true;
                $_SESSION['user_type'] = 'karyawan';
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['login_success'] = false; 
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['login_success'] = false; 
            header("Location: index.php");
            exit();
        }
    } else if ($user_type == 'admin') {
        $query1 = "SELECT * FROM admin WHERE username = '$username'";
        $result1 = mysqli_query($connect, $query1);

        if ($result1 && mysqli_num_rows($result1) > 0) {
            $data1 = mysqli_fetch_assoc($result1);

            if ($data1['status_akun'] == 'nonaktif') {
                echo "<script>alert('Akun Anda belum diaktifkan. Silakan hubungi admin.'); window.location='index.php';</script>";
                exit();
            }

            if (password_verify($password, $data1['password'])) {
                $_SESSION['id_admin'] = $data1['id_admin'];
                $_SESSION['username'] = $data1['username'];
                $_SESSION['namaAdmin'] = $data1['nama'];
                $_SESSION['email'] = $data1['email'];
                $_SESSION['login_success'] = true;
                $_SESSION['user_type'] = 'admin';
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['login_success'] = false;
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['login_success'] = false;
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['not_selected'] = true;
        header("Location: index.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Login Form</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hidden {
            display: none;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3) translateY(-50%);
            }

            50% {
                opacity: 1;
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.9);
            }
        }

        .bounce-in {
            animation: bounceIn 0.6s ease forwards;
        }

        .fade-out {
            animation: fadeOut 0.5s ease-in-out forwards;
        }

        select {
            padding-right: 2rem;
            appearance: none;
        }

        select+span {
            font-size: 1.2rem;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        select:focus+span {
            color: #4CAF50;
        }

        input {
            padding-left: 2.5rem;
        }
    </style>
</head>

<body class="text-gray-800 font-inter">
    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-5 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow  md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="flex flex-col justify-center items-center text-3xl">
                        <div class="flex items-center">
                            <b>PBL</b> - 114
                        </div>
                        <p class="text-sm mt-2">Aplikasi Pengajuan Izin</p>
                    </div>

                    <form class="space-y-4 md:space-y-6" action="" method="post" autocomplete="off">
                        <div class="relative">
                            <select id="user-type" name="user_type" class="bg-gray-50 border border-gray-300 text-gray-900 
                            sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10
                             dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                              dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="#">Pilih Jenis User</option>
                                <option value="karyawan">Karyawan</option>
                                <option value="admin">Admin</option>
                            </select>
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="ri-arrow-drop-down-line"></i>
                            </span>
                        </div>

                        <div class="relative">
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-user-fill"></i>
                            </span>
                            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300
                             text-gray-900 sm:text-sm rounded-lg  block w-full p-2.5" placeholder="Username" required>
                        </div>

                        <div class="relative">
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-lock-fill"></i>
                            </span>
                            <input type="password" name="password" id="password" placeholder="Password" class="bg-gray-50 border
                             border-gray-300 text-gray-900 sm:text-sm rounded-lg  block w-full p-2.5" required>
                        </div>

                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-primary-300
                         font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                    </form>
                    <div class="text-sm text-gray-800 text-center">
                        Belum Punya Akun? <a href="registrasi.php" class="text-blue-500 hover:underline">Daftar</a>
                    </div>
                </div>
            </div>
            <?php if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === false): ?>
                <div class="bg-red-100 w-[30%] animate-shake text-center  border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
                    <span class="text-sm">Username atau password yang diberikan salah.</span>
                </div>
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['not_selected']) && $_SESSION['not_selected']): ?>
                <div class="bg-orange-200 w-[30%] animate-shake text-center border border-orange-300  px-4 py-3 rounded mt-4">
                    <span class="text-sm">Silahkan pilih jenis user terlebih dahulu.</span>
                </div>
                <?php unset($_SESSION['not_selected']); ?>
            <?php endif; ?>

        </div>
    </section>

    <!-- Success Modal -->
    <?php if (isset($_SESSION['login_success']) && $_SESSION['login_success']): ?>
        <div id="success-modal" class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] 
        before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif] hidden">
            <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-6 relative bounce-in">
                <i class="ri-close-fill w-[100rem] cursor-pointer float-right text-gray-400 hover:text-red-500" onclick="closeModal()"></i>
                <div class="my-8 text-center">
                    <i class="ri-check-fill w-14 text-6xl text-green-500 inline"></i>
                    <h4 class="text-xl text-gray-800 font-semibold mt-4">Login Successfully!</h4>
                    <p class="text-sm text-gray-500 leading-relaxed mt-4">Harap tunggu anda akan segera dipindahkan ke halaman dashboard <?=$_SESSION['user_type']?></p>
                </div>
                <button type="button" class="px-5 py-2.5 w-full rounded-lg text-white text-sm border-none outline-none
                 bg-gray-800 hover:bg-gray-700" onclick="closeModal()">Got it</button>
            </div>
        </div>

    <?php endif; ?>



    <!-- // Reset setelah ditampilkan ?> -->

    <script>
        // Tampilkan modal jika login sukses
        <?php if (isset($_SESSION['login_success']) && $_SESSION['login_success']): ?>
            setTimeout(() => {
                const modal = document.getElementById("success-modal");
                modal.classList.remove("hidden");

                // Redirect setelah 3 detik
                setTimeout(() => {
                    modal.classList.add("fade-out");
                    setTimeout(() => {
                        window.location.href = '<?php echo $_SESSION['user_type'] === "admin" ? "./admin/admin-panel.php" : "./karyawan/user.php"; ?>';
                    }, 500); // Tunggu animasi keluar selesai
                }, 1000); // Tunggu selama 3 detik
            }, ); // Tampilkan modal setelah 1 detik
        <?php endif; ?>

        // Fungsi untuk menutup modal
        function closeModal() {
            const modal = document.getElementById("success-modal");
            modal.classList.add("fade-out");
            setTimeout(() => modal.classList.add("hidden"), 0);
        }
    </script>
</body>

</html>