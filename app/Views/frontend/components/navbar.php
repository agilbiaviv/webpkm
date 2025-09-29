<nav id="navbar" class="fixed top-0 left-0 w-full backdrop-blur-sm shadow z-50 dark:shadow-[0_2px_4px_rgba(255,255,255,0.06)] transition-transform duration-300 bg-white/90 text-gray-900 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 ease-in-out will-change-transform">
    <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="<?= base_url(); ?>" class="text-xl font-bold text-gray-900 dark:text-white">
            <?= esc($footer['nama_instansi'] ?? 'Puskesmas') ?>
        </a>

        <!-- Desktop Menu -->
        <div class="space-x-6 hidden md:flex">
            <a href="<?= base_url(); ?>" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">Beranda</a>
            <?php function renderMenu($menus)
            { ?>
                <?php foreach ($menus as $menu): ?>
                    <?php if (!empty($menu['children'])): ?>
                        <div class="relative group hidden md:block">
                            <button class="flex items-center text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">
                                <?= esc($menu['name']) ?>
                                <svg class="ml-1 w-4 h-4 transition-transform duration-300 group-hover:rotate-180"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute left-0 top-full bg-white dark:bg-gray-800 mt-2 rounded shadow-md min-w-[200px] z-50 opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-300">
                                <?php foreach ($menu['children'] as $child): ?>
                                    <a href="<?= getMenuUrl($child) ?>"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:bg-gray-700">
                                        <?= esc($child['name']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= getMenuUrl($menu) ?>" class="text-gray-700 dark:text-gray-300 hover:text-orange-500 dark:hover:text-orange-400">
                            <?= esc($menu['name']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php } ?>
            <?= renderMenu($menus) ?>
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

            <?php function renderMobileMenu($menus)
            { ?>
                <?php foreach ($menus as $menu): ?>
                    <?php if (!empty($menu['children'])): ?>
                        <div class="border-b border-gray-300 dark:border-gray-500">
                            <button type="button" class="w-full text-left py-2 pl-2 pr-2 flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400"
                                onclick="this.nextElementSibling.classList.toggle('max-h-0'); this.nextElementSibling.classList.toggle('max-h-[500px]')">
                                <?= esc($menu['name']) ?>
                                <svg class="submenu-icon w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="max-h-0 overflow-hidden transition-all duration-300 pl-4">
                                <?= renderMobileMenu($menu['children']) ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= getMenuUrl($menu) ?>" class="block border-b border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 py-2 pl-2">
                            <?= esc($menu['name']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php } ?>
            <?= renderMobileMenu($menus) ?>
        </div>
    </div>
</nav>