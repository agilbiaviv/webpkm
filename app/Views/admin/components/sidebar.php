<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>" class="brand-link">
        <img src="<?= base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">dmin Website</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php
                $current_url = current_url(); // Get current URL
                ?>

                <?php foreach ($menus as $menu) : ?>
                    <?php
                    $isActive = (base_url('admin' . $menu['url']) == $current_url) ? 'active' : '';

                    // Check if any submenu is active
                    $isSubmenuActive = false;
                    if (!empty($menu['submenu'])) {
                        foreach ($menu['submenu'] as $submenu) {
                            if (base_url('admin' . $submenu['url']) == $current_url) {
                                $isSubmenuActive = true;
                                break;
                            }
                        }
                    }

                    // Add "menu-open" if a submenu is active
                    $menuOpen = $isSubmenuActive ? 'menu-open' : '';
                    ?>

                    <?php if (!empty($menu['submenu'])) { ?>
                        <li class="nav-item <?= $menuOpen ?>">
                            <a href="#" class="nav-link <?= $isSubmenuActive ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    <?= $menu['title']; ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php foreach ($menu['submenu'] as $submenu) : ?>
                                    <?php
                                    $isSubActive = (base_url('admin' . $submenu['url']) == $current_url) ? 'active' : '';
                                    ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url('admin' . $submenu['url']); ?>" class="nav-link <?= $isSubActive ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p><?= $submenu['title']; ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="<?= base_url('admin' . $menu['url']); ?>" class="nav-link <?= $isActive ?>">
                                <i class="nav-icon <?= $menu['icon'] ?>"></i>
                                <p>
                                    <?= $menu['title'] ?>
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                <?php endforeach; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>