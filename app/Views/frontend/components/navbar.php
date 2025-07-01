<nav id="navbar" class="fixed top-0 left-0 w-full backdrop-blur-sm shadow z-50 transition-transform duration-300 bg-white/90 text-gray-900 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 ease-in-out will-change-transform">
    <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="<?= base_url(); ?>" class="text-xl font-bold text-gray-900 dark:text-white">
            PKM Bungatan
        </a>

        <!-- Desktop Menu -->
        <div class="space-x-6 hidden md:flex">
            <a href="<?= base_url(); ?>" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">Beranda</a>

            <div class="relative group hidden md:block">
                <button class="flex items-center text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">
                    Profil
                    <!-- Icon -->
                    <svg class="ml-1 w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Submenu -->
                <div class="absolute left-0 top-full bg-white dark:bg-gray-800 mt-2 rounded shadow-md min-w-[200px] z-50 opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-300">
                    <a href="<?= base_url('profil/sambutan'); ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:bg-gray-700">Sambutan Kepala Puskesmas</a>
                    <a href="<?= base_url('profil/visi-misi'); ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:bg-gray-700">Visi & Misi</a>
                    <a href="<?= base_url('profil/struktur-organisasi'); ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:bg-gray-700">Struktur Organisasi</a>
                </div>
            </div>



            <a href="<?= base_url('inovasi'); ?>" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">Inovasi</a>
            <a href="<?= base_url('berita'); ?>" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">Berita</a>
            <a href="<?= base_url('pengaduan'); ?>" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">Pengaduan</a>
            <a href="<?= base_url('layanan'); ?>" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">Layanan</a>
        </div>

        <div class="flex items-center">

            <!-- Burger Icon -->
            <button id="navbarToggle" class="md:hidden p-2 rounded text-gray-700 dark:text-gray-300 focus:outline-none" aria-label="Toggle menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Dark mode switch -->
            <button id="darkModeSwitch" class="p-2 bg-gray-200 dark:bg-gray-700 rounded mr-2">
                🌙
            </button>
        </div>

    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col space-y-2">
            <a href="<?= base_url(); ?>" class="block border-b border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 py-2 pl-2">Beranda</a>

            <div class="border-b border-gray-300 dark:border-gray-500">
                <button type="button" class="w-full text-left py-2 pl-2 pr-2 flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400" data-toggle="submenu" data-target="submenu-profil">
                    Profil
                    <svg class="submenu-icon w-4 h-4 transition-transform duration-300m" fill=" none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="submenu-profil" class="max-h-0 overflow-hidden transition-all duration-300 pl-4">
                    <a href="<?= base_url('profil/sambutan'); ?>" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Sambutan Kepala Puskesmas</a>
                    <a href="<?= base_url('profil/visi-misi'); ?>" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Visi & Misi</a>
                    <a href="<?= base_url('profil/struktur-organisasi'); ?>" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Struktur Organisasi</a>
                </div>

            </div>

            <a href="<?= base_url('inovasi'); ?>" class="block border-b border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 py-2 pl-2">Inovasi</a>
            <a href="<?= base_url('berita'); ?>" class="block border-b border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 py-2 pl-2">Berita</a>
            <a href="<?= base_url('pengaduan'); ?>" class="block border-b border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 py-2 pl-2">Pengaduan</a>
            <a href="<?= base_url('layanan'); ?>" class="block border-b border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 py-2 pl-2">Layanan</a>
        </div>
    </div>
</nav>