<?php $current_url = current_url(); ?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>" class="brand-link">
        <img src="<?= base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Website</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="<?= base_url('admin/beranda') ?>" class="nav-link <?= current_url() === base_url('admin/beranda') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('admin/berita') ?>" class="nav-link <?= current_url() === base_url('admin/berita') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>Berita</p>
                    </a>
                </li>

                <?php
                $profil_links = [
                    base_url('admin/profil/sambutan'),
                    base_url('admin/profil/struktur-organisasi'),
                    base_url('admin/profil/visi-misi')
                ];
                $is_profil_active = in_array(current_url(), $profil_links);
                ?>
                <li class="nav-item has-treeview <?= $is_profil_active ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= $is_profil_active ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profil
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/profil/sambutan') ?>" class="nav-link <?= current_url() === base_url('admin/profil/sambutan') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sambutan Kepala Puskesmas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/profil/struktur-organisasi') ?>" class="nav-link <?= current_url() === base_url('admin/profil/struktur-organisasi') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Struktur Organisasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/profil/visi-misi') ?>" class="nav-link <?= current_url() === base_url('admin/profil/visi-misi') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Visi dan Misi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('admin/inovasi') ?>" class="nav-link <?= current_url() === base_url('admin/inovasi') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-lightbulb"></i>
                        <p>Inovasi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('admin/pengaduan') ?>" class="nav-link <?= current_url() === base_url('admin/pengaduan') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Pengaduan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('admin/layanan-kesehatan') ?>" class="nav-link <?= current_url() === base_url('admin/layanan-kesehatan') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-stethoscope"></i>
                        <p>Layanan Kesehatan</p>
                    </a>
                </li>

                <li class="nav-header">MASTER</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/pengguna') ?>" class="nav-link <?= current_url() === base_url('admin/pengguna') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/footer-config') ?>" class="nav-link <?= current_url() === base_url('admin/footer-config') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Konfigurasi Footer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/kategori-berita') ?>" class="nav-link <?= current_url() === base_url('admin/kategori-berita') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Kategori Berita</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>