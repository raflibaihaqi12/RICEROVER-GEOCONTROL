<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('passwordadmin'), // Jangan lupa untuk mengganti password ini pada saat produksi
                'alamat' => 'Jl. Contoh No. 1, Jakarta',
                'avatar' => null, // Bisa ditambahkan path gambar avatar jika ada
                'role' => 'admin',
                'nama_kelompok_tani' => null,
                'nomor_kartu_tani' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'username' => 'reguleruser',
                'password' => Hash::make('passwordreguleruser'), // Jangan lupa untuk mengganti password ini pada saat produksi
                'alamat' => 'Jl. Contoh No. 2, Bandung',
                'avatar' => null, // Bisa ditambahkan path gambar avatar jika ada
                'role' => 'user',
                'nama_kelompok_tani' => 'kelompok tani 1',
                'nomor_kartu_tani' => '123123123',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
