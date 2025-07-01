<?= $this->extend('frontend/template'); ?>

<?= $this->section('pageStyle') ?>

<?= $this->endSection() ?>


<?= $this->section('content'); ?>
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Card Dua Kolom -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row items-stretch">

            <!-- Kolom Kiri: Foto Kepala Puskesmas -->
            <?php if (!empty($sambutan['foto_kepala'])): ?>
                <div class="w-full md:w-1/3 lg:w-1/4 p-6 flex justify-center items-center">
                    <div class="w-48 h-64 rounded-xl overflow-hidden shadow-md">
                        <img
                            src="<?= base_url('uploads/sambutan/' . $sambutan['foto_kepala']); ?>"
                            alt="Foto <?= esc($sambutan['nama_kepala']); ?>"
                            class="object-cover w-full h-full transition-transform duration-300 hover:scale-105" />
                    </div>
                </div>
            <?php else: ?>
                <!-- Kalau belum ada foto, bisa sisakan div kosong supaya layout tetap konsisten -->
                <div class="w-full md:w-1/3 lg:w-1/4 p-6 flex justify-center items-center">
                    <div class="w-48 h-64 rounded-xl bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                        <span class="text-gray-500 dark:text-gray-400">No Image</span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Kolom Kanan: Judul, Isi Sambutan, Signature -->
            <div class="w-full md:w-2/3 lg:w-3/4 p-6 flex flex-col justify-between">
                <!-- Bagian Atas: Judul & Isi Sambutan -->
                <div>
                    <!-- Judul -->
                    <h1 class="text-3xl md:text-4xl font-bold mb-6 text-center md:text-left">
                        Sambutan Kepala Puskesmas
                    </h1>

                    <!-- Isi Sambutan (render HTML langsung) -->
                    <div class="prose prose-lg dark:prose-invert leading-relaxed">
                        <?= $sambutan['isi_sambutan']; ?>
                    </div>
                </div>

                <!-- Bagian Bawah: Signature -->
                <div class="mt-8 text-right">
                    <span class="block text-lg font-semibold">
                        — <?= esc($sambutan['nama_kepala']); ?>
                    </span>
                </div>
            </div>

        </div>
    </div>
</section>
<?= $this->endSection(); ?>


<?= $this->section('pageScript') ?>

<?= $this->endSection() ?>