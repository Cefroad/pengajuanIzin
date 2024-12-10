<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Dashboard</title>
    <style>
        .sidebar {
            transition: transform 0.3s ease;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        .sidebar-visible {
            transform: translateX(0);
        }
    </style>
</head>
<body>
  
    <!-- Main Content -->
    <div class="flex h-screen">
        <!-- Sidebar Container -->
        <div id="sidebar" class="sidebar sidebar-hidden fixed inset-0 top-0 bottom-0 left-0 h-full z-50 flex flex-col bg-white text-gray-700 max-w-[20rem] p-4 shadow-xl">
            <!-- Sidebar Header -->
            <div class="mb-2 p-4 flex items-center gap-2">
                <h5 class="block text-xl font-sans font-bold text-gray-700 pb-1">MENU</h5>
                <button type="button" id="close-sidebar" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute right-4">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close menu</span>
                </button>
            </div>
  
            <!-- Navigasi Menu-->
            <nav class="flex flex-col gap-1 min-w-[240px] p-2 font-sans text-base font-normal text-gray-700">
                <!-- Navigation Pengajuan Izin-->
                <div role="button" tabindex="0" class="hover:scale-110 flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50">
                    <div class="flex items-center mr-4">
                        <i class="fa-solid fa-share"></i>
                    </div>
                    <div class="flex-1">
                        <p>Pengajuan Izin</p>
                    </div>
                </div>
                <!-- Navigation Riwayat Izin -->
                <div role="button" tabindex="0" class="hover:scale-110 flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50">
                    <div class="flex items-center mr-4">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div class="flex-1">
                        <p>Riwayat Izin</p>
                    </div>
                </div>
                <!-- Navigation Kotak Email -->
                <div role="button" tabindex="0" class="hover:scale-110 flex items-center w-full p-3 rounded-lg text-start leading-tight transition-all hover:bg-blue-50">
                    <div class="flex items-center mr-4">
                        <i class="fa-solid fa-inbox"></i>
                    </div>
                    <div class="flex-1">
                        <p>Kotak Email</p>
                    </div>
                </div>
            </nav>
            <div class="hover:scale-110 cursor-pointer absolute bottom-[1rem] right-[1rem] p-[0.5rem] h-8 w-8">
                <i class="fa-solid fa-gear"></i>
            </div>
        </div>
        
        <!-- Sidebar Logo -->
        <div class="w-16 bg-white flex flex-col items-center py-4 border-r">
            <div class="text-2xl font-bold mb-8">
                <img src="profile.png" alt="" class="w-8 h-8 rounded-full object-cover mb-[15px]">
            </div>
                <div class="flex flex-col space-y-6">
                    <button id="open-sidebar" class="text-gray-500 hover:bg-gray-200 hover:rounded-sm">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <button id="open-sidebar" class="text-gray-500 hover:bg-gray-200 hover:rounded-sm">
                        <i class="fa-solid fa-share"></i>
                    </button>
                    <button id="open-sidebar" class="text-gray-500 hover:bg-gray-200 hover:rounded-sm">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </button>
                    <button id="open-sidebar" class="text-gray-500 hover:bg-gray-200 hover:rounded-sm">
                        <i class="fa-solid fa-inbox"></i>
                    </button>
                </div>
        </div>

        <!-- Header -->
        <div class="flex-1 flex flex-col">
            <div class="bg-white p-4 border-b border-gray-200">
                <h1 class="text-2xl font-semibold">My Events</h1>
            </div>
            <div class="p-4">
                <p>This is the main content area.</p>
                <p>Add more details about your events or features here.</p>
            </div>
        </div>
    </div>

    <script>
        // Get elements
        const openSidebarButton = document.getElementById('open-sidebar');
        const closeSidebarButton = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');

        // Nambah event listener Untuk membukan Sidebar
        openSidebarButton.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-hidden');
            sidebar.classList.add('sidebar-visible');
            openSidebarButton.classList.add('hidden'); // Menyembunyikan Open bar Ketika terbuka
        });

        // Nambah Event listener Untuk menurup sidebar
        closeSidebarButton.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-visible');
            sidebar.classList.add('sidebar-hidden');
            openSidebarButton.classList.remove('hidden'); // Menampilkan Open bar ketika menutup
        });
    </script>

</body>
</html>