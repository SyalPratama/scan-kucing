<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        // Mengambil semua user beserta relasi roles-nya
        $users = User::with('roles')->latest()->paginate(10);
        
        // Mengambil semua pilihan role untuk dropdown di modal
        $roles = Role::all(); 

        return view('admin.user', compact('users', 'roles'));
    }

    /**
     * Menyimpan user baru ke database
     */
    public function store(Request $request)
    {
        // 1. Definisikan rules validasi
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id'
        ];

        // 2. Definisikan pesan error kustom dalam bahasa Indonesia
        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'role_id.required' => 'Role wajib dipilih.',
            'role_id.exists' => 'Role yang dipilih tidak valid.'
        ];

        // Jalankan Validator manual agar bisa mencatat log kegagalan input sebelum di-redirect
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Log::warning('Gagal menambahkan user baru karena validasi form tidak terpenuhi.', [
                'input_email' => $request->email,
                'errors'      => $validator->errors()->toArray(),
                'ip_address'  => $request->ip()
            ]);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Memulai Database Transaction demi keamanan data UUID & Pivot
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Menyinkronkan ke tabel pivot role_user
            $user->roles()->attach($request->role_id);

            // Jika semua kueri berhasil tanpa error, commit ke database
            DB::commit();

            return redirect()->back()->with('success', 'User berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Batalkan semua perubahan jika terjadi error di tengah jalan
            DB::rollBack();

            // Mencatat log error sistem/database secara detail untuk debugging
            Log::error('Terjadi kesalahan sistem saat menyimpan data user baru.', [
                'message'    => $e->getMessage(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
                'input_data' => $request->except(['password', 'password_confirmation']),
            ]);

            return redirect()->back()->with('error', 'Gagal menyimpan data karena kendala struktur database atau server.');
        }
    }

    /**
     * Memperbarui data user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id'
        ];

        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'role_id.required' => 'Role wajib dipilih.',
            'role_id.exists' => 'Role yang dipilih tidak valid.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Log::warning('Gagal memperbarui data user karena validasi tidak terpenuhi.', [
                'user_id'    => $id,
                'errors'     => $validator->errors()->toArray(),
                'ip_address' => $request->ip()
            ]);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user->name = $request->name;
            $user->email = $request->email;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();

            // Mengupdate tabel pivot menggunakan sync() agar role lama digantikan dengan role baru
            $user->roles()->sync([$request->role_id]);

            DB::commit();

            return redirect()->back()->with('success', 'User berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Terjadi kesalahan sistem saat memperbarui data user.', [
                'user_id'    => $id,
                'message'    => $e->getMessage(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
                'input_data' => $request->except(['password', 'password_confirmation']),
            ]);

            return redirect()->back()->with('error', 'Gagal memperbarui data karena kendala pada server.');
        }
    }

    /**
     * Menghapus data user beserta relasinya
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            DB::beginTransaction();

            // Lepaskan hubungan role terlebih dahulu sebelum menghapus user
            $user->roles()->detach();
            $user->delete();

            DB::commit();

            return redirect()->back()->with('success', 'User berhasil dihapus dari sistem!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Terjadi kesalahan sistem saat menghapus data user.', [
                'user_id' => $id,
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()->back()->with('error', 'Gagal menghapus data karena kendala pada server.');
        }
    }
}