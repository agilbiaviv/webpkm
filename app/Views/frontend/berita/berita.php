<?= $this->extend('frontend/template'); ?>

<?= $this->section('pageStyle') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-6">Berita</h1>

    <!-- Filter Form -->
    <form id="filter-form" class="mb-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end">
        <!-- Search -->
        <div class="flex flex-col">
            <label for="search-input" class="text-sm font-medium text-gray-700 dark:text-gray-100">Cari Berita</label>
            <input
                type="text"
                name="q"
                id="search-input"
                placeholder="Judul atau deskripsi..."
                value="<?= esc($keyword) ?>"
                class="mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 text-sm
                   bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400">
        </div>

        <!-- Bulan -->
        <div class="flex flex-col">
            <label for="month-filter" class="text-sm font-medium text-gray-700 dark:text-gray-100">Bulan</label>
            <select
                name="month"
                id="month-filter"
                class="mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 text-sm
                   bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                <option value="">Semua Bulan</option>
                <?php
                $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                for ($m = 0; $m <= 11; $m++): ?>
                    <option value="<?= $m + 1 ?>"><?= $bulan[$m] ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- Tahun -->
        <div class="flex flex-col">
            <label for="year-filter" class="text-sm font-medium text-gray-700 dark:text-gray-100">Tahun</label>
            <select
                name="year"
                id="year-filter"
                class="mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 text-sm
                   bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                <option value="">Semua Tahun</option>
                <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                    <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- Tombol Filter -->
        <div class="flex gap-2">
            <button
                type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm transition">Filter</button>
            <button
                type="button"
                id="reset-button"
                class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-4 py-2 rounded-md text-sm transition">Reset</button>
        </div>
    </form>


    <!-- Grouped List -->
    <div id="berita-list">
        <?php foreach ($beritaGrouped as $group => $items): ?>
            <h2 class="text-xl font-semibold mt-10 mb-4"><?= $group ?></h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($items as $item): ?>
                    <?= view('frontend/components/berita_card', ['item' => $item]) ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Skeleton Loader -->
    <div id="berita-skeletons" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <?php for ($i = 0; $i < 3; $i++): ?>
            <?= view('frontend/components/berita_card_skeleton') ?>
        <?php endfor; ?>
    </div>

    <!-- End of Content Message -->
    <div id="berita-end" class="text-center text-gray-500 mt-10 hidden">
        Tidak ada lagi berita untuk ditampilkan.
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('pageScript') ?>
<script>
    const filterForm = document.getElementById('filter-form');
    const beritaList = document.getElementById('berita-list');
    const skeletons = document.getElementById('berita-skeletons');
    const beritaEnd = document.getElementById('berita-end');

    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;
    let searchParams = new URLSearchParams();

    async function fetchBerita(reset = true) {
        if (isLoading) return;
        isLoading = true;

        if (reset) {
            currentPage = 1;
            beritaList.innerHTML = '';
            beritaEnd.classList.add('hidden');
        }

        skeletons.classList.remove('hidden');
        searchParams.set('page', currentPage);

        try {
            const res = await fetch(`<?= base_url('/berita/loadMore'); ?>?${searchParams.toString()}`);
            const data = await res.json();

            if (data.success) {
                const grouped = data.groupedHtml;

                // If it's reset and no results at all
                if (Object.keys(grouped).length === 0 && reset) {
                    beritaList.innerHTML = '<p class="text-gray-500">Tidak ada berita ditemukan.</p>';
                    hasMore = false;
                    beritaEnd.classList.add('hidden'); // no need to show "end" msg
                } else {
                    // If there are grouped items
                    for (const group in grouped) {
                        const groupId = `group-${group.replace(/\s+/g, '-')}`;

                        let groupSection = document.getElementById(groupId);
                        if (!groupSection) {
                            const heading = document.createElement('h2');
                            heading.className = 'text-xl font-semibold mt-10 mb-4';
                            heading.textContent = group;

                            const wrapper = document.createElement('div');
                            wrapper.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6';
                            wrapper.id = groupId;

                            beritaList.appendChild(heading);
                            beritaList.appendChild(wrapper);
                            groupSection = wrapper;
                        }

                        grouped[group].forEach(html => {
                            const temp = document.createElement('div');
                            temp.innerHTML = html;
                            const card = temp.firstElementChild;
                            if (card) groupSection.appendChild(card);
                        });
                    }

                    hasMore = data.hasMore;

                    // ✅ Always show this if we're on a loadMore that has no further pages
                    if (!hasMore) {
                        beritaEnd.classList.remove('hidden');
                    }
                }

            } else {
                hasMore = false;
                if (reset) {
                    beritaList.innerHTML = '<p class="text-gray-500">Tidak ada berita ditemukan.</p>';
                    beritaEnd.classList.add('hidden');
                } else {
                    beritaEnd.classList.remove('hidden'); // fallback
                }
            }

        } catch (error) {
            console.error("Error loading berita:", error);
        }

        skeletons.classList.add('hidden');
        isLoading = false;
    }


    filterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const keyword = document.getElementById('search-input').value;
        const month = document.getElementById('month-filter').value;
        const year = document.getElementById('year-filter').value;

        searchParams.set('search', keyword);
        searchParams.set('month', month);
        searchParams.set('year', year);

        hasMore = true;
        fetchBerita(true);
    });

    document.getElementById('reset-button').addEventListener('click', () => {
        document.getElementById('search-input').value = '';
        document.getElementById('month-filter').value = '';
        document.getElementById('year-filter').value = '';

        searchParams.delete('search');
        searchParams.delete('month');
        searchParams.delete('year');

        hasMore = true;
        fetchBerita(true);
    });

    window.addEventListener('scroll', () => {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 300) {
            if (hasMore && !isLoading) {
                currentPage++;
                fetchBerita(false);
            }
        }
    });

    fetchBerita(true);
</script>


<?= $this->endSection() ?>