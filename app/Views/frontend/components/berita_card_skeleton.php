<?php for ($i = 0; $i < 3; $i++): ?>
    <div class="animate-pulse bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden flex flex-col">
        <div class="bg-gray-300 dark:bg-gray-700 h-48 w-full"></div>
        <div class="p-4 space-y-3 flex flex-col flex-1">
            <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-1/2"></div>
            <div class="h-5 bg-gray-300 dark:bg-gray-600 rounded w-3/4"></div>
            <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-full"></div>
            <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-5/6"></div>
            <div class="h-8 bg-orange-400 dark:bg-orange-500 rounded w-32 mt-4"></div>
        </div>
    </div>
<?php endfor; ?>