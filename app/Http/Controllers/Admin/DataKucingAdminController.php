<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKucing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataKucingAdminController extends Controller
{
    /**
     * Tampilkan halaman utama & tabel data kucing
     */
    public function index()
    {
        $kucings = DataKucing::with('user')->latest()->paginate(10);
        $users = User::orderBy('name', 'asc')->get();

        return view('admin.data-kucing', compact('kucings', 'users'));
    }

    /**
     * Simpan data kucing baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'nama_kucing'     => 'required|string|max:255',
            'ras'             => 'required|string|max:100',
            'umur'            => 'required|string|max:50',
            'jenis_kelamin'   => 'required|in:Jantan,Betina',
            'warna'           => 'required|string|max:100',
            'ciri_khusus'     => 'nullable|string|max:255',
            'alamat_pemilik'  => 'required|string',
            'nomor_hp'        => 'required|string|max:20',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Proses upload foto jika file dilampirkan
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kucing', 'public');
        }

        // Generate string kode random untuk QR Code mock up platform AnabulID
        $data['qr_code'] = 'QR-' . strtoupper(bin2hex(random_bytes(4)));

        DataKucing::create($data);

        return redirect()->back()->with('success', 'Data anabul baru berhasil ditambahkan!');
    }

    /**
     * Update data kucing berdasarkan UUID ($id)
     */
    public function update(Request $request, $id)
    {
        // Cari data berdasarkan string UUID manual karena tidak memakai Route Resource Binding
        $kucing = DataKucing::findOrFail($id);

        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'nama_kucing'     => 'required|string|max:255',
            'ras'             => 'required|string|max:100',
            'umur'            => 'required|string|max:50',
            'jenis_kelamin'   => 'required|in:Jantan,Betina',
            'warna'           => 'required|string|max:100',
            'ciri_khusus'     => 'nullable|string|max:255',
            'alamat_pemilik'  => 'required|string',
            'nomor_hp'        => 'required|string|max:20',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus file foto lama di public storage jika ada
            if ($kucing->foto && Storage::disk('public')->exists($kucing->foto)) {
                Storage::disk('public')->delete($kucing->foto);
            }
            $data['foto'] = $request->file('foto')->store('kucing', 'public');
        }

        $kucing->update($data);

        return redirect()->back()->with('success', 'Data anabul berhasil diperbarui!');
    }

    /**
     * Hapus data kucing berdasarkan UUID ($id)
     */
    public function destroy($id)
    {
        $kucing = DataKucing::findOrFail($id);

        // Hapus aset file gambar dari storage disk agar tidak membebani server
        if ($kucing->foto && Storage::disk('public')->exists($kucing->foto)) {
            Storage::disk('public')->delete($kucing->foto);
        }

        $kucing->delete();

        return redirect()->back()->with('success', 'Data anabul berhasil dihapus dari sistem.');
    }
}