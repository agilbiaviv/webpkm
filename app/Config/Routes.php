<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===========================================

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('beranda', 'BerandaController::index');

    //============== Menu Berita =====================
    $routes->get('berita', 'berita\BeritaController::index');
    $routes->get('berita/create', 'berita\BeritaController::create');
    $routes->get('berita/edit/(:num)', 'berita\BeritaController::edit/$1');
    $routes->post('berita/fetch', 'berita\BeritaController::fetchData');
    $routes->post('berita/save', 'berita\BeritaController::save');
    $routes->post('berita/updateStatus', 'berita\BeritaController::updateStatus');
    $routes->post('berita/update/(:num)', 'berita\BeritaController::update/$1');
    $routes->delete('berita/delete/(:num)', 'berita\BeritaController::delete/$1');

    $routes->get('kategori/fetch', 'berita\KategoriController::fetch');
    $routes->post('kategori/add', 'berita\KategoriController::store');
    //============== Menu Profil =====================
    $routes->get('profil', 'profil/ProfilController::index');
    $routes->get('profil/sambutan', 'profil\ProfilController::sambutan');
    $routes->get('profil/visi-misi', 'profil\ProfilController::visiMisi');

    //  ==== struktur Organisasi ====
    $routes->get('profil/struktur-organisasi', 'profil\ProfilController::strukturOrganisasi');
    $routes->get('profil/struktur-organisasi/chart-data', 'profil\StrukturOrganisasiController::chartData');
    // create
    $routes->get('profil/struktur-organisasi/create', 'profil\StrukturOrganisasiController::create');
    $routes->post('profil/struktur-organisasi/store', 'profil\StrukturOrganisasiController::store');
    // edit
    $routes->get('profil/struktur-organisasi/edit/(:num)', 'profil\StrukturOrganisasiController::edit/$1');
    $routes->post('profil/struktur-organisasi/update/(:num)', 'profil\StrukturOrganisasiController::update/$1');
    // delete
    $routes->delete('profil/struktur-organisasi/delete/(:num)', 'profil\StrukturOrganisasiController::delete/$1');
    //===============================

    // ===== Sambutan Ka. Pusk =====
    $routes->post('sambutan/save', 'profil\SambutanController::save');
    //===============================

    // ==== Visi & Misi ====
    $routes->post('visi-misi/save', 'profil\VisiMisiController::save');
    //===============================






    $routes->get('layanan-kesehatan', 'LayananController::index');
    $routes->get('layanan/rawat-jalan', 'LayananController::rawatJalan');
    $routes->get('pengaduan', 'PengaduanController::index');
    $routes->get('inovasi', 'InovasiController::index');

    $routes->get('pengguna', 'PenggunaController::index');
    $routes->get('footer-config', 'FooterConfigController::index');
    $routes->post('footer-config/update', 'FooterConfigController::update');
    $routes->get('kategori-berita', 'KategoriBeritaController::index');
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('/backend', ['namespace' => 'App\Controllers\Admin', 'filter' => 'logged'], function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin');
    // ============== CAPTCHA Routes ===============
    $routes->get('captcha/generate', 'Captcha::generate');
    // =============================================
});


// Grouping routes for frontend
$routes->group('/', ['namespace' => 'App\Controllers\Frontend'], function ($routes) {
    $routes->get('', 'Beranda::index');

    // ========= Berita ==========
    $routes->get('berita', 'Berita::index');
    $routes->get('berita/loadMore', 'Berita::loadMore');
    $routes->get('berita/(:segment)', 'Berita::detail/$1');

    // ===========================

    // ========= Profil ==========
    $routes->get('profil/sambutan', 'Profil\SambutanController::index');

    $routes->get('layanan', 'Layanan::index');
    $routes->get('inovasi', 'Inovasi::index');
    $routes->get('profil', 'Profil::index');
    $routes->get('galeri', 'Galeri::index');

    // ==== untuk auto-refresh setelah maintenance selesai ====
    $routes->get('maintenance-status', 'MaintenanceStatusController::index');
});


// ============== MENU Routes ===============
$routes->get('menu', 'MenuController::index');
// ==========================================