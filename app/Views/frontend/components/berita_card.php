<article class="h-full bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden flex flex-col animate-fade-in" data-aos="fade-up" data-aos-delay="100">
    <?php if (!empty($item['foto'])): ?>
        <img src="<?= base_url('uploads/berita/' . $item['foto']) ?>" alt="<?= character_limiter(esc(strip_tags($item['judul_berita'])), 10) ?>" class="w-full h-48 object-cover">
    <?php endif; ?>
    <div class="p-4 flex flex-col flex-1">
        <small class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-3 flex-wrap">
            <span>Tanggal : <?= dateFormat($item['tanggal_berita']) ?></span>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-500 text-white">
                <svg class="w-4 h-4 mr-1 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <?= $item['view_count'] + 1 ?>
            </span>
        </small>
        <a href="<?= base_url('berita/' . $item['slug']) ?>" class="font-semibold text-xl mb-2 text-orange-500 dark:text-orange-400 hover:text-orange-600 min-h-[64px] line-clamp-3">
            <?= esc(character_limiter(strip_tags($item['judul_berita']), 120)) ?>
        </a>
        <p class="text-gray-700 dark:text-gray-300 flex-grow line-clamp-3">
            <?= character_limiter(strip_tags($item['deskripsi']), 120) ?>
        </p>
        <a href="<?= base_url('berita/' . $item['slug']) ?>" class="mt-4 py-2 w-50 text-center bg-orange-500 inline-block text-white rounded hover:bg-orange-600 transition">
            Baca Selengkapnya
        </a>
    </div>
</article>