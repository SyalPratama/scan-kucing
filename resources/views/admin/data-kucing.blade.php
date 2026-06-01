@extends('admin.layouts.admin')

@section('title', 'Kelola Data Kucing - Admin AnabulID')

@section('content')
    <div
        class="mb-8 bg-white p-6 rounded-3xl border border-orange-100 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-cat text-catOrange"></i> Kelola Data Kucing
            </h1>
            <p class="text-sm text-gray-500 mt-1">Manajemen data anabul, informasi ras, qr code, serta kepemilikan client
                AnabulID.</p>
        </div>
        <div>
            <button onclick="toggleModal('modal-add')"
                class="px-5 py-3 bg-catOrange hover:bg-orange-600 text-white font-medium text-sm rounded-2xl shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Kucing Baru
            </button>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-orange-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-orange-50/50 border-b border-orange-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        <th class="p-5">Foto & Nama</th>
                        <th class="p-5">Ras / Warna</th>
                        <th class="p-5">Info Fisik</th>
                        <th class="p-5">Pemilik & Kontak</th>
                        <th class="p-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($kucings as $kucing)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-2xl overflow-hidden bg-orange-50 border border-orange-100 flex items-center justify-center flex-shrink-0">
                                        @if ($kucing->foto)
                                            <img src="{{ asset($kucing->foto) }}" alt="{{ $kucing->nama_kucing }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-cat text-xl text-orange-300"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-catDark text-base">{{ $kucing->nama_kucing }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono mt-0.5">
                                            {{ Str::limit($kucing->id, 8, '') }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-5">
                                <div class="font-medium text-gray-700">{{ $kucing->ras }}</div>
                                <div class="text-xs text-gray-400">{{ $kucing->warna }}</div>
                            </td>

                            <td class="p-5">
                                <div class="flex flex-wrap gap-1 mb-1">
                                    <span
                                        class="px-2 py-0.5 text-[11px] font-medium rounded-md bg-orange-50 text-catOrange border border-orange-100">
                                        {{ $kucing->umur }}
                                    </span>
                                    <span
                                        class="px-2 py-0.5 text-[11px] font-medium rounded-md {{ $kucing->jenis_kelamin == 'jantan' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-pink-50 text-pink-600 border border-pink-100' }}">
                                        <i
                                            class="fa-solid {{ $kucing->jenis_kelamin == 'jantan' ? 'fa-mars' : 'fa-venus' }} mr-0.5"></i>{{ $kucing->jenis_kelamin }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-400 italic max-w-[180px] truncate"
                                    title="{{ $kucing->ciri_khusus }}">
                                    {{ $kucing->ciri_khusus ?? '-' }}
                                </div>
                            </td>

                            <td class="p-5">
                                <div class="font-medium text-gray-700 flex items-center gap-1">
                                    <i class="fa-solid fa-user text-xs text-gray-400"></i>
                                    {{ $kucing->user->name ?? 'Tanpa Pemilik' }}
                                </div>
                                <div class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                    <i class="fa-solid fa-phone text-[10px]"></i> {{ $kucing->nomor_hp }}
                                </div>
                            </td>

                            <td class="p-5 flex items-center justify-center gap-2 mt-2">
                                <button onclick="openEditModal({{ json_encode($kucing) }})"
                                    class="w-9 h-9 bg-gray-50 hover:bg-orange-50 text-gray-500 hover:text-catOrange rounded-xl border border-gray-100 transition flex items-center justify-center">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>

                                <button onclick="handleDelete('{{ $kucing->id }}')"
                                    class="w-9 h-9 bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-600 rounded-xl border border-gray-100 transition flex items-center justify-center">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>

                                <form id="delete-form-{{ $kucing->id }}"
                                    action="{{ route('admin.data-kucing.destroy', $kucing->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400">Belum ada data kucing terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5 border-t border-gray-50">
            {{ $kucings->links() }}
        </div>
    </div>

    <div id="modal-add"
        class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div
            class="bg-white rounded-3xl border border-gray-100 shadow-xl max-w-2xl w-full overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-catDark"><i class="fa-solid fa-plus text-catOrange mr-1"></i> Tambah Data
                    Kucing</h3>
                <button onclick="toggleModal('modal-add')" class="text-gray-400 hover:text-gray-600"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.data-kucing.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-4 max-h-[75vh] overflow-y-auto style-scrollbar">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Kucing</label>
                        <input type="text" name="nama_kucing" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Pilih Pemilik (User)</label>
                        <select name="user_id" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition bg-white">
                            <option value="">-- Pilih Akun Pemilik --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ras Kucing</label>
                        <input type="text" name="ras" placeholder="Contoh: Persia" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Umur</label>
                        <input type="text" name="umur" placeholder="Contoh: 1 Tahun" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition bg-white">
                            <option value="Jantan">Jantan</option>
                            <option value="Betina">Betina</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Warna Bulu</label>
                        <input type="text" name="warna" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nomor HP/WhatsApp</label>
                        <input type="text" name="nomor_hp" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ciri Khusus</label>
                    <input type="text" name="ciri_khusus" placeholder="Misal: ekor bengkok, mata biru sebelah"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Alamat Pemilik</label>
                    <textarea name="alamat_pemilik" required rows="2"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Foto Anabul</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full px-4 py-2.5 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition file:mr-4 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-catOrange hover:file:bg-orange-100 cursor-pointer">
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-gray-50">
                    <button type="button" onclick="toggleModal('modal-add')"
                        class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-500 font-medium text-sm rounded-2xl transition">Batal</button>
                    <button type="submit"
                        class="px-5 py-3 bg-catOrange hover:bg-orange-600 text-white font-medium text-sm rounded-2xl transition shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-edit"
        class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div
            class="bg-white rounded-3xl border border-gray-100 shadow-xl max-w-2xl w-full overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-catDark"><i class="fa-solid fa-cat text-catOrange mr-1"></i> Edit Data
                    Kucing</h3>
                <button onclick="toggleModal('modal-edit')" class="text-gray-400 hover:text-gray-600"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="form-edit" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-4 max-h-[75vh] overflow-y-auto style-scrollbar">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Kucing</label>
                        <input type="text" id="edit-nama-kucing" name="nama_kucing" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Pilih Pemilik (User)</label>
                        <select id="edit-user-id" name="user_id" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition bg-white">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ras Kucing</label>
                        <input type="text" id="edit-ras" name="ras" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Umur</label>
                        <input type="text" id="edit-umur" name="umur" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Jenis Kelamin</label>
                        <select id="edit-jenis-kelamin" name="jenis_kelamin" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition bg-white">
                            <option value="Jantan">Jantan</option>
                            <option value="Betina">Betina</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Warna Bulu</label>
                        <input type="text" id="edit-warna" name="warna" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nomor HP/WhatsApp</label>
                        <input type="text" id="edit-nomor-hp" name="nomor_hp" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ciri Khusus</label>
                    <input type="text" id="edit-ciri-khusus" name="ciri_khusus"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Alamat Pemilik</label>
                    <textarea id="edit-alamat-pemilik" name="alamat_pemilik" required rows="2"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ubah Foto <span
                            class="text-[10px] text-gray-400 italic">(Kosongkan jika tidak diganti)</span></label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full px-4 py-2.5 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition file:mr-4 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-catOrange hover:file:bg-orange-100 cursor-pointer">
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-gray-50">
                    <button type="button" onclick="toggleModal('modal-edit')"
                        class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-500 font-medium text-sm rounded-2xl transition">Batal</button>
                    <button type="submit"
                        class="px-5 py-3 bg-catOrange hover:bg-orange-600 text-white font-medium text-sm rounded-2xl transition shadow-sm">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }

        function openEditModal(kucing) {
            document.getElementById('form-edit').action = `/admin/data-kucing/${kucing.id}`;

            document.getElementById('edit-nama-kucing').value = kucing.nama_kucing;
            document.getElementById('edit-user-id').value = kucing.user_id;
            document.getElementById('edit-ras').value = kucing.ras;
            document.getElementById('edit-umur').value = kucing.umur;
            document.getElementById('edit-jenis-kelamin').value = kucing.jenis_kelamin;
            document.getElementById('edit-warna').value = kucing.warna;
            document.getElementById('edit-nomor-hp').value = kucing.nomor_hp;
            document.getElementById('edit-ciri-khusus').value = kucing.ciri_khusus || '';
            document.getElementById('edit-alamat-pemilik').value = kucing.alamat_pemilik;

            toggleModal('modal-edit');
        }

        function handleDelete(kucingId) {
            Swal.fire({
                title: 'Hapus Data Kucing?',
                text: "Tindakan ini permanen. Seluruh riwayat data serta sistem integrasi QR Code anabul terkait akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl border border-gray-100',
                    confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-semibold',
                    cancelButton: 'px-5 py-2.5 rounded-xl text-xs font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${kucingId}`).submit();
                }
            })
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if (session('error') || $errors->any())
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') ?? 'Periksa kembali kelengkapan formulir Anda.' }}"
            });
        @endif
    </script>

    <style>
        .style-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .style-scrollbar::-webkit-scrollbar-track {
            background: #f9fafb;
        }

        .style-scrollbar::-webkit-scrollbar-thumb {
            background: #fed7aa;
            border-radius: 20px;
        }
    </style>
@endsection
