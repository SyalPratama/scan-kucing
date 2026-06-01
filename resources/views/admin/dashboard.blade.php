@extends('admin.layouts.admin')

@section('title', 'Dashboard Utama - Admin AnabulID')

@section('content')
    <div class="mb-8 bg-white p-6 rounded-3xl border border-orange-100 shadow-sm">
        <h1 class="text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-chart-pie text-catOrange"></i> Ringkasan Sistem
        </h1>
        <p class="text-sm text-gray-500 mt-1">Selamat datang kembali! Berikut adalah statistik data platform AnabulID saat
            ini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <div
            class="bg-white p-6 rounded-3xl border border-orange-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div class="space-y-1">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Client</p>
                <h3 class="text-3xl font-extrabold text-catDark">{{ $totalClient }}</h3>
                <p class="text-xs text-gray-500 font-medium">Pengguna terdaftar</p>
            </div>
            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-catOrange text-2xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-3xl border border-orange-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div class="space-y-1">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Reseller</p>
                <h3 class="text-3xl font-extrabold text-catDark">{{ $totalReseller }}</h3>
                <p class="text-xs text-gray-500 font-medium">Mitra penjualan</p>
            </div>
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 text-2xl">
                <i class="fa-solid fa-store"></i>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-3xl border border-orange-100 shadow-sm flex items-center justify-between hover:shadow-md transition sm:col-span-2 lg:col-span-1">
            <div class="space-y-1">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kucing (Anabul)</p>
                <h3 class="text-3xl font-extrabold text-catDark">{{ $totalKucing }}</h3>
                <p class="text-xs text-gray-500 font-medium">Terbantu & terlindungi</p>
            </div>
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 text-2xl">
                <i class="fa-solid fa-cat"></i>
            </div>
        </div>

    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <h4 class="font-bold text-base mb-2 flex items-center gap-2">
                <i class="fa-solid fa-bolt text-catOrange"></i> Akses Cepat
            </h4>
            <div class="grid grid-cols-2 gap-3 mt-4">
                <a href="/admin/data-user"
                    class="p-3 bg-gray-50 hover:bg-orange-50/50 rounded-2xl border border-gray-100 text-sm font-medium transition text-center block">
                    Kelola User
                </a>
                <a href="/admin/data-kucing"
                    class="p-3 bg-gray-50 hover:bg-orange-50/50 rounded-2xl border border-gray-100 text-sm font-medium transition text-center block">
                    Lihat Semua Kucing
                </a>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-center items-center text-center p-8">
            <div class="w-12 h-12 bg-orange-50 text-catOrange rounded-full flex items-center justify-center mb-3">
                <i class="fa-solid fa-shield-cat text-lg"></i>
            </div>
            <h4 class="font-bold text-sm">Sistem QR-Code Berjalan Normal</h4>
            <p class="text-xs text-gray-400 mt-1 max-w-xs">Seluruh modul pelacakan data anabul berfungsi optimal tanpa
                kendala server.</p>
        </div>
    </div>
@endsection
