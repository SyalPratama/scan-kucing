@extends('layouts.client')

@section('title', 'Pembelian Slot Kucing - AnabulID')

@section('content')
    <!-- Top Bar Info -->
    <div
        class="bg-white/80 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-sm border border-orange-100/50 mb-8 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-orange-200/30 rounded-full blur-2xl"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1
                    class="text-2xl md:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent">
                    Pembelian Slot Kucing
                </h1>
                <p class="text-slate-500 mt-1 text-sm md:text-base font-medium">
                    Tingkatkan kapasitas penyimpanan data anak bulu Anda secara instan.
                </p>
            </div>
            <div
                class="bg-orange-100/80 text-orange-800 px-4 py-2.5 rounded-2xl text-xs md:text-sm font-semibold border border-orange-200/40 self-start sm:self-auto flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-circle-info text-orange-600"></i>
                1 Slot = 1 Data Kucing
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Transaksi -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-bold text-lg md:text-xl text-slate-900">
                Riwayat Transaksi
            </h2>
            <span
                class="text-[10px] md:text-xs font-semibold bg-slate-100 text-slate-600 px-3 py-1 rounded-full flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Real-time
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50/70 text-slate-500 uppercase text-[10px] md:text-xs font-bold tracking-wider border-b border-slate-100">
                        <th class="py-4 px-5 sm:px-6">Order ID</th>
                        <th class="py-4 px-5">Jumlah</th>
                        <th class="py-4 px-5">Status</th>
                        <th class="py-4 px-5 sm:px-6">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-xs md:text-sm text-slate-600">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <td class="py-4 px-5 sm:px-6 font-mono font-medium text-slate-900 whitespace-nowrap">
                                #{{ $payment->order_id }}
                            </td>
                            <td class="py-4 px-5 font-semibold text-slate-900 whitespace-nowrap">
                                Rp{{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-5 whitespace-nowrap">
                                @if ($payment->status == 'paid')
                                    <span
                                        class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-[10px] md:text-xs font-semibold border border-emerald-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lunas
                                    </span>
                                @elseif($payment->status == 'pending')
                                    <span
                                        class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full text-[10px] md:text-xs font-semibold border border-amber-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 px-2.5 py-1 rounded-full text-[10px] md:text-xs font-semibold border border-rose-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Gagal
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 sm:px-6 text-slate-400 whitespace-nowrap">
                                {{ $payment->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-box-open text-3xl text-slate-300"></i>
                                    <p class="font-medium text-sm">Belum ada riwayat transaksi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($payments->hasPages())
            <div class="p-4 sm:p-6 border-t border-slate-100 bg-slate-50/50">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#FF9F43',
                customClass: {
                    popup: 'custom-swal-popup'
                }
            });
        </script>
    @endif
@endsection
