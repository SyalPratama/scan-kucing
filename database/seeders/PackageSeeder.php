<?php

namespace Database\Seeders;

use App\Models\Package; // Pastikan model Package sudah dibuat
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('packages')->insert([
            [
                'name' => 'Paket Single',
                'slots' => 1,
                'price' => 30000,
                'badge' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paket Hemat',
                'slots' => 3,
                'price' => 75000,
                'badge' => 'Paling Populer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paket Pro Cat',
                'slots' => 5,
                'price' => 120000,
                'badge' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}