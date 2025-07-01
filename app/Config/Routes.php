<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===========================================

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('beranda', 'BerandaController::index');

    //============== Menu Berita =====================
    $routes->get('berita', 'BeritaController::index');
    $routes->get('berita/create', 'BeritaController::create');
    $routes->get('berita/edit/(:num)', 'BeritaController::edit/$1');
    $routes->post('berita/fetch', 'BeritaController::fetchData');
    $routes->post('berita/updateStatus', 'BeritaController::updateStatus');
    $routes->post('berita/update/(:num)', 'BeritaController::update/$1');
    $routes->delete('berita/delete/(:num)', 'BeritaController::delete/$1');

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




    $routes->post('berita/save', 'BeritaController::save');

    $routes->post('kategori/add', 'KategoriController::store');
    $routes->get('kategori/fetch', 'KategoriController::fetch');

    $routes->get('layanan-kesehatan', 'LayananController::index');
    $routes->get('layanan/rawat-jalan', 'LayananController::rawatJalan');
    $routes->get('pengaduan', 'PengaduanController::index');
    $routes->get('inovasi', 'InovasiController::index');
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
    $routes->get('profil', 'Profil::index');
    $routes->get('galeri', 'Galeri::index');
});


// ============== MENU Routes ===============
$routes->get('menu', 'MenuController::index');
// ==========================================