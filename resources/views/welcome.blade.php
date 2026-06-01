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
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-catSoft text-catDark antialiased">

    <!-- HEADER -->
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
            <a href="#harga" class="hover:text-catOrange transition">Harga Slot</a>
        </nav>
        <button
            class="bg-catDark text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-opacity-90 transition shadow-sm">
            Hubungi Kami
        </button>
    </header>

    <!-- HERO SECTION -->
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
                <a href="#harga"
                    class="flex items-center justify-center space-x-2 bg-white border-2 border-gray-200 text-catDark px-8 py-4 rounded-2xl font-bold text-base hover:border-catOrange transition">
                    <span>Pilih Paket Harga</span>
                </a>
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

    <!-- PRICING SECTION -->
    <section id="harga" class="bg-white/60 backdrop-blur-md py-20 border-t border-orange-100/60">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span
                    class="text-catOrange bg-orange-100 text-xs font-bold tracking-wider uppercase px-4 py-1.5 rounded-full">
                    Pilihan Paket Terbaik
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold mt-3 tracking-tight">
                    Investasi Terbaik Untuk <span class="text-catOrange">Keamanan Si Meong</span>
                </h2>
                <p class="text-gray-500 mt-3 font-medium">
                    Pilih paket slot sesuai dengan jumlah populasi anabul di rumah Anda. 1 slot berlaku selamanya untuk
                    1 data kucing.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
                @foreach ($packages as $package)
                    <div
                        class="bg-white rounded-3xl p-8 flex flex-col justify-between transition duration-300 hover:shadow-xl hover:-translate-y-1 relative
                        {{ $package->badge ? 'shadow-xl border-2 border-catOrange scale-105 z-10' : 'shadow-md border border-gray-100/80' }}">

                        @if ($package->badge)
                            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">
                                <span
                                    class="bg-gradient-to-r from-catOrange to-amber-500 text-white px-4 py-1 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-wider shadow-sm whitespace-nowrap block">
                                    {{ $package->badge }}
                                </span>
                            </div>
                        @endif

                        <div>
                            <h3 class="font-bold text-xl text-slate-800 {{ $package->badge ? 'mt-2' : '' }}">
                                {{ $package->name }}
                            </h3>

                            <div class="mt-4 flex items-baseline">
                                <span class="text-4xl font-extrabold tracking-tight text-slate-900">
                                    {{ $package->slots }}
                                </span>
                                <span class="text-lg font-semibold text-gray-400 ml-1">Slot Kucing</span>
                            </div>

                            <p class="text-2xl font-extrabold text-catOrange mt-2">
                                Rp{{ number_format($package->price, 0, ',', '.') }}
                            </p>

                            @if ($package->slots > 1)
                                @php
                                    // Asumsi harga dasar per 1 slot adalah Rp30.000
                                    $hargaNormal = $package->slots * 30000;
                                    $totalHemat = $hargaNormal - $package->price;
                                @endphp
                                @if ($totalHemat > 0)
                                    <p
                                        class="text-xs text-emerald-600 font-semibold mt-1 bg-emerald-50 px-2 py-0.5 rounded-md inline-block">
                                        Hemat Rp{{ number_format($totalHemat, 0, ',', '.') }}!
                                    </p>
                                @endif
                            @endif

                            <ul class="mt-8 space-y-4 text-sm text-gray-500">
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
                                    <span>Simpan {{ $package->slots == 1 ? '1' : 'hingga ' . $package->slots }} data
                                        identitas kucing</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
                                    <span>Unduh QR Code siap cetak</span>
                                </li>
                                @if ($package->slots >= 3)
                                    <li class="flex items-center gap-3">
                                        <i data-lucide="check-circle-2"
                                            class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
                                        <span>Prioritas dukungan CS 24/7</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('login', ['package' => $package->id]) }}"
                                class="block w-full text-center py-3.5 px-4 rounded-2xl font-bold transition 
                                {{ $package->badge ? 'bg-gradient-to-r from-catOrange to-amber-500 text-white font-extrabold shadow-md shadow-orange-500/10 hover:opacity-90' : 'bg-catDark hover:bg-opacity-90 text-white' }}">
                                Beli Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-catDark text-white/90 pt-16 pb-8 border-t border-slate-700/50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 text-white">
                        <div class="bg-catOrange p-2 rounded-xl">
                            <i data-lucide="cat" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight">Anabul<span
                                class="text-catOrange">ID</span></span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Memberikan rasa aman ekstra bagi pemilik hewan melalui sistem pelacakan informasi QR Code yang
                        andal dan mudah diakses.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-base text-white mb-4">Tautan Navigasi</h4>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li><a href="#fitur" class="hover:text-catOrange transition">Fitur Layanan</a></li>
                        <li><a href="#cara-kerja" class="hover:text-catOrange transition">Cara Kerja Sistem</a></li>
                        <li><a href="#harga" class="hover:text-catOrange transition">Pricings & Slot</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-base text-white mb-4">Kontak & Support</h4>
                    <ul class="space-y-2.5 text-sm text-gray-400">
                        <li class="flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4 text-catOrange"></i>
                            syalpratamaa@gmail.com</li>
                        <li class="flex items-center gap-2"><i data-lucide="phone"
                                class="w-4 h-4 text-catOrange"></i> +62 838-4488-2339</li>
                        <li class="flex items-center gap-2"><i data-lucide="map-pin"
                                class="w-4 h-4 text-catOrange"></i> Majalengka, Indonesia</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-base text-white mb-4">Media Sosial</h4>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="p-2.5 bg-slate-700/50 hover:bg-catOrange text-white rounded-xl transition"><i
                                data-lucide="instagram" class="w-5 h-5"></i></a>
                        <a href="#"
                            class="p-2.5 bg-slate-700/50 hover:bg-catOrange text-white rounded-xl transition"><i
                                data-lucide="twitter" class="w-5 h-5"></i></a>
                        <a href="#"
                            class="p-2.5 bg-slate-700/50 hover:bg-catOrange text-white rounded-xl transition"><i
                                data-lucide="facebook" class="w-5 h-5"></i></a>
                    </div>
                </div>
            </div>

            <div
                class="border-t border-slate-700/50 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-400 gap-4">
                <p>&copy; 2026 AnabulID. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
