<?php
session_start();
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
        /* Tambahkan gaya khusus jika diperlukan */
    </style>
</head>

<body class="text-gray-800 font-inter flex flex-col min-h-screen">
    <!-- Sidebar -->
    <div class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-800">
            <img src="view-image.php?id=<?php echo $_SESSION['id_karyawan']; ?>" alt="User Avatar" class="w-8 h-8 rounded 
            object-cover">
            <span class="text-lg font-bold text-white ml-3"><?= $_SESSION['nama'] ?></span>
        </a>
        <ul class="mt-4">
            <li class="mb-1">
                <a href="user.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 
                rounded-md">
                    <i class="ri-home-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Home</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="pengajuan.php" class="flex items-center py-2 px-4 text-gray-300 scale-105 ring-1 ring-gray-800
                 hover:bg-gray-950 hover:text-gray-100 rounded-md">
                    <i class="ri-inbox-line mr-3 text-lg"></i>
                    <span class="text-sm">Pengajuan</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="riwayat.php" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100
                 rounded-md">
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
                        <img src="view-image.php?id=<?php echo $_SESSION['id_karyawan']; ?>" class="profile-img w-8 h-8
                         rounded object-cover" alt="Profile Picture">
                    </button>
                    <ul id="submenu" class="absolute shadow-md hidden py-1.5 right-5 rounded-md bg-white border
                     border-gray-100 w-full max-w-[120px]">
                        <li><a href="#" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600
                         hover:text-blue-500 hover:bg-gray-50">Profile</a></li>
                        <li><a href="#" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600
                         hover:text-blue-500 hover:bg-gray-50">Settings</a></li>
                        <li><a href="#" class="flex items-center text-[13px] py-1.5 px-3 text-gray-600
                         hover:text-blue-500 hover:bg-gray-50">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Card Chart -->
        <div class="h-auto w-full">
            <div class="grid gap-4 lg:gap-8 md:grid-cols-3 sm:grid-cols-1 p-6 pt-8">
                <div class="relative cursor-pointer group w-full focus:outline-none">
                    <span class="absolute top-0 left-0 w-full h-full mt-1 px-3 bg-gray-800 rounded-lg transition-all duration-300
            group-hover:bg-gray-700" aria-hidden="true"></span>
                    <!-- Box untuk Total Pengajuan 1 -->
                    <div class="relative p-6 rounded-lg bg-white shadow-md ring-2 ring-gray-800">

                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500">
                                <span>Remaining Izin</span>
                            </div>
                            <div class="text-3xl">
                                20
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Box untuk Cool Feature -->
            <div class="p-6 h-auto w-full">
                <button type="button" id="openModal" class="relative cursor-pointer group w-full focus:outline-none">
                    <!-- Background Layer -->
                    <span class="absolute top-0 left-0 w-full h-full mt-1 px-2 bg-gray-800 rounded-lg transition-all duration-300
                     group-hover:bg-gray-700" aria-hidden="true"></span>
                    <!-- Button Content -->
                    <div class="relative p-4 bg-white border-2 border-gray-800 rounded-lg transition-all duration-300
                    
                    group-hover:border-gray-700 group-hover:shadow-lg">
                        <div class="flex flex-col items-start">
                            <div class="flex items-center mb-2">
                                <span class="text-lg transition-transform duration-300 group-hover:rotate-12" aria-hidden="true">😎</span>
                                <h3 class="ml-2 text-base font-semibold text-gray-800 group-hover:text-gray-600">
                                    Ajukan Permohonan Secara Online!
                                </h3>
                            </div>
                            <p class="text-gray-600 text-sm group-hover:text-gray-500">
                                Proses pengajuan Anda dengan mudah dan cepat secara online.
                            </p>
                        </div>
                    </div>
                </button>
            </div>

            <!-- Modal -->
            <div id="modal" class="fixed inset-0 z-50 hidden">
                <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
                    <!-- Adjusted modal width and height for smaller size -->
                    <div id="modalContent" class="relative w-full max-w-[50rem] h-full max-h-[40rem] transform opacity-0 translate-y-[-100%] bg-gray-100 rounded-xl shadow-2xl transition-all duration-500 ease-out">
                        <div class="rounded-t bg-white mb-0 px-6 py-6">
                            <div class="flex flex-col items-start">
                                <!-- Nama Pengguna -->
                                <h6 id="userName" class="text-blueGray-700 text-xl font-bold">John Doe</h6>
                                <!-- Tanggal Pengajuan -->
                                <p id="submissionDate" class="text-blueGray-500 text-sm mt-2">Tanggal Pengajuan: 10 Desember 2024</p>
                            </div>
                            <button id="closeModal" class="absolute top-4 right-4 bg-gray-800 text-white active:bg-gray-900 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex-auto px-4 lg:px-6 py-8 pt-0 overflow-y-auto max-h-[30rem]">
                            <form>
                                <!-- Tanggal Izin Section -->
                                <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Tanggal Izin</h6>
                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-6/12 px-4">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Tanggal Izin Mulai</label>
                                        <input type="date" name="start_date" id="startDate" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Tanggal Izin Berakhir</label>
                                        <input type="date" name="end_date" id="endDate" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>

                                <!-- Jenis Izin Section with Select Box -->
                                <hr class="mt-6 border-b-1 border-blueGray-300">
                                <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Jenis Izin</h6>
                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-12/12 px-4">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Pilih Jenis Izin</label>
                                        <div class="relative">
                                            <select name="leave_type" id="leaveTypeSelect" class="border-2 border-gray-300 px-3 py-3 text-blueGray-600 appearance-none bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 hover:border-blue-600 focus:border-blue-600" onchange="toggleFields()">
                                                <option value="" disabled selected>-- Pilih Jenis Izin --</option>
                                                <option value="cuti">Cuti</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="izin_khusus">Izin Khusus</option>
                                            </select>
                                            <!-- Adjusted V Icon -->
                                            <label for="leaveTypeSelect" class="cursor-pointer absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                                <svg class="w-4 h-4 mx-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="18 15 12 9 6 15"></polyline>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Fields for  "Cuti" -->
                                <div id="selectAdditionalFields" class="hidden">
                                    <hr class="mt-6 border-b-1 border-blueGray-300">
                                    <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Keterangan Lain</h6>
                                    <div class="flex flex-wrap">
                                        <div class="w-full lg:w-12/12 px-4">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Keterangan</label>
                                            <select id="cutiType" class="border-2 border-gray-300 px-3 py-3 text-blueGray-600 appearance-none bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" onchange="toggleFields()">
                                                <option value="liburan">Liburan</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <!-- Alasan Section (Visible only when "Cuti" is selected) -->
                                <div id="alasanSection" class="hidden">
                                    <hr class="mt-6 border-b-1 border-blueGray-300">
                                    <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Alasan</h6>
                                    <div class="w-full lg:w-12/12 px-4">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Alasan Cuti</label>
                                        <textarea type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" rows="4">Masukkan alasan cuti di sini...</textarea>
                                    </div>
                                </div>

                                <!-- New Dropdown for Izin Khusus -->
                                <div id="izinKhususSection" class="hidden">
                                    <hr class="mt-6 border-b-1 border-blueGray-300">
                                    <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Izin Khusus</h6>
                                    <div class="flex flex-wrap">
                                        <div class="w-full lg:w-12/12 px-4">
                                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Pilih Keterangan Izin Khusus</label>
                                            <select class="border-2 border-gray-300 px-3 py-3 text-blueGray-600 appearance-none bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                <option value="pernikahan">Pernikahan</option>
                                                <option value="kelahiran">Kelahiran</option>
                                                <option value="kematian">Kematian</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lampiran File Section -->
                                <hr class="mt-6 border-b-1 border-blueGray-300">
                                <h6 class="text-blueGray-400 text-sm mt-3 mb-4 font-bold uppercase">Lampirkan File</h6>
                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-12/12 px-4">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">Pilih File</label>
                                        <input type="file" class="border-2 border-gray-300 px-3 py-3 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-end mt-6">
                                    <button id="cancelBtn" class="bg-white hover:bg-gray-300 text-gray-800 font-bold uppercase px-6 py-3 rounded shadow ease-linear transition-all duration-150 mr-2">Cancel</button>
                                    <button id="saveBtn" class="bg-gray-800 text-white font-bold uppercase px-6 py-3 rounded shadow hover:shadow-md ease-linear transition-all duration-150">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

    </main>

    <footer class="bg-white">
        <hr class="border-gray-300"> <!-- Garis bawah -->
        <div class="w-full mx-auto max-w-screen-xl p-4 text-center">
            <!-- Copyright Section -->
            <span class="text-sm text-gray-500">
                © 2023 <a href="#" class="hover:underline">PBL-114™</a>. All Rights Reserved.
            </span>
        </div>
    </footer>
    <script>
        const modal = document.getElementById("modal");
        const modalContent = document.getElementById("modalContent");
        const openBtn = document.getElementById("openModal");
        const closeBtn = document.getElementById("closeModal");
        const cancelBtn = document.getElementById("cancelBtn");

        function openModal() {
            modal.classList.remove("hidden");
            document.body.style.overflow = "hidden";

            // Triggering animation for modal appearance
            setTimeout(() => {
                modalContent.classList.remove("opacity-0", "translate-y-[-100%]");
                modalContent.classList.add("opacity-100", "translate-y-0");
            }, 10);
        }

        function closeModal() {
            // Reverse the transition
            modalContent.classList.remove("opacity-100", "translate-y-0");
            modalContent.classList.add("opacity-0", "translate-y-[-100%]");

            setTimeout(() => {
                modal.classList.add("hidden");
                document.body.style.overflow = "auto";
            }, 300); // Wait for the transition to complete
        }

        openBtn.addEventListener("click", openModal);
        closeBtn.addEventListener("click", closeModal);
        cancelBtn.addEventListener("click", closeModal);

        modal.addEventListener("click", (e) => {
            if (e.target === modal) closeModal();
        });

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && !modal.classList.contains("hidden")) {
                closeModal();
            }
        });


        function toggleFields() {
            const leaveType = document.getElementById('leaveTypeSelect').value;
            const cutiType = document.getElementById('cutiType') ? document.getElementById('cutiType').value : ''; // Check for Cuti options
            const alasanSection = document.getElementById('alasanSection');
            const selectAdditionalFields = document.getElementById('selectAdditionalFields');
            const izinKhususSection = document.getElementById('izinKhususSection');

            // Hide all additional sections first
            alasanSection.classList.add('hidden');
            selectAdditionalFields.classList.add('hidden');
            izinKhususSection.classList.add('hidden');

            // Show additional fields for "Cuti"
            if (leaveType === 'cuti') {
                selectAdditionalFields.classList.remove('hidden');
                // Show alasan section when "lainnya" is selected
                if (cutiType === 'lainnya') {
                    alasanSection.classList.remove('hidden');
                } else {
                    alasanSection.classList.add('hidden');
                }
            }
            // Show "Izin Khusus" section
            else if (leaveType === 'izin_khusus') {
                izinKhususSection.classList.remove('hidden');
            }
        }
    </script>

    <script src="../script.js" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
</body>

</html>