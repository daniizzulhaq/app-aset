<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::withCount('asets')->latest()->paginate(10);
        return view('admin.lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255|unique:lokasis,nama_lokasi',
            'keterangan'  => 'nullable|string',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Lokasi $lokasi)
    {
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255|unique:lokasis,nama_lokasi,' . $lokasi->id,
            'keterangan'  => 'nullable|string',
        ]);

        $lokasi->update($request->all());

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi)
    {
        if ($lokasi->asets()->exists()) {
            return back()->with('error', 'Lokasi tidak bisa dihapus karena masih digunakan aset.');
        }

        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil dihapus.');
    }
}