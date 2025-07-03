<!DOCTYPE html>
<html class="h-full" lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Situs Sedang Maintenance</title>
    <link rel="stylesheet" href="/css/main.css" />
</head>

<body class="min-h-screen flex items-center justify-center px-6 bg-gradient-to-br from-orange-200 via-orange-50 to-orange-100">

    <div class="text-center max-w-xl p-6 bg-white/60 backdrop-blur-sm rounded-2xl shadow-xl border border-orange-200 animate-fade-in">
        <!-- Icon -->
        <div class="mb-6 flex justify-center animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
        </div>

        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-3">Website Sedang Dalam Maintenance</h1>
        <p class="text-gray-600 text-base leading-relaxed">
            Kami sedang melakukan peningkatan sistem agar pengalaman Anda menjadi lebih baik.
            Terima kasih atas pengertiannya.
        </p>

        <div class="mt-6 text-sm text-gray-700 font-medium">
            Halaman akan otomatis direfresh setelah maintenance selesai.
        </div>

        <!-- Status Checker -->
        <div class="mt-4 flex justify-center items-center space-x-1 text-sm text-gray-500">
            <span>Mengecek status maintenance </span>
            <span class="flex space-x-1">
                <span class="w-1.5 h-1.5 bg-gray-500 rounded-full animate-bounce [animation-delay:0ms]"></span>
                <span class="w-1.5 h-1.5 bg-gray-500 rounded-full animate-bounce [animation-delay:200ms]"></span>
                <span class="w-1.5 h-1.5 bg-gray-500 rounded-full animate-bounce [animation-delay:400ms]"></span>
            </span>
        </div>

        <div class="mt-10 text-xs text-gray-400">
            &copy; <?= date('Y') ?> Puskesmas. All rights reserved.
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out both;
        }
    </style>

    <script>
        async function checkMaintenanceStatus() {
            try {
                const res = await fetch('/maintenance-status');
                const data = await res.json();
                if (data.maintenance === false || data.maintenance === 'false') {
                    window.location.reload();
                }
            } catch (e) {
                console.error("Gagal cek status maintenance:", e);
            }
        }

        setInterval(checkMaintenanceStatus, 5000);
    </script>
</body>

</html>