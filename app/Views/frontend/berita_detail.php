<?= $this->extend('frontend/template'); ?>

<?= $this->section('pageStyle') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-4"><?= esc($berita['judul_berita']) ?></h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-3 flex-wrap">
        <span>Diposting pada <?= dateFormat($berita['tanggal_berita']) ?> |</span>

        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-500 text-white">
            <svg class="w-4 h-4 mr-1 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <?= $berita['view_count'] + 1 ?>
        </span>
    </p>

    <?php if (!empty($berita['foto'])): ?>
        <img src="<?= base_url('uploads/berita/' . $berita['foto']) ?>" class="w-full mb-2 rounded-lg" alt="<?= esc($berita['judul_berita']) ?>">
        <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-4"><?= esc($berita['caption_foto']) ?></p>
    <?php endif; ?>


    <div class="prose max-w-none">
        <?= $berita['deskripsi'] ?>
    </div>
</div>

<?php if (!empty($recommended)): ?>
    <div class="max-w-3xl mx-auto mt-10 px-4">
        <h2 class="text-xl font-semibold mb-4">Berita Terkait</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <?php foreach ($recommended as $item): ?>
                <a href="<?= base_url('berita/' . $item['slug']) ?>" class="block bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow hover:shadow-md transition text-orange-500 dark:text-orange-400 hover:text-orange-600">
                    <?php if (!empty($item['foto'])): ?>
                        <img src="<?= base_url('uploads/berita/' . $item['foto']) ?>" alt="<?= esc($item['judul_berita']) ?>" class="w-full h-40 object-cover">
                    <?php endif; ?>
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2"><?= esc($item['judul_berita']) ?></h3>
                        <p class="text-sm text-gray-500"><?= date('d M Y', strtotime($item['created_at'])) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>


<?= $this->endSection() ?>

<?= $this->section('pageScript') ?>

<?= $this->endSection() ?>