(function () {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const sidebarMenu = document.querySelector('.sidebar-menu');
    const main = document.querySelector('.main');

    // Inisialisasi tampilan untuk layar kecil
    if (window.innerWidth < 768) {
        main.classList.toggle('active');
        sidebarOverlay.classList.toggle('hidden');
        sidebarMenu.classList.toggle('-translate-x-full');
    }

    // Event listener untuk sidebar toggle
    sidebarToggle.addEventListener('click', function (e) {
        e.preventDefault();
        main.classList.toggle('active');
        sidebarOverlay.classList.toggle('hidden');
        sidebarMenu.classList.toggle('-translate-x-full');
    });
    
    sidebarOverlay.addEventListener('click', function (e) {
        e.preventDefault();
        main.classList.remove('active');
        sidebarOverlay.classList.add('hidden');
        sidebarMenu.classList.add('-translate-x-full');
    });

    // Sidebar dropdown
    document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const parent = item.closest('.group');
            parent.classList.toggle('selected');
        });
    });

  
    // Tab functionality
    document.querySelectorAll('[data-tab]').forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const tab = item.dataset.tab;
            const page = item.dataset.tabPage;
            const target = document.querySelector('[data-tab-for="' + tab + '"][data-page="' + page + '"]');

            document.querySelectorAll('[data-tab="' + tab + '"]').forEach(function (i) {
                i.classList.remove('active');
            });

            document.querySelectorAll('[data-tab-for="' + tab + '"]').forEach(function (i) {
                i.classList.add('hidden');
            });

            item.classList.add('active');
            target.classList.remove('hidden');
        });
    });

    // Reset sidebar on window resize
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768) {
            main.classList.remove('active');
            sidebarOverlay.classList.add('hidden');
            sidebarMenu.classList.remove('-translate-x-full');
        }
    });

    // Dropdown menu functionality
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('DropdownToggle');
        const submenu = document.getElementById('submenu');

        toggleButton.addEventListener('click', (e) => {
            e.stopPropagation();
            submenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            submenu.classList.add('hidden');
        });
    });
})();

function confirmLogout(){
    if(confirm("Apakah Anda ingin Logout ?")){
        Window.location.href = "logout.php";
    }
}