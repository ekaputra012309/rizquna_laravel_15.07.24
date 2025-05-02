<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'putra940616@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admindemo'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Rizquna',
                'email' => 'rizqunamekkahmadinahjkt@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('roles')->insert([
            ['kode_role' => 'superadmin', 'nama_role' => 'Super Admin', 'user_id' => 1],
            ['kode_role' => 'admin', 'nama_role' => 'Administrator', 'user_id' => 1],
            ['kode_role' => 'marketing', 'nama_role' => 'Marketing', 'user_id' => 1],
            ['kode_role' => 'finance', 'nama_role' => 'Finance', 'user_id' => 1],
            ['kode_role' => 'visa', 'nama_role' => 'Visa', 'user_id' => 1],
        ]);

        DB::table('cabang')->insert([
            ['nama_cabang' => 'Jakarta', 'user_id' => 1],
            ['nama_cabang' => 'Makasar', 'user_id' => 1],
            ['nama_cabang' => 'Balik Papan', 'user_id' => 1],
        ]);

        DB::table('privilages')->insert([
            ['role_id' => 1, 'user_id' => 1, 'cabang_id' => null],
            ['role_id' => 2, 'user_id' => 2, 'cabang_id' => null],
        ]);
    }
}
