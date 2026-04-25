<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_aset'    => Aset::count(),
            'aset_aktif'    => Aset::where('status', 'aktif')->count(),
            'aset_rusak'    => Aset::where('status', 'rusak')->count(),
            'aset_dipinjam' => Aset::where('status', 'dipinjam')->count(),
            'transaksi_saya'=> Transaksi::where('user_id', auth()->id())->count(),
            'aset_terbaru'  => Aset::with(['kategori', 'lokasi'])->latest()->take(5)->get(),
        ];

        return view('user.dashboard', $data);
    }
}