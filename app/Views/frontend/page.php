<?= $this->extend('frontend/template'); ?>

<?= $this->section('pageStyle') ?>

<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<section class="py-10">
    <?= view('frontend/components/breadcrumb', ['breadcrumbs' => $breadcrumbs ?? []]); ?>
    <div class="max-w-5xl mx-auto px-4">
        <div class="overflow-hidden flex flex-col md:flex-row items-stretch gap-4" data-aos="fade-up">

            <!-- Kolom Kiri: Gambar Halaman (opsional) -->
            <?php if (!empty($page['image'])): ?>
                <div class="w-full md:w-1/3 p-6 bg-gray-50 dark:bg-gray-800 rounded-md shadow-md flex justify-center items-baseline">
                    <div class="w-48 h-64 rounded-xl overflow-hidden shadow-md">
                        <img
                            src="<?= base_url('uploads/pages/' . $page['image']); ?>"
                            alt="<?= esc($page['title']); ?>"
                            class="object-cover w-full h-full transition-transform duration-300 hover:scale-105" />
                    </div>
                </div>
            <?php endif; ?>

            <!-- Kolom Kanan: Judul & Konten -->
            <div class="w-full <?= empty($page['image']) ? 'md:w-full' : 'md:w-2/3' ?> flex flex-col justify-between bg-gray-50 dark:bg-gray-800 rounded-md shadow-md">

                <div class="p-6">
                    <h1 class="text-3xl md:text-4xl font-bold mb-6 text-center">
                        <?= esc($page['title']); ?>
                    </h1>

                    <div class="prose prose-lg dark:prose-invert leading-relaxed p-6">
                        <?= $page['content']; // HTML siap pakai 
                        ?>
                    </div>
                </div>

                <div class="w-full p-6 bg-white">
                    <p class="text-right text-sm">
                        Last updated <?= date('d M Y H:i:s', strtotime($page['updated_at'])) ?>
                    </p>
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