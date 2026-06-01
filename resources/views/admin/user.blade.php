@extends('admin.layouts.admin')

@section('title', 'Kelola User - Admin AnabulID')

@section('content')
    <div
        class="mb-8 bg-white p-6 rounded-3xl border border-orange-100 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fa-solid fa-users text-catOrange"></i> Kelola Data User
            </h1>
            <p class="text-sm text-gray-500 mt-1">Manajemen data client, reseller, dan hak akses pengguna platform AnabulID.</p>
        </div>
        <div>
            <button onclick="toggleModal('modal-add')"
                class="px-5 py-3 bg-catOrange hover:bg-orange-600 text-white font-medium text-sm rounded-2xl shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah User Baru
            </button>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-orange-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-orange-50/50 border-b border-orange-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        <th class="p-5">Nama</th>
                        <th class="p-5">Email</th>
                        <th class="p-5">Role</th>
                        <th class="p-5">Tanggal Bergabung</th>
                        <th class="p-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-5 font-semibold text-catDark">{{ $user->name }}</td>
                            <td class="p-5 text-gray-500">{{ $user->email }}</td>
                            <td class="p-5">
                                @foreach ($user->roles as $role)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $role->name == 'admin' ? 'bg-red-50 text-red-600 border border-red-100' : '' }}
                                        {{ $role->name == 'reseller' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                                        {{ $role->name == 'client' ? 'bg-orange-50 text-catOrange border border-orange-100' : '' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="p-5 text-gray-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="p-5 flex items-center justify-center gap-2">
                                <button onclick="openEditModal({{ json_encode($user) }}, '{{ $user->roles->first()->id ?? '' }}')"
                                    class="w-9 h-9 bg-gray-50 hover:bg-orange-50 text-gray-500 hover:text-catOrange rounded-xl border border-gray-100 transition flex items-center justify-center">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="handleDelete('{{ $user->id }}')"
                                    class="w-9 h-9 bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-600 rounded-xl border border-gray-100 transition flex items-center justify-center">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.data-user.destroy', $user->id) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-400">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5 border-t border-gray-50">
            {{ $users->links() }}
        </div>
    </div>

    <div id="modal-add" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl max-w-md w-full overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-catDark"><i class="fa-solid fa-user-plus text-catOrange mr-1"></i> Tambah User</h3>
                <button onclick="toggleModal('modal-add')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.data-user.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Password</label>
                    <div class="relative flex items-center">
                        <input type="password" id="add-password" name="password" required class="w-full px-4 pr-12 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                        <button type="button" onclick="togglePasswordVisibility('add-password', 'add-password-icon')" class="absolute right-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i id="add-password-icon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Role Akun</label>
                    <select name="role_id" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition bg-white">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="toggleModal('modal-add')" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-500 font-medium text-sm rounded-2xl transition">Batal</button>
                    <button type="submit" class="px-5 py-3 bg-catOrange hover:bg-orange-600 text-white font-medium text-sm rounded-2xl transition shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-edit" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl max-w-md w-full overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-catDark"><i class="fa-solid fa-user-pen text-catOrange mr-1"></i> Edit Data User</h3>
                <button onclick="toggleModal('modal-edit')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="form-edit" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" id="edit-name" name="name" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Email</label>
                    <input type="email" id="edit-email" name="email" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Password Baru <span class="text-[10px] text-gray-400 italic">(Kosongkan jika tidak diubah)</span></label>
                    <div class="relative flex items-center">
                        <input type="password" id="edit-password" name="password" class="w-full px-4 pr-12 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition">
                        <button type="button" onclick="togglePasswordVisibility('edit-password', 'edit-password-icon')" class="absolute right-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i id="edit-password-icon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Role Akun</label>
                    <select id="edit-role" name="role_id" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-sm focus:outline-none focus:border-catOrange transition bg-white">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="toggleModal('modal-edit')" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-500 font-medium text-sm rounded-2xl transition">Batal</button>
                    <button type="submit" class="px-5 py-3 bg-catOrange hover:bg-orange-600 text-white font-medium text-sm rounded-2xl transition shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
            
            // Reset input tipe password kembali ke asal ketika modal ditutup/buka
            if (id === 'modal-add') {
                resetPasswordInput('add-password', 'add-password-icon');
            } else if (id === 'modal-edit') {
                resetPasswordInput('edit-password', 'edit-password-icon');
            }
        }

        // Fungsi reusable untuk merubah visibilitas password
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Fungsi mereset field input password menjadi tersembunyi semula
        function resetPasswordInput(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (passwordInput) {
                passwordInput.type = 'password';
                passwordInput.value = ''; // Mengosongkan isian lama
            }
            if (icon) {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function openEditModal(user, roleId) {
            document.getElementById('form-edit').action = `/admin/data-user/${user.id}`;
            document.getElementById('edit-name').value = user.name;
            document.getElementById('edit-email').value = user.email;
            document.getElementById('edit-role').value = roleId;
            toggleModal('modal-edit');
        }

        function handleDelete(userId) {
            Swal.fire({
                title: 'Hapus Pengguna?',
                text: "Tindakan ini tidak bisa dibatalkan. Seluruh data akses user terpilih akan dihapus dari sistem.",
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
                    document.getElementById(`delete-form-${userId}`).submit();
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
                title: "{{ session('error') ?? 'Terjadi kesalahan pada data yang Anda masukkan.' }}"
            });
        @endif
    </script>
@endsection