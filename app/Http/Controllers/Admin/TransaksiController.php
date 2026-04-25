<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Aset;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['aset', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->latest()->paginate(10)->withQueryString();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $asets = Aset::where('status', 'aktif')->get();
        return view('admin.transaksi.create', compact('asets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aset_id'       => 'required|exists:asets,id',
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_pinjam'=> 'required|date',
            'keterangan'    => 'nullable|string',
        ]);

        $aset = Aset::findOrFail($request->aset_id);

        if ($aset->status !== 'aktif') {
            return back()->with('error', 'Aset tidak tersedia untuk dipinjam.')->withInput();
        }

        Transaksi::create([
            'aset_id'        => $request->aset_id,
            'user_id'        => auth()->id(),
            'nama_peminjam'  => $request->nama_peminjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status'         => 'dipinjam',
            'keterangan'     => $request->keterangan,
        ]);

        $aset->update(['status' => 'dipinjam']);

        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Transaksi peminjaman berhasil dicatat.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['aset.kategori', 'aset.lokasi', 'user']);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function kembalikan(Transaksi $transaksi)
    {
        if ($transaksi->status === 'dikembalikan') {
            return back()->with('error', 'Aset sudah dikembalikan.');
        }

        $transaksi->update([
            'tanggal_kembali' => now()->toDateString(),
            'status'          => 'dikembalikan',
        ]);

        $transaksi->aset->update(['status' => 'aktif']);

        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Aset berhasil dikembalikan.');
    }
}