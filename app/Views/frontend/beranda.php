<?= $this->extend('frontend/template'); ?>

<?= $this->section('pageStyle') ?>

<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<!-- HERO SECTION -->
<section class="relative h-[90vh] flex items-center justify-center text-center px-6 overflow-hidden bg-black">
    <img src="<?= base_url('assets/img/hero.jpg'); ?>" alt="Puskesmas Kami"
        class="absolute inset-0 w-full h-full object-cover z-0 transform scale-110 md:scale-100 transition-transform duration-700 animate-[slowZoom_20s_ease-in-out_infinite]" />

    <div class="absolute inset-0 bg-gradient-to-b from-black/70 to-black/20 z-10"></div>

    <div class="relative z-20 text-white max-w-3xl animate-fade-in">
        <h1 data-aos="fade-up" class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight drop-shadow-md">Selamat Datang di Puskesmas Bungatan</h1>
        <p data-aos="fade-up" data-aos-delay="250" class="text-lg md:text-xl mb-8 opacity-90">Pelayanan kesehatan terbaik untuk masyarakat.</p>
        <button data-aos="zoom-in" data-aos-delay="500" id="scrollToJadwal"
            class="bg-orange-500 text-white font-semibold px-6 py-3 rounded-full hover:bg-orange-600 transition flex items-center gap-2 shadow-lg cursor-pointer group mx-auto transition-transform duration-300 hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-orange-400">
            Lihat Jadwal Pelayanan
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform -rotate-90 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>
</section>

<!-- BERITA SECTION -->
<section id="berita" class="pt-20 pb-10 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-12">
        <h2 data-aos="fade-up" class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Berita Terbaru</h2>
        <p data-aos="fade-up" class="text-gray-600 dark:text-gray-300">Info dan kegiatan terbaru dari Puskesmas kami.</p>
    </div>

    <?php if (!empty($berita)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 auto-rows-fr">
            <?php foreach ($berita as $i => $item): ?>
                <div data-aos="fade-up" data-aos-delay="<?= $i * 150 ?>">
                    <?= view('frontend/components/berita_card', ['item' => $item]) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div data-aos="fade-up" class="text-center">
            <a href="<?= base_url('berita') ?>"
                class="inline-flex items-center gap-2 text-sm font-semibold text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 transition group underline underline-offset-4 focus:outline-none focus:ring-2 focus:ring-orange-400">
                <span>Lihat semua berita</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-600 dark:text-gray-300">Belum ada berita terbaru.</p>
    <?php endif; ?>
</section>

<?php

$jadwal = [
    ['Senin', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
    ['Selasa', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
    ['Rabu', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
    ['Kamis', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
    ['Jumat', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
    ['Sabtu', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
    ['Minggu', 'Tutup', 'Tutup', '24 Jam']
]; ?>

<section id="jadwal" class="pt-10 pb-20 px-6 max-w-5xl mx-auto">
    <h2 class="text-3xl font-semibold mb-10 text-center text-gray-800 dark:text-white" data-aos="fade-up" data-aos-delay="100">Jadwal Pelayanan</h2>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($jadwal as $index => $row): ?>
            <?php
            $isLast = $index === array_key_last($jadwal);
            $colClass = $isLast ? 'lg:col-start-2' : '';
            ?>
            <div class="rounded-xl bg-white dark:bg-gray-800 shadow p-5 space-y-3 transition hover:shadow-md <?= $colClass ?>" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                <h3 class="text-xl font-bold text-orange-500"><?= $row[0] ?></h3>
                <div class="text-gray-700 dark:text-gray-300 flex justify-between border-b pb-1">
                    <span>Rawat Jalan</span>
                    <span class="<?= $row[1] === 'Tutup' ? 'font-bold text-red-500' : 'text-gray-700 dark:text-gray-300' ?>">
                        <?= $row[1] ?>
                    </span>
                </div>
                <div class="text-gray-700 dark:text-gray-300 flex justify-between border-b pb-1">
                    <span>Rawat Inap</span>
                    <span class="<?= $row[2] === 'Tutup' ? 'font-bold text-red-500' : 'text-gray-700 dark:text-gray-300' ?>">
                        <?= $row[2] ?>
                    </span>
                </div>
                <div class="text-gray-700 dark:text-gray-300 flex justify-between">
                    <span>IGD</span>
                    <span><?= $row[3] ?></span>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('pageScript') ?>
<script>
    document.getElementById('scrollToJadwal')?.addEventListener('click', function() {
        document.getElementById('jadwal')?.scrollIntoView({
            behavior: 'smooth'
        });
    });
</script>
<?= $this->endSection() ?>