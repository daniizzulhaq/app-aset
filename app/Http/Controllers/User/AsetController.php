<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    public function index(Request $request)
    {
        $query = Aset::with(['kategori', 'lokasi']);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_aset', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $request->search . '%');
            });
        }

        $asets     = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::all();
        $lokasis   = Lokasi::all();

        return view('user.aset.index', compact('asets', 'kategoris', 'lokasis'));
    }

    public function show(Aset $aset)
    {
        $aset->load(['kategori', 'lokasi']);
        return view('user.aset.show', compact('aset'));
    }
}