<!DOCTYPE html>
<html lang="id" class="transition-colors duration-300">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Puskesmas'; ?></title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link href="<?= base_url("css/main.css"); ?>" rel="stylesheet" />

    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet">

    <?= $this->renderSection('pageStyle'); ?>
</head>

<body id="body" class="font-sans bg-white text-gray-900 dark:bg-gray-900 dark:text-white transition-colors duration-300">

    <!-- Navbar -->
    <?= $this->include('frontend/components/navbar'); ?>

    <!-- Main Content -->
    <main class="pt-16">
        <?= $this->renderSection('content'); ?>
    </main>

    <!-- Footer -->
    <?= $this->include('frontend/components/footer'); ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('darkModeSwitch');
            const html = document.documentElement;

            // Icons
            const moonIcon = '🌙';
            const sunIcon = '☀️';

            // Initialize dark mode from localStorage
            if (localStorage.getItem('dark-mode-isActive') === 'true') {
                html.classList.add('dark');
                toggle.textContent = sunIcon;
            } else {
                html.classList.remove('dark');
                toggle.textContent = moonIcon;
            }

            if (!toggle) return;

            toggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                const isDark = html.classList.contains('dark');
                localStorage.setItem('dark-mode-isActive', isDark ? 'true' : 'false');
                toggle.textContent = isDark ? sunIcon : moonIcon;
            });
        });
    </script>

    <script>
        const navbar = document.getElementById('navbar');
        let lastScroll = 0;
        let ticking = false;

        function onScroll() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > lastScroll && currentScroll > 80) {
                // Scrolling down
                navbar.classList.add('-translate-y-full');
            } else {
                // Scrolling up
                navbar.classList.remove('-translate-y-full');
            }

            lastScroll = currentScroll;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    onScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });
    </script>

    <script>
        document.getElementById('navbarToggle').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submenuToggles = document.querySelectorAll('[data-toggle="submenu"]');

            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const targetId = toggle.getAttribute('data-target');
                    const submenu = document.getElementById(targetId);
                    const icon = toggle.querySelector('.submenu-icon');

                    if (submenu) {
                        const isOpen = submenu.classList.contains('max-h-40');

                        submenu.classList.remove('max-h-0', 'max-h-40');
                        submenu.classList.add('overflow-hidden');

                        if (isOpen) {
                            submenu.classList.add('max-h-0');
                            icon?.classList.remove('rotate-180');
                        } else {
                            submenu.classList.add('max-h-40');
                            icon?.classList.add('rotate-180');
                        }
                    }
                });
            });
        });
    </script>

    <?= $this->renderSection('pageScript'); ?>
</body>

</html>