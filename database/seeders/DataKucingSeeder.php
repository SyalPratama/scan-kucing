<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataKucingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        DB::table('data_kucing')->insert([
            [
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'nama_kucing' => 'Milo',
                'ras' => 'Persia',
                'umur' => 2,
                'jenis_kelamin' => 'jantan',
                'warna' => 'Putih',
                'ciri_khusus' => 'Mata biru dan ekor panjang',
                'alamat_pemilik' => 'Majalengka, Jawa Barat',
                'nomor_hp' => '081234567890',
                'qr_code' => (string) Str::uuid(),
                'foto' => 'kucing/milo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'nama_kucing' => 'Oyen',
                'ras' => 'Domestic',
                'umur' => 1,
                'jenis_kelamin' => 'jantan',
                'warna' => 'Orange',
                'ciri_khusus' => 'Aktif dan suka naik motor',
                'alamat_pemilik' => 'Majalengka, Jawa Barat',
                'nomor_hp' => '081234567890',
                'qr_code' => (string) Str::uuid(),
                'foto' => 'kucing/oyen.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}