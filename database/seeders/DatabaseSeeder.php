<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Lokasi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@toplan.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'User Biasa',
            'email'    => 'user@toplan.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $kategoris = ['Kendaraan', 'Peralatan', 'Elektronik', 'Furnitur', 'Bangunan'];
        foreach ($kategoris as $k) {
            Kategori::create(['nama_kategori' => $k]);
        }

        $lokasis = ['Gudang', 'Kantor', 'Proyek A', 'Proyek B', 'Workshop'];
        foreach ($lokasis as $l) {
            Lokasi::create(['nama_lokasi' => $l]);
        }
    }
}