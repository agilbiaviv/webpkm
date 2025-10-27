<!-- views/frontend/components/breadcrumb.php -->
<nav class="mb-8 text-gray-600 dark:text-gray-300 px-4 max-w-5xl mx-auto" aria-label="Breadcrumb">
    <div class="flex justify-between bg-white dark:bg-gray-800 py-6 px-4 rounded-md">

        <ol class="list-reset flex">
            <li><a href="<?= base_url() ?>" class="hover:underline text-orange-600">Beranda</a></li>
            <?php if (!empty($breadcrumbs)): ?>
                <?php foreach ($breadcrumbs as $i => $crumb): ?>
                    <li class="mx-2">/</li>
                    <?php if ($i === array_key_last($breadcrumbs)): ?>
                        <li class="font-semibold text-gray-800 dark:text-gray-100"><?= esc($crumb['label']) ?></li>
                    <?php else: ?>
                        <li><a href="<?= $crumb['url'] ?>" class="text-orange-600 hover:underline"><?= esc($crumb['label']) ?></a></li>
                    <?php endif; ?>
                <?php endforeach ?>
            <?php endif ?>
        </ol>
    </div>

</nav>