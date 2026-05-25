<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Kucing - AnabulID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        catOrange: '#FF9F43',
                        catSoft: '#FFF4EB',
                        catDark: '#2D3748'
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

        /* Custom UI SweetAlert agar membulat serasi dengan tema */
        .custom-swal-popup {
            border-radius: 1.5rem !important;
        }
    </style>
</head>

<body class="bg-catSoft text-catDark antialiased min-h-screen">

    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 bg-white p-6 rounded-3xl border border-orange-100 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fa-solid fa-cat text-catOrange"></i> Data Anabul Kamu
                </h1>
                <p class="text-sm text-gray-500 mt-1">Kelola informasi profil dan QR Code pelacak kucing kesayanganmu.
                </p>
            </div>
            <button onclick="openCreateModal()"
                class="bg-catOrange text-white font-bold text-sm px-5 py-3 rounded-2xl shadow-lg shadow-orange-500/20 hover:bg-amber-600 transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Kucing
            </button>
        </div>

        @if ($dataKucing->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm">
                <div class="text-gray-300 text-6xl mb-3"><i class="fa-solid fa-paw"></i></div>
                <p class="text-gray-500 font-medium">Belum ada data kucing terdaftar.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($dataKucing as $kucing)
                    <div
                        class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 relative group hover:shadow-md transition">
                        <div class="flex gap-4 items-start">
                            <div
                                class="w-20 h-20 bg-gray-100 rounded-2xl overflow-hidden flex-shrink-0 border border-gray-200">
                                @if ($kucing->foto)
                                    <img src="{{ asset($kucing->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                        <i class="fa-solid fa-cat text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg truncate">{{ $kucing->nama_kucing }}</h3>
                                <p class="text-xs text-gray-400 capitalize mt-0.5">{{ $kucing->ras ?? 'Ras Campuran' }}
                                    • {{ $kucing->umur ?? '?' }} Bulan</p>
                                <span
                                    class="inline-block mt-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide {{ $kucing->jenis_kelamin == 'jantan' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600' }} capitalize">
                                    <i
                                        class="fa-solid {{ $kucing->jenis_kelamin == 'jantan' ? 'fa-mars' : 'fa-venus' }} mr-0.5"></i>
                                    {{ $kucing->jenis_kelamin }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs text-gray-400 font-medium"><i class="fa-solid fa-qrcode mr-1"></i>
                                Terlindungi</span>
                            <div class="flex gap-2">

                                <a href="{{ route('client.data-kucing.download-qr', $kucing->id) }}"
                                    class="p-2 bg-gray-50 hover:bg-amber-50 text-gray-500 hover:text-amber-600 rounded-xl transition text-xs"
                                    title="Unduh QR Code">
                                    <i class="fa-solid fa-download mr-1"></i> QR
                                </a>
                                <!-- TOMBOL BARU: Lihat Tampilan Halaman QR Publik -->
                                <a href="{{ route('kucing.public-profile', $kucing->qr_code) }}" target="_blank"
                                    class="p-2 bg-gray-50 hover:bg-blue-50 text-gray-500 hover:text-blue-500 rounded-xl transition text-xs"
                                    title="Lihat Halaman QR">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <button onclick="openEditModal(this)" data-id="{{ $kucing->id }}"
                                    data-nama="{{ $kucing->nama_kucing }}" data-ras="{{ $kucing->ras }}"
                                    data-umur="{{ $kucing->umur }}" data-gender="{{ $kucing->jenis_kelamin }}"
                                    data-warna="{{ $kucing->warna }}" data-ciri="{{ $kucing->ciri_khusus }}"
                                    data-alamat="{{ $kucing->alamat_pemilik }}" data-hp="{{ $kucing->nomor_hp }}"
                                    class="p-2 bg-gray-50 hover:bg-orange-50 text-gray-500 hover:text-catOrange rounded-xl transition text-xs"
                                    title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <form id="delete-form-{{ $kucing->id }}"
                                    action="{{ route('client.data-kucing.destroy', $kucing->id) }}" method="POST"
                                    class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                                <button type="button"
                                    onclick="confirmDelete('{{ $kucing->id }}', '{{ $kucing->nama_kucing }}')"
                                    class="p-2 bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-500 rounded-xl transition text-xs"
                                    title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="modalCreate"
        class="fixed inset-0 bg-catDark/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl p-6 relative max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold flex items-center gap-2"><i class="fa-solid fa-paw text-catOrange"></i>
                    Tambah Anabul Baru</h2>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600"><i
                        class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form action="{{ route('client.data-kucing.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Nama Kucing *</label>
                        <input type="text" name="nama_kucing" required
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Ras</label>
                        <input type="text" name="ras" placeholder="Persia, Anggora..."
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Umur (Bulan)</label>
                        <input type="number" name="umur"
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                            <option value="">Pilih</option>
                            <option value="jantan">Jantan</option>
                            <option value="betina">Betina</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Warna Bulu</label>
                        <input type="text" name="warna" placeholder="Oren, Putih, Calico..."
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">No. HP Pemilik</label>
                        <input type="text" name="nomor_hp" placeholder="0812..."
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Ciri Khusus</label>
                    <textarea name="ciri_khusus" rows="2" placeholder="Ekor bengkok, ada tompel hitam di hidung..."
                        class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Alamat Pemilik</label>
                    <textarea name="alamat_pemilik" rows="2"
                        class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Foto Kucing</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-catOrange hover:file:bg-orange-100">
                </div>
                <div class="pt-2 flex gap-3 justify-end">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 rounded-xl transition">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-catOrange text-white font-bold text-sm rounded-xl hover:bg-amber-600 shadow-md transition">Simpan
                        Data</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit"
        class="fixed inset-0 bg-catDark/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl p-6 relative max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold flex items-center gap-2"><i
                        class="fa-solid fa-pen-to-square text-catOrange"></i> Ubah Data Anabul</h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><i
                        class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="formEdit" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Nama Kucing *</label>
                        <input type="text" id="edit_nama" name="nama_kucing" required
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Ras</label>
                        <input type="text" id="edit_ras" name="ras"
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Umur (Bulan)</label>
                        <input type="number" id="edit_umur" name="umur"
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Jenis Kelamin</label>
                        <select id="edit_gender" name="jenis_kelamin"
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                            <option value="">Pilih</option>
                            <option value="jantan">Jantan</option>
                            <option value="betina">Betina</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Warna Bulu</label>
                        <input type="text" id="edit_warna" name="warna"
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">No. HP Pemilik</label>
                        <input type="text" id="edit_hp" name="nomor_hp"
                            class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Ciri Khusus</label>
                    <textarea id="edit_ciri" name="ciri_khusus" rows="2"
                        class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Alamat Pemilik</label>
                    <textarea id="edit_alamat" name="alamat_pemilik" rows="2"
                        class="w-full bg-gray-50 border border-gray-200 px-3 py-2 rounded-xl text-sm focus:border-catOrange focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Foto Kucing (Biarkan kosong jika tidak
                        diganti)</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-catOrange hover:file:bg-orange-100">
                </div>
                <div class="pt-2 flex gap-3 justify-end">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 rounded-xl transition">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-catOrange text-white font-bold text-sm rounded-xl hover:bg-amber-600 shadow-md transition">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit = document.getElementById('modalEdit');
        const formEdit = document.getElementById('formEdit');

        function openCreateModal() {
            modalCreate.classList.remove('hidden');
        }

        function closeCreateModal() {
            modalCreate.classList.add('hidden');
        }

        function openEditModal(button) {
            const id = button.getAttribute('data-id');
            formEdit.action = `/client/data-kucing/update/${id}`;

            document.getElementById('edit_nama').value = button.getAttribute('data-nama');
            document.getElementById('edit_ras').value = button.getAttribute('data-ras');
            document.getElementById('edit_umur').value = button.getAttribute('data-umur');
            document.getElementById('edit_gender').value = button.getAttribute('data-gender');
            document.getElementById('edit_warna').value = button.getAttribute('data-warna');
            document.getElementById('edit_hp').value = button.getAttribute('data-hp');
            document.getElementById('edit_ciri').value = button.getAttribute('data-ciri');
            document.getElementById('edit_alamat').value = button.getAttribute('data-alamat');

            modalEdit.classList.remove('hidden');
        }

        function closeEditModal() {
            modalEdit.classList.add('hidden');
        }
    </script>


    <script>
        // 1. Alert Sukses saat Berhasil Tambah/Edit/Hapus Data
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#FF9F43',
                customClass: {
                    popup: 'custom-swal-popup'
                }
            });
        @endif

        // 2. Alert Gagal saat Terjadi Error Validasi Input dari Laravel
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Opps.. Terjadi Kesalahan',
                html: `<ul class="text-left text-xs list-disc list-inside pl-2 space-y-1 text-gray-600">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                       </ul>`,
                confirmButtonColor: '#FF9F43',
                customClass: {
                    popup: 'custom-swal-popup'
                }
            });
        @endif

        // 3. Konfirmasi Hapus Data Interaktif
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Anabul?',
                text: `Apakah kamu yakin ingin menghapus data si "${name}"? Data tidak dapat dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'custom-swal-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Trigger submit form penyamaran jika user klik "Ya, Hapus!"
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>

</body>

</html>
