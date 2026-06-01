<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('payment.index', compact('payments'));
    }

    // Mengubah parameter URL: Menampilkan form checkout dengan pilihan semua paket
    public function checkout()
    {
        $packages = Package::orderBy('slots', 'asc')->get();
        
        return view('payment.checkout', compact('packages'));
    }

    public function create(Request $request)
    {
        // Validasi input mencocokkan id paket yang dipilih dari elemen <select>
        $request->validate([
            'package_id'     => 'required|exists:packages,id',
            'phone_number'   => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Ambil data paket riil dari database
        $package = Package::findOrFail($request->package_id);

        $payment = Payment::create([
            'id'              => (string) Str::uuid(), // Jika kolom ID payments menggunakan UUID
            'user_id'         => Auth::id(),
            'package_id'      => $package->id,
            'order_id'        => 'CAT-' . strtoupper(Str::random(10)),
            'amount'          => $package->price, // Menggunakan harga asli dari DB paket
            'status'          => 'pending',
            'payment_gateway' => 'midtrans',
        ]);

        /**
         * Nanti di sini generate Midtrans Snap Token
         */

        return redirect()
            ->route('client.payment.index')
            ->with('success', 'Transaksi berhasil dibuat.');
    }
}