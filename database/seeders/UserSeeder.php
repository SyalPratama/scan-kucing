<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * ROLE
         */
        $adminRoleId = (string) Str::uuid();
        $clientRoleId = (string) Str::uuid();

        DB::table('roles')->insert([
            [
                'id' => $adminRoleId,
                'name' => 'Administrator',
                'slug' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => $clientRoleId,
                'name' => 'Client',
                'slug' => 'client',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        /**
         * USER ADMIN
         */
        $adminUser = User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Faisyal Nur',
            'email' => 'admin@scankucing.id',
            'password' => Hash::make('password123'),
        ]);

        /**
         * USER CLIENT
         */
        $clientUser = User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Budi Santoso',
            'email' => 'budi@scankucing.id',
            'password' => Hash::make('password123'),
        ]);

        /**
         * ROLE USER
         */
        DB::table('role_user')->insert([
            [
                'id' => (string) Str::uuid(),
                'user_id' => $adminUser->id,
                'role_id' => $adminRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'user_id' => $clientUser->id,
                'role_id' => $clientRoleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}