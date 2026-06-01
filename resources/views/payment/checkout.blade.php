@extends('layouts.client')

@section('title', 'Form Pembayaran - AnabulID')

@section('content')
    <div class="container mx-auto max-w-5xl px-4 py-6">
        <div class="mb-6">
            <a href="{{ route('client.payment.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-catOrange transition mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
            </a>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Formulir Pembayaran</h1>
            <p class="text-slate-500 text-sm">Silakan pilih paket slot dan selesaikan pembayaran Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <div class="lg:col-span-2 space-y-6">

                <form action="{{ route('client.payment.create') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="">

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center gap-3 mb-4 border-b border-slate-100 pb-3">
                            <span
                                class="w-7 h-7 rounded-full bg-orange-100 text-catOrange flex items-center justify-center font-bold text-sm">1</span>
                            <h2 class="font-bold text-lg text-slate-900">Informasi Paket & Pelanggan</h2>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih
                                    Paket Slot Kucing *</label>
                                <div class="relative">
                                    <select name="package_id" id="packageSelect" onchange="updateSummary()" required
                                        class="w-full px-4 py-3.5 rounded-xl bg-white border border-slate-200 text-slate-800 text-sm font-semibold focus:border-catOrange focus:ring-1 focus:ring-catOrange focus:outline-none appearance-none transition cursor-pointer">
                                        <option value="" data-price="0" data-slots="0" disabled selected>-- Pilih
                                            Paket Kebutuhan Anda --</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}" data-price="{{ $package->price }}"
                                                data-slots="{{ $package->slots }}">
                                                {{ $package->name }} ({{ $package->slots }} Slot) -
                                                Rp{{ number_format($package->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama
                                        Lengkap</label>
                                    <input type="text" value="{{ Auth::user()->name }}" disabled
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 text-sm focus:outline-none">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat
                                        Email</label>
                                    <input type="email" value="{{ Auth::user()->email }}" disabled
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 text-sm focus:outline-none">
                                </div>
                                <div class="sm:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor
                                        WhatsApp (Untuk Notifikasi)</label>
                                    <input type="tel" name="phone_number" required placeholder="Contoh: 08123456789"
                                        class="w-full px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-800 text-sm focus:border-catOrange focus:ring-1 focus:ring-catOrange focus:outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mt-6">
                        <div class="flex items-center gap-3 mb-4 border-b border-slate-100 pb-3">
                            <span
                                class="w-7 h-7 rounded-full bg-orange-100 text-catOrange flex items-center justify-center font-bold text-sm">2</span>
                            <h2 class="font-bold text-lg text-slate-900">Pilih Metode Pembayaran</h2>
                        </div>

                        <div class="mb-6">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Transfer
                                Virtual Account</span>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div onclick="selectMethod('va_bca')" id="method_va_bca"
                                    class="payment-card border border-slate-200 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-catOrange transition bg-white relative">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                                        alt="BCA" class="h-6 object-contain">
                                    <span class="text-xs font-semibold text-slate-600">BCA VA</span>
                                </div>
                                <div onclick="selectMethod('va_mandiri')" id="method_va_mandiri"
                                    class="payment-card border border-slate-200 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-catOrange transition bg-white relative">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg"
                                        alt="Mandiri" class="h-6 object-contain">
                                    <span class="text-xs font-semibold text-slate-600">Mandiri VA</span>
                                </div>
                                <div onclick="selectMethod('va_bni')" id="method_va_bni"
                                    class="payment-card border border-slate-200 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-catOrange transition bg-white relative">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/BNI_logo.svg"
                                        alt="BNI" class="h-5 object-contain">
                                    <span class="text-xs font-semibold text-slate-600">BNI VA</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Instant
                                E-Wallet / QRIS</span>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div onclick="selectMethod('qris')" id="method_qris"
                                    class="payment-card border border-slate-200 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-catOrange transition bg-white relative">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg"
                                        alt="QRIS" class="h-6 object-contain">
                                    <span class="text-xs font-semibold text-slate-600">QRIS</span>
                                </div>
                                <div onclick="selectMethod('shopeepay')" id="method_shopeepay"
                                    class="payment-card border border-slate-200 rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-catOrange transition bg-white relative">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg"
                                        alt="ShopeePay" class="h-6 object-contain">
                                    <span class="text-xs font-semibold text-slate-600">ShopeePay</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" onclick="validateCheckout(event)"
                            class="w-full bg-gradient-to-r from-catOrange to-amber-500 text-white font-extrabold py-4 px-6 rounded-2xl text-center shadow-lg shadow-orange-500/20 hover:opacity-95 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-shield-cat"></i> Bayar Sekarang (<span id="btnTotalPrice">Rp0</span>)
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 lg:sticky lg:top-6">
                <h3 class="font-bold text-lg text-slate-900 border-b border-slate-100 pb-3 mb-4">Ringkasan Pesanan</h3>

                <div class="bg-orange-50/50 border border-orange-100/60 rounded-2xl p-4 mb-4">
                    <span id="summaryPackageName"
                        class="text-[10px] bg-catOrange text-white px-2 py-0.5 rounded-md font-bold uppercase tracking-wide">
                        Belum Pilih Paket
                    </span>
                    <div class="flex items-baseline mt-2">
                        <span id="summaryPackageSlots" class="text-3xl font-extrabold text-slate-900">0</span>
                        <span class="text-sm font-semibold text-slate-500 ml-1">Slot Kucing</span>
                    </div>
                </div>

                <div class="space-y-3 text-sm text-slate-600 border-b border-slate-100 pb-4 mb-4">
                    <div class="flex justify-between">
                        <span>Harga Paket</span>
                        <span id="summaryBasePrice" class="font-semibold text-slate-900">Rp0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Layanan</span>
                        <span id="summaryAdminFee" class="font-semibold text-slate-900">Rp0</span>
                    </div>
                    <div class="flex justify-between text-emerald-600">
                        <span>Diskon Bundle</span>
                        <span id="summaryDiscount" class="font-medium">-Rp0</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Total
                            Pembayaran</span>
                        <span id="summaryTotalPrice" class="text-2xl font-black text-catOrange">Rp0</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Fungsi memformat angka biasa ke Format Mata Uang Rupiah
        function formatRupiah(number) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
        }

        // Fungsi otomatis memperbarui rincian harga di sisi kanan saat dropdown diganti
        function updateSummary() {
            const select = document.getElementById('packageSelect');
            const selectedOption = select.options[select.selectedIndex];

            const price = parseInt(selectedOption.getAttribute('data-price')) || 0;
            const slots = parseInt(selectedOption.getAttribute('data-slots')) || 0;
            const name = selectedOption.text.split('(')[0].trim();

            if (price === 0) return;

            const adminFee = 2500;
            const normalPricePerSlot = 30000;
            const normalPriceTotal = slots * normalPricePerSlot;
            const discount = normalPriceTotal > price ? (normalPriceTotal - price) : 0;
            const totalPrice = price + adminFee;

            // Terapkan ke elemen HTML teks
            document.getElementById('summaryPackageName').innerText = name;
            document.getElementById('summaryPackageSlots').innerText = slots;
            document.getElementById('summaryBasePrice').innerText = formatRupiah(price);
            document.getElementById('summaryAdminFee').innerText = formatRupiah(adminFee);
            document.getElementById('summaryDiscount').innerText = '-' + formatRupiah(discount);
            document.getElementById('summaryTotalPrice').innerText = formatRupiah(totalPrice);
            document.getElementById('btnTotalPrice').innerText = formatRupiah(totalPrice);
        }

        function selectMethod(methodId) {
            document.querySelectorAll('.payment-card').forEach(card => {
                card.classList.remove('border-catOrange', 'bg-orange-50/20', 'ring-2', 'ring-catOrange');
                const check = card.querySelector('.active-check');
                if (check) check.remove();
            });

            const selectedCard = document.getElementById('method_' + methodId);
            selectedCard.classList.add('border-catOrange', 'bg-orange-50/20', 'ring-2', 'ring-catOrange');
            selectedCard.insertAdjacentHTML('beforeend', `
            <div class="active-check absolute top-2 right-2 bg-catOrange text-white w-4 h-4 rounded-full flex items-center justify-center text-[9px]">
                <i class="fa-solid fa-check"></i>
            </div>
        `);

            document.getElementById('selectedPaymentMethod').value = methodId;
        }

        function validateCheckout(e) {
            const packageSelect = document.getElementById('packageSelect').value;
            const selectedMethod = document.getElementById('selectedPaymentMethod').value;

            if (!packageSelect) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Paket Belum Dipilih',
                    text: 'Silakan pilih paket slot terlebih dahulu pada dropdown.',
                    confirmButtonColor: '#FF9F43'
                });
                return;
            }

            if (!selectedMethod) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Metode Belum Dipilih',
                    text: 'Silakan klik salah satu metode pembayaran transfer bank/e-wallet.',
                    confirmButtonColor: '#FF9F43'
                });
            }
        }
    </script>
@endsection
