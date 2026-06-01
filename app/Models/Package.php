<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * (Opsional, karena Laravel secara otomatis menebak bentuk jamak "packages")
     *
     * @var string
     */
    protected $table = 'packages';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     * Sesuaikan dengan kolom-kolom yang ada di file migration Anda.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slots',
        'price',
        'badge',
        'features',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu (Casting).
     * Memastikan 'price' dibaca sebagai float/double, dan 'slots' sebagai integer di PHP.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'slots' => 'integer',
        'price' => 'double',
    ];

    /**
     * Relasi One-to-Many ke model Payment.
     * Satu paket bisa dibeli dalam banyak transaksi pembayaran.
     * * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'package_id', 'id');
    }
}