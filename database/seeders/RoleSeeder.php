<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate agar tidak duplikat jika seeder dijalankan ulang
        Role::updateOrCreate(
            ['slug' => 'reseller'], // Kondisi pengecekan
            [
                'name' => 'Reseller',
                // id akan digenerate otomatis oleh boot() method di model Role
            ]
        );
    }
}