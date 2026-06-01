<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page) beserta list data paket.
     */
    public function index()
    {
        // Mengambil semua data paket dari database dan mengurutkannya berdasarkan jumlah slot terkecil
        $packages = Package::orderBy('slots', 'asc')->get();

        // Mengirimkan variabel $packages ke file resources/views/welcome.blade.php
        return view('welcome', compact('packages'));
    }
}