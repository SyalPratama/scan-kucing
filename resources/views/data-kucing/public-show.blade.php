<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kucing - {{ $kucing->nama_kucing }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100 min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden">

    <div class="absolute top-10 -left-10 text-orange-200/40 transform -rotate-12 pointer-events-none hidden sm:block">
        <i class="fa-solid fa-paw text-9xl"></i>
    </div>
    <div class="absolute bottom-10 -right-10 text-amber-200/40 transform rotate-12 pointer-events-none hidden sm:block">
        <i class="fa-solid fa-cat text-9xl"></i>
    </div>

    <div
        class="max-w-md w-full bg-white/90 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white/60 overflow-hidden transform transition duration-300 hover:shadow-2xl">

        <div class="relative h-72 bg-gradient-to-b from-gray-200 to-gray-300 overflow-hidden group">
            @if ($kucing->foto)
                <img src="{{ asset($kucing->foto) }}"
                    class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-orange-300 bg-orange-900/10">
                    <i class="fa-solid fa-cat text-7xl animate-bounce mb-3"></i>
                    <span class="text-xs font-bold tracking-widest uppercase text-orange-800/60">Foto Belum
                        Diunggah</span>
                </div>
            @endif

            <div
                class="absolute top-5 left-5 bg-white/90 backdrop-blur-md text-orange-600 text-xs font-extrabold px-3.5 py-2 rounded-full shadow-md border border-orange-100 flex items-center gap-1.5">
                <span class="flex h-2 w-2 relative">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                </span>
                <i class="fa-solid fa-qrcode"></i> ID KUCING TERVERIFIKASI
            </div>
        </div>

        <div class="p-6 -mt-8 relative bg-white rounded-t-[2.5rem] border-t border-gray-50">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight flex items-center gap-2">
                        {{ $kucing->nama_kucing }}
                        <i class="fa-solid fa-paw text-orange-400 text-xl"></i>
                    </h1>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">Halo! Kenali profil lengkap saya di bawah ini.
                    </p>
                </div>

                <span
                    class="px-4 py-2 rounded-2xl text-xs font-black tracking-wide uppercase flex items-center gap-1.5 shadow-xs {{ $kucing->jenis_kelamin == 'jantan' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-pink-50 text-pink-600 border border-pink-100' }}">
                    <i
                        class="fa-solid {{ $kucing->jenis_kelamin == 'jantan' ? 'fa-mars text-sm' : 'fa-venus text-sm' }}"></i>
                    {{ $kucing->jenis_kelamin ?? 'Misteri' }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-6">
                <div class="bg-gray-50/80 p-3.5 rounded-2xl border border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600">
                        <i class="fa-solid fa-dna"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Ras</span>
                        <span
                            class="text-sm text-gray-700 font-bold truncate block max-w-[120px]">{{ $kucing->ras ?? 'Domestic' }}</span>
                    </div>
                </div>

                <div class="bg-gray-50/80 p-3.5 rounded-2xl border border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                        <i class="fa-solid fa-cake-candles"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Usia</span>
                        <span class="text-sm text-gray-700 font-bold block">{{ $kucing->umur ?? '?' }} Bulan</span>
                    </div>
                </div>

                <div class="bg-gray-50/80 p-3.5 rounded-2xl border border-gray-100 flex items-center gap-3 col-span-2">
                    <div
                        class="w-9 h-9 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Warna
                            Bulu</span>
                        <span class="text-sm text-gray-700 font-bold">{{ $kucing->warna ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block mb-1.5 px-1">
                    <i class="fa-solid fa-star text-orange-400 mr-1"></i> Ciri Khusus & Sifat
                </span>
                <div
                    class="bg-orange-50/60 text-orange-900 text-sm p-4 rounded-2xl font-medium border border-orange-100/50 leading-relaxed">
                    {{ $kucing->ciri_khusus ?? 'Kucing ini ramah, bersahabat, dan tidak memiliki ciri khusus yang spesifik.' }}
                </div>
            </div>

            <div
                class="bg-gradient-to-r from-gray-900 to-slate-800 text-white p-5 rounded-[2rem] shadow-lg relative overflow-hidden mb-2">
                <div class="absolute -right-6 -bottom-6 text-white/5 pointer-events-none transform rotate-45">
                    <i class="fa-solid fa-paw text-8xl"></i>
                </div>

                <h3 class="text-sm font-extrabold tracking-wide uppercase mb-3 text-amber-400 flex items-center gap-2">
                    <i class="fa-solid fa-address-card"></i> Kontak Pemilik Darurat
                </h3>

                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-amber-300 mt-1"></i>
                        <div>
                            <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Alamat
                                Rumah</span>
                            <p class="text-sm text-gray-200 font-medium leading-normal">
                                {{ $kucing->alamat_pemilik ?? 'Alamat rumah pemilik dilindungi atau tidak dicantumkan.' }}
                            </p>
                        </div>
                    </div>

                    @if ($kucing->nomor_hp)
                        <div class="flex items-start gap-3 pt-2.5 border-t border-white/10">
                            <i class="fa-solid fa-phone text-amber-300 mt-1"></i>
                            <div>
                                <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Nomor
                                    Kontak aktif</span>
                                <p class="text-sm text-white font-black tracking-widest">{{ $kucing->nomor_hp }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if ($kucing->nomor_hp)
                @php
                    $phoneFormat = preg_replace('/[^0-9]/', '', $kucing->nomor_hp);
                    if (str_starts_with($phoneFormat, '0')) {
                        $phoneFormat = '62' . substr($phoneFormat, 1);
                    }
                    $waMessage = urlencode(
                        'Halo, saya menemukan kucing Anda yang bernama ' .
                            $kucing->nama_kucing .
                            '. Saya berhasil melacak data pemilik melalui pemindaian alat QR Code terintegrasi pada kalung kucing.',
                    );
                @endphp
                <a href="https://wa.me/{{ $phoneFormat }}?text={{ $waMessage }}" target="_blank"
                    class="mt-5 w-full flex items-center justify-center gap-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-extrabold py-4 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-200 text-center transform hover:-translate-y-0.5 group no-underline">
                    <i class="fa-brands fa-whatsapp text-xl group-hover:scale-110 transition duration-200"></i>
                    Hubungi Pemilik Sekarang
                </a>
            @endif
        </div>
    </div>

</body>

</html>
