<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnabulID - Scan & Temukan Data Kucing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        catOrange: '#FF9F43',
                        catSoft: '#FFF4EB',
                        catDark: '#2D3748',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-catSoft text-catDark antialiased">

    <header class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <div class="bg-catOrange p-2 rounded-xl text-white">
                <i data-lucide="cat" class="w-6 h-6"></i>
            </div>
            <span class="text-xl font-bold tracking-tight text-catDark">Anabul<span
                    class="text-catOrange">ID</span></span>
        </div>
        <nav class="hidden md:flex space-x-8 font-medium text-sm text-gray-600">
            <a href="#fitur" class="hover:text-catOrange transition">Fitur</a>
            <a href="#cara-kerja" class="hover:text-catOrange transition">Cara Kerja</a>
            <a href="#testimoni" class="hover:text-catOrange transition">Testimoni</a>
        </nav>
        <button
            class="bg-catDark text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-opacity-90 transition shadow-sm">
            Hubungi Kami
        </button>
    </header>

    <main class="container mx-auto px-6 pt-12 pb-24 flex flex-col-reverse lg:flex-row items-center gap-12">
        <div class="w-full lg:w-1/2 space-y-6 text-center lg:text-left">
            <div
                class="inline-flex items-center space-x-2 bg-orange-100 text-catOrange px-4 py-1.5 rounded-full text-xs font-semibold">
                <span>🐾 Menjaga Kucing Tetap Aman</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                Identitas Digital untuk <span class="text-catOrange relative inline-block">Kucing Kesayanganmu</span>
            </h1>
            <p class="text-gray-600 text-base md:text-lg max-w-xl mx-auto lg:mx-0">
                Khawatir anabul hilang? Cukup pasang kalung QR Code, dan siapa pun yang menemukannya bisa langsung scan
                untuk melihat data medis, pemilik, dan kontak darurat.
            </p>

            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 pt-2">
                <button
                    class="flex items-center justify-center space-x-2 bg-catOrange text-white px-8 py-4 rounded-2xl font-bold text-base hover:bg-amber-600 transition shadow-lg shadow-orange-500/20 group">
                    <i data-lucide="qr-code" class="w-5 h-5 group-hover:scale-110 transition"></i>
                    <span>Coba Demo Scan</span>
                </button>
                <button
                    class="flex items-center justify-center space-x-2 bg-white border-2 border-gray-200 text-catDark px-8 py-4 rounded-2xl font-bold text-base hover:border-catOrange transition">
                    <span>Daftarkan Kucing</span>
                </button>
            </div>

            <div class="grid grid-cols-3 gap-4 pt-8 border-t border-orange-200/50 max-w-md mx-auto lg:mx-0">
                <div>
                    <p class="text-2xl font-bold text-catDark">10k+</p>
                    <p class="text-xs text-gray-500">Kucing Terdaftar</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-catDark">98%</p>
                    <p class="text-xs text-gray-500">Kembali Aman</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-catDark">24/7</p>
                    <p class="text-xs text-gray-500">Akses Data</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex justify-center relative">
            <div class="absolute w-72 h-72 md:w-96 md:h-96 bg-orange-200 rounded-full blur-3xl opacity-60 top-10 -z-10">
            </div>

            <div
                class="bg-white rounded-3xl p-6 shadow-2xl border border-gray-100 max-w-sm w-full relative transform hover:rotate-1 transition duration-300">
                <div class="relative rounded-2xl overflow-hidden h-64 bg-gray-100 mb-4">
                    <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&q=80&w=600"
                        alt="Mochi si Kucing" class="w-full h-full object-cover">
                    <span
                        class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span> Terlindungi
                    </span>
                </div>

                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-catDark">Mochi</h3>
                        <p class="text-sm text-gray-500">Scottish Fold • 2 Tahun</p>
                    </div>
                    <div class="bg-catSoft p-2 rounded-xl border border-orange-100 hover:scale-105 transition duration-200 cursor-pointer"
                        title="Scan Me">
                        <div
                            class="w-12 h-12 flex items-center justify-center bg-white rounded-lg border border-gray-200">
                            <i data-lucide="qr-code" class="w-8 h-8 text-catDark"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-catSoft rounded-xl p-3 space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pemilik:</span>
                        <span class="font-semibold text-catDark">Rian Andriana</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">No. HP:</span>
                        <span class="font-semibold text-catOrange">0812-3456-XXXX</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Ciri Khusus:</span>
                        <span class="font-semibold text-red-500">Ekor Pendek</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
