<?php

namespace App\Http\Controllers;

use App\Models\DataKucing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DataKucingController extends Controller
{
    /**
     * List data kucing user login
     */
    public function index()
    {
        Log::info('Mengambil data kucing user', [
            'user_id' => Auth::id()
        ]);

        $dataKucing = DataKucing::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('data-kucing.index', compact('dataKucing'));
    }

    /**
     * Simpan data
     */
    public function store(Request $request)
    {
        Log::info('Proses store data kucing dimulai', [
            'user_id' => Auth::id(),
            'request' => $request->all()
        ]);

        $request->validate([
            'nama_kucing' => 'required',
            'ras' => 'nullable',
            'umur' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|in:jantan,betina',
            'warna' => 'nullable',
            'ciri_khusus' => 'nullable',
            'alamat_pemilik' => 'nullable',
            'nomor_hp' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;

        /**
         * Upload foto
         */
        if ($request->hasFile('foto')) {

            Log::info('Upload foto kucing', [
                'user_id' => Auth::id()
            ]);

            $path = public_path('assets/kucing/' . Auth::id());

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $file = $request->file('foto');

            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            $file->move($path, $filename);

            $foto = 'assets/kucing/' . Auth::id() . '/' . $filename;
        }

        $kucing = DataKucing::create([
            'id' => (string) Str::uuid(),
            'user_id' => Auth::id(),
            'nama_kucing' => $request->nama_kucing,
            'ras' => $request->ras,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'warna' => $request->warna,
            'ciri_khusus' => $request->ciri_khusus,
            'alamat_pemilik' => $request->alamat_pemilik,
            'nomor_hp' => $request->nomor_hp,
            'qr_code' => (string) Str::uuid(),
            'foto' => $foto,
        ]);

        Log::info('Data kucing berhasil disimpan', [
            'kucing_id' => $kucing->id,
            'user_id' => Auth::id()
        ]);

        // PERBAIKAN: Dialihkan menggunakan nama rute group client
        return redirect()->route('client.data-kucing.index')
            ->with('success', 'Data kucing berhasil ditambahkan');
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        Log::info('Proses update data kucing dimulai', [
            'user_id' => Auth::id(),
            'kucing_id' => $id,
            'request' => $request->all()
        ]);

        // 1. CEK AWAL: Apakah file dikirim tapi corrupt / melebihi batas server (php.ini)
        if ($request->has('foto') && !$request->hasFile('foto') && $request->filled('foto')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['foto' => 'Ukuran foto terlalu besar! Maksimal ukuran file yang diizinkan server adalah ' . ini_get('upload_max_filesize') . 'B.']);
        }

        $kucing = DataKucing::where('user_id', Auth::id())
            ->findOrFail($id);

        // 2. VALIDASI DATA + Pesan Error Kustom dalam Bahasa Indonesia
        $request->validate([
            'nama_kucing' => 'required',
            'ras' => 'nullable',
            'umur' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|in:jantan,betina',
            'warna' => 'nullable',
            'ciri_khusus' => 'nullable',
            'alamat_pemilik' => 'nullable',
            'nomor_hp' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_kucing.required' => 'Nama kucing tidak boleh kosong.',
            'umur.integer' => 'Format umur harus berupa angka bulan.',
            'jenis_kelamin.in' => 'Jenis kelamin harus di antara Jantan atau Betina.',
            'foto.image' => 'File harus berupa gambar (foto).',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto si Oyen terlalu besar, maksimal adalah 2 MB.',
        ]);

        // 3. PROSES UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // Proteksi tambahan memastikan file siap dipindahkan
            if (!$file->isValid()) {
                Log::error('File upload terdeteksi corrupt atau tidak valid', ['user_id' => Auth::id()]);
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['foto' => 'Proses unggah foto gagal karena file tidak valid atau rusak. Silakan coba foto lain.']);
            }

            Log::info('Update foto kucing dijalankan', [
                'user_id' => Auth::id(),
                'kucing_id' => $id
            ]);

            $path = public_path('assets/kucing/' . Auth::id());

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // Hapus foto lama jika ada
            if ($kucing->foto && File::exists(public_path($kucing->foto))) {
                File::delete(public_path($kucing->foto));
            }

            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            try {
                $file->move($path, $filename);
                $kucing->foto = 'assets/kucing/' . Auth::id() . '/' . $filename;
            } catch (\Exception $e) {
                Log::error('Gagal memindahkan file ke direktori tujuan', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['foto' => 'Gagal menyimpan file ke dalam sistem server. Periksa izin folder (permission).']);
            }
        }

        // 4. UPDATE DATA KE DATABASE
        $kucing->nama_kucing = $request->nama_kucing;
        $kucing->ras = $request->ras;
        $kucing->umur = $request->umur;
        $kucing->jenis_kelamin = $request->jenis_kelamin;
        $kucing->warna = $request->warna;
        $kucing->ciri_khusus = $request->ciri_khusus;
        $kucing->alamat_pemilik = $request->alamat_pemilik;
        $kucing->nomor_hp = $request->nomor_hp;

        $kucing->save();

        Log::info('Data kucing berhasil diupdate', [
            'kucing_id' => $id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('client.data-kucing.index')
            ->with('success', 'Data kucing berhasil diupdate');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        Log::info('Proses delete data kucing', [
            'user_id' => Auth::id(),
            'kucing_id' => $id
        ]);

        $kucing = DataKucing::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($kucing->foto && File::exists(public_path($kucing->foto))) {
            File::delete(public_path($kucing->foto));
        }

        $kucing->delete();

        Log::info('Data kucing berhasil dihapus', [
            'kucing_id' => $id,
            'user_id' => Auth::id()
        ]);

        // PERBAIKAN: Dialihkan menggunakan nama rute group client
        return redirect()->route('client.data-kucing.index')
            ->with('success', 'Data kucing berhasil dihapus');
    }

    public function showPublic($qr_code)
    {
        Log::info('QR Code kucing dipindai', ['qr_code' => $qr_code]);

        // Cari kucing berdasarkan qr_code, jika tidak ada langsung return 404
        $kucing = DataKucing::where('qr_code', $qr_code)->firstOrFail();

        return view('data-kucing.public-show', compact('kucing'));
    }

    /**
     * Generate dan Unduh Foto QR Code Kucing
     */
    public function downloadQrCode($id)
    {
        Log::info('User mengunduh QR Code kucing', [
            'user_id' => Auth::id(),
            'kucing_id' => $id
        ]);

        // Pastikan kucing ini memang milik user yang sedang login
        $kucing = DataKucing::where('user_id', Auth::id())->findOrFail($id);

        // Buat isi data QR Code mengarah ke rute publik profil kucing
        $urlPublik = route('kucing.public-profile', $kucing->qr_code);

        // Generate gambar QR Code menggunakan Simple-QRCode (format PNG, ukuran 500px)
        $image = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(500)
            ->margin(2)
            ->errorCorrection('H') // High error correction agar tetap terbaca walau kalung agak lecet
            ->generate($urlPublik);

        // Set nama file download yang rapi
        $filename = 'QRCode_' . Str::slug($kucing->nama_kucing) . '.png';

        // Kembalikan sebagai response download file gambar
        return response($image)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}