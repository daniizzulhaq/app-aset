<?php

namespace App\Http\Controllers\Admin;

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

        $asets      = $query->latest()->paginate(10)->withQueryString();
        $kategoris  = Kategori::all();
        $lokasis    = Lokasi::all();

        return view('admin.aset.index', compact('asets', 'kategoris', 'lokasis'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $lokasis   = Lokasi::all();
        return view('admin.aset.create', compact('kategoris', 'lokasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_aset'    => 'required|unique:asets,kode_aset',
            'nama_aset'    => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,id',
            'lokasi_id'    => 'required|exists:lokasis,id',
            'tanggal_beli' => 'required|date',
            'nilai_aset'   => 'required|numeric|min:0',
            'status'       => 'required|in:aktif,rusak,dipinjam',
        ]);

        Aset::create($request->all());

        return redirect()->route('admin.aset.index')
                         ->with('success', 'Aset berhasil ditambahkan.');
    }

    public function show(Aset $aset)
    {
        $aset->load(['kategori', 'lokasi', 'transaksis.user']);
        return view('admin.aset.show', compact('aset'));
    }

    public function edit(Aset $aset)
    {
        $kategoris = Kategori::all();
        $lokasis   = Lokasi::all();
        return view('admin.aset.edit', compact('aset', 'kategoris', 'lokasis'));
    }

    public function update(Request $request, Aset $aset)
    {
        $request->validate([
            'kode_aset'    => 'required|unique:asets,kode_aset,' . $aset->id,
            'nama_aset'    => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,id',
            'lokasi_id'    => 'required|exists:lokasis,id',
            'tanggal_beli' => 'required|date',
            'nilai_aset'   => 'required|numeric|min:0',
            'status'       => 'required|in:aktif,rusak,dipinjam',
        ]);

        $aset->update($request->all());

        return redirect()->route('admin.aset.index')
                         ->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Aset $aset)
    {
        if ($aset->transaksis()->exists()) {
            return back()->with('error', 'Aset tidak bisa dihapus karena memiliki transaksi.');
        }

        $aset->delete();

        return redirect()->route('admin.aset.index')
                         ->with('success', 'Aset berhasil dihapus.');
    }
}