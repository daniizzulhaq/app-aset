<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Transaksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_aset'      => Aset::count(),
            'aset_aktif'      => Aset::where('status', 'aktif')->count(),
            'aset_rusak'      => Aset::where('status', 'rusak')->count(),
            'aset_dipinjam'   => Aset::where('status', 'dipinjam')->count(),
            'total_kategori'  => Kategori::count(),
            'total_lokasi'    => Lokasi::count(),
            'total_user'      => User::where('role', 'user')->count(),
            'transaksi_aktif' => Transaksi::where('status', 'dipinjam')->count(),
            'aset_terbaru'    => Aset::with(['kategori', 'lokasi'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}