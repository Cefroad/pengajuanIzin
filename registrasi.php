<?php
include 'koneksi.php';

$result = mysqli_query($connect,"SELECT * FROM departemen");
$row = mysqli_num_rows($result)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="font-inter text-gray-800">
    <div class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-5 py-8 mx-auto md:h-screen lg:py-0 ">
            <div class="w-full bg-white rounded-lg shadow md:mt-0 md:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-6">
                    <div class="flex flex-col justify-center items-center text-xl">
                            <b>REGISTRASI</b>
                    </div>
                    <form action="" method="post" class="space-y-5 md:space-y-6">
                        <div class="relative">
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-user-add-line"></i>
                            </span>
                            <input type="text" class="bg-gray border border-gray-300 text-gray-900 sm:text-sm rounded-lg p-2.5 w-full block" placeholder="Nama Lengkap" name="nama" id="">
                        </div>
                        <div class="relative">
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-user-line"></i>
                            </span>
                            <input type="text" class="bg-gray border border-gray-300 text-gray-900 sm:text-sm rounded-lg p-2.5 w-full block" placeholder="Username" name="username" id="">
                        </div>
                        <div class="relative">
                            <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-mail-line"></i>
                            </span>
                            <input type="text" class="bg-gray border border-gray-300 text-gray-900 sm:text-sm rounded-lg p-2.5 w-full block" placeholder="Email" name="email" id="">
                        </div>
                        <div class="relative">
                            <span class="absolute left-[43%] top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="ri-lock-line"></i>
                            </span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <input type="password" class="col-span-1 bg-gray border border-gray-300 text-gray-900 sm:text-sm rounded-lg p-2.5 w-full block" placeholder="••••••••" name="password" id="">
                                <select name="departemen" id="" class="mx-2 border border-gray-300 text-gray-900 sm:text-sm rounded-lg pl-4 p-2.5 w-full sm:w-[95%]">
                                    <option value="#" class="text-gray-300">-- Pilih --</option>
                                    <?php
                                    while($data = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?=$data['nama_departemen']?>"><?=$data['nama_departemen']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Separate button from the form fields -->
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Sign Up
                        </button>
                    </form>
                        <div class="text-center text-sm ">
                         Sudah Punya Akun? <a href="index.php" class="text-blue-500 hover:underline">Masuk</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>