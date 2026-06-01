<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataKucing;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilan Utama Dashboard Admin (Ringkasan Data)
     */
    public function index()
    {
        // Menghitung jumlah user yang memiliki role 'client'
        $totalClient = User::whereHas('roles', function($query) {
            $query->where('slug', 'client'); // Sesuaikan 'name' dengan nama kolom role Anda
        })->count();

        // Menghitung jumlah user yang memiliki role 'reseller'
        $totalReseller = User::whereHas('roles', function($query) {
            $query->where('slug', 'reseller');
        })->count();

        // Menghitung total data kucing
        $totalKucing = DataKucing::count(); 

        return view('admin.dashboard', compact('totalClient', 'totalReseller', 'totalKucing'));
    }
}