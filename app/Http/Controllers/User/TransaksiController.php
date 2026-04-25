<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Aset;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['aset', 'user'])
                          ->where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->latest()->paginate(10)->withQueryString();
        return view('user.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $asets = Aset::where('status', 'aktif')->get();
        return view('user.transaksi.create', compact('asets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aset_id'        => 'required|exists:asets,id',
            'nama_peminjam'  => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'keterangan'     => 'nullable|string',
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

        return redirect()->route('user.transaksi.index')
                         ->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }

    public function show(Transaksi $transaksi)
    {
        if ($transaksi->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $transaksi->load(['aset.kategori', 'aset.lokasi', 'user']);
        return view('user.transaksi.show', compact('transaksi'));
    }
}