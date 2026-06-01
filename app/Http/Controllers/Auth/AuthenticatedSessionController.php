<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Jalankan autentikasi bawaan Laravel Breeze (cek email & password)
        $request->authenticate();

        // 2. Regenerasi session untuk keamanan
        $request->session()->regenerate();

        // 3. Ambil data user yang baru saja login beserta relasi rolenya
        $user = Auth::user();

        // 4. Cek role user dan tentukan arah redirect
        // Pendekatan menggunakan asumsi relasi $user->roles
        if ($user->roles()->where('slug', 'admin')->exists()) {
            return redirect()->route('admin.dashboard'); 
        } 
        
        if ($user->roles()->where('slug', 'client')->exists()) {
            return redirect()->route('client.data-kucing.index'); // atau rute landing page/scan qr kamu
        }

        // Jalur alternatif jika user entah bagaimana tidak memiliki role di atas
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}