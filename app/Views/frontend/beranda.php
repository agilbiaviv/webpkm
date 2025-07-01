<?= $this->extend('frontend/template'); ?>

<?= $this->section('pageStyle') ?>

<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<!-- HERO SECTION -->
<section class="relative h-[90vh] flex items-center justify-center text-center px-6 overflow-hidden bg-black">
    <img src="<?= base_url('assets/img/hero.jpg'); ?>" alt="Puskesmas Kami"
        class="absolute inset-0 w-full h-full object-cover z-0 transform scale-110 md:scale-100 transition-transform duration-700" />

    <div class="absolute inset-0    bg-gradient-to-b from-black/70 to-black/20 z-10"></div>

    <div class="relative z-20 text-white max-w-3xl animate-fade-in">
        <h1 data-aos="fade-up" class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight drop-shadow-md">Selamat Datang di Puskesmas Bungatan</h1>
        <p data-aos="fade-up" data-aos-delay="250" class="text-lg md:text-xl mb-8 opacity-90">Pelayanan kesehatan terbaik untuk masyarakat.</p>
        <button data-aos="zoom-in" data-aos-delay="500" id="scrollToJadwal"
            class="bg-orange-500 text-white font-semibold px-6 py-3 rounded-full hover:bg-orange-600 transition flex items-center gap-2 shadow-lg cursor-pointer group mx-auto">
            Lihat Jadwal Pelayanan
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform -rotate-90 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>
</section>

<!-- BERITA SECTION -->
<section id="berita" class="py-20 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-12">
        <h2 data-aos="fade-up" class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Berita Terbaru</h2>
        <p data-aos="fade-up" data-aos-delay="250" class="text-gray-600 dark:text-gray-300">Info dan kegiatan terbaru dari Puskesmas kami.</p>
    </div>

    <?php if (!empty($berita)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <?php foreach ($berita as $i => $item): ?>
                <div data-aos="zoom-in" data-aos-delay="<?= $i * 200 ?>">
                    <?= view('frontend/components/berita_card', ['item' => $item]) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div data-aos="fade-up" class="text-center">
            <a href="<?= base_url('berita') ?>"
                class="inline-flex items-center gap-2 text-sm font-semibold text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 transition group underline underline-offset-4">
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

<!-- JADWAL SECTION -->
<section id="jadwal" class="py-20 px-6 bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 max-w-7xl mx-auto rounded-xl shadow-inner">
    <h2 data-aos="fade-up" data-aos-delay="250" class="text-3xl font-semibold mb-10 text-center text-gray-800 dark:text-white">Jadwal Pelayanan</h2>

    <div class="overflow-x-auto rounded-xl shadow-lg">
        <table data-aos="zoom-in" data-aos-delay="500" class="min-w-full bg-white dark:bg-gray-800 rounded-xl overflow-hidden">
            <thead class="bg-orange-500 text-white text-sm">
                <tr>
                    <th class="px-6 py-4 text-left">Hari</th>
                    <th class="px-6 py-4 text-left">Rawat Jalan</th>
                    <th class="px-6 py-4 text-left">Rawat Inap</th>
                    <th class="px-6 py-4 text-left">IGD</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jadwal = [
                    ['Senin', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
                    ['Selasa', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
                    ['Rabu', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
                    ['Kamis', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
                    ['Jumat', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
                    ['Sabtu', '07.00 - 12.00', '07.00 - 12.00', '24 Jam'],
                    ['Minggu', 'Tutup', 'Tutup', '24 Jam']
                ];
                foreach ($jadwal as $index => $row):
                    $isEven = $index % 2 === 0;
                    $rowClass = $isEven
                        ? 'bg-gray-100 dark:bg-gray-700'
                        : 'bg-white dark:bg-gray-800';
                ?>
                    <tr class="<?= $rowClass ?> hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200"><?= $row[0] ?></td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 <?= $row[1] === 'Tutup' ? 'font-bold' : '' ?>"><?= $row[1] ?></td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 <?= $row[2] === 'Tutup' ? 'font-bold' : '' ?>"><?= $row[2] ?></td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300"><?= $row[3] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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