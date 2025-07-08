<footer class="bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 py-12 border-t border-gray-300 dark:border-gray-700 mt-10">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 text-sm">

        <!-- Alamat dan Kontak -->
        <div>
            <h2 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">
                <?= esc($footer['nama_instansi'] ?? 'Puskesmas') ?>
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mb-2"><?= $footer['alamat'] ?? '-' ?></p>

            <div class="mt-4 space-y-1 text-sm">
                <?php if (!empty($footer['telepon'])): ?>
                    <p>
                        <i data-lucide="phone" class="inline-block w-4 h-4 mr-2 text-gray-500 dark:text-gray-300"></i>
                        <a href="tel:<?= preg_replace('/\D/', '', $footer['telepon']); ?>" target="_blank" class="hover:underline text-orange-500">Telp: <?= esc($footer['telepon']) ?> </a>
                    </p>
                <?php endif; ?>

                <?php if (!empty($footer['whatsapp'])): ?>
                    <p>
                        <i data-lucide="message-circle" class="inline-block w-4 h-4 mr-2 text-green-500"></i>
                        <a href="https://wa.me/<?= preg_replace('/^0/', '+62', preg_replace('/\D/', '', $footer['whatsapp'])); ?>"
                            target="_blank" class="hover:underline text-orange-500">
                            WhatsApp: <?= esc($footer['whatsapp']) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if (!empty($footer['email'])): ?>
                    <p>
                        <i data-lucide="mail" class="inline-block w-4 h-4 mr-2 text-gray-500 dark:text-gray-300"></i>
                        <a href="mailto:<?= esc($footer['email']) ?>" class="hover:underline text-orange-500">
                            <?= esc($footer['email']) ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Media Sosial -->
        <div>
            <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white">Media Sosial</h3>
            <ul class="space-y-2">
                <?php if (!empty($footer['facebook'])): ?>
                    <li>
                        <a href="<?= esc($footer['facebook']) ?>" target="_blank"
                            class="flex items-center gap-2 hover:underline">
                            <i data-lucide="facebook" class="w-4 h-4 text-blue-600"></i> Facebook
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($footer['instagram'])): ?>
                    <li>
                        <a href="<?= esc($footer['instagram']) ?>" target="_blank"
                            class="flex items-center gap-2 hover:underline">
                            <i data-lucide="instagram" class="w-4 h-4 text-pink-500"></i> Instagram
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($footer['tiktok'])): ?>
                    <li>
                        <a href="<?= esc($footer['tiktok']) ?>" target="_blank"
                            class="flex items-center gap-2 hover:underline">
                            <svg class="w-4 h-4 fill-black dark:fill-white" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M448,209.8V150c-31.5,0-63-10.2-87.8-29.3C336,99,320,71.5,320,42.7h-58.5v288.2c0,23.3-9.5,45.5-26.3,62.2-16.8,16.8-39,26.3-62.2,26.3s-45.5-9.5-62.2-26.3c-16.8-16.8-26.3-39-26.3-62.2s9.5-45.5,26.3-62.2c10.2-10.2,22.8-17.5,36.6-21.4v-59.7c-24.2,4.3-46.6,15.7-64.3,33.4C58.5,225.6,42.7,264.2,42.7,304.7s15.7,79.1,44.1,107.5,66.2,44.1,107.5,44.1,79.1-15.7,107.5-44.1,44.1-66.2,44.1-107.5V218.3c24.8,11.3,56.3,17.5,87.8,17.5Z" />
                            </svg> TikTok
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($footer['youtube'])): ?>
                    <li>
                        <a href="<?= esc($footer['youtube']) ?>" target="_blank"
                            class="flex items-center gap-2 hover:underline">
                            <i data-lucide="youtube" class="w-4 h-4 text-red-500"></i> YouTube
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Peta Lokasi -->
        <div>
            <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white">Peta Lokasi</h3>
            <?php if (!empty($footer['maps_embed_url'])): ?>
                <div id="map-container" class="w-full h-64 rounded shadow" data-url="<?= esc($footer['maps_embed_url'] ?? '') ?>">
                    <div id="map-placeholder" class="relative w-full h-64 rounded shadow bg-gray-200 dark:bg-gray-800 flex items-center justify-center">
                        <div class="spinner animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-orange-500"></div>
                    </div>
                    <iframe
                        src="<?= esc($footer['maps_embed_url']) ?>"
                        class="w-full h-64 rounded shadow"
                        style="border:0; opacity:0;"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        onload="this.style.opacity=1; this.style.transition='opacity .5s ease-in-out'; document.getElementById('map-placeholder').remove();">
                    </iframe>
                </div>

            <?php else: ?>
                <p class="text-gray-500 italic">Peta belum tersedia</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="text-center mt-10 text-xs text-gray-500 dark:text-gray-400">
        &copy; <?= date('Y') ?> IT <?= esc($footer['nama_instansi'] ?? 'Puskesmas') ?>. All rights reserved.
    </div>
</footer>