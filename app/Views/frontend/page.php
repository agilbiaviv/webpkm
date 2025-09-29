<?= $this->extend('frontend/template'); ?>

<?= $this->section('pageStyle') ?>

<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<section class="py-10">
    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row items-stretch" data-aos="fade-up">

            <!-- Kolom Kiri: Gambar Halaman (opsional) -->
            <?php if (!empty($page['image'])): ?>
                <div class="w-full md:w-1/3 lg:w-1/4 p-6 flex justify-center items-center">
                    <div class="w-48 h-64 rounded-xl overflow-hidden shadow-md">
                        <img
                            src="<?= base_url('uploads/pages/' . $page['image']); ?>"
                            alt="<?= esc($page['title']); ?>"
                            class="object-cover w-full h-full transition-transform duration-300 hover:scale-105" />
                    </div>
                </div>
            <?php endif; ?>

            <!-- Kolom Kanan: Judul & Konten -->
            <div class="w-full <?= empty($page['image']) ? 'md:w-full' : 'md:w-2/3 lg:w-3/4' ?> p-6 flex flex-col justify-between">

                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-6 text-center md:text-left">
                        <?= esc($page['title']); ?>
                    </h1>

                    <div class="prose prose-lg dark:prose-invert leading-relaxed">
                        <?= $page['content']; // HTML siap pakai 
                        ?>
                    </div>
                </div>

                <?php if (!empty($page['author'])): ?>
                    <div class="mt-8 text-right">
                        <span class="block text-lg font-semibold">
                            — <?= esc($page['author']); ?>
                        </span>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>



<?= $this->section('pageScript') ?>

<?= $this->endSection() ?>