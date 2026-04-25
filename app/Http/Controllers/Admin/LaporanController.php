<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Eager load transaksi aktif (dipinjam) sekaligus
        $query = Aset::with([
            'kategori',
            'lokasi',
            'transaksis' => fn($q) => $q->latest()->limit(1),
        ]);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $asets       = $query->latest()->get();
        $kategoris   = Kategori::all();
        $lokasis     = Lokasi::all();
        $total_nilai = $asets->sum('nilai_aset');

        if ($request->filled('export')) {
            return $this->exportPdf($asets, $total_nilai, $request);
        }

        return view('admin.laporan.index', compact('asets', 'kategoris', 'lokasis', 'total_nilai'));
    }

    private function exportPdf($asets, $total_nilai, Request $request)
    {
        $filterKategori = null;
        $filterLokasi   = null;
        $filterStatus   = null;

        if ($request->filled('kategori_id')) {
            $k = Kategori::find($request->kategori_id);
            $filterKategori = $k ? $k->nama_kategori : null;
        }
        if ($request->filled('lokasi_id')) {
            $l = Lokasi::find($request->lokasi_id);
            $filterLokasi = $l ? $l->nama_lokasi : null;
        }
        if ($request->filled('status')) {
            $filterStatus = $request->status;
        }

        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'asets',
            'total_nilai',
            'filterKategori',
            'filterLokasi',
            'filterStatus'
        ))->setPaper('a4', 'landscape');

        $filename = 'Laporan_Aset_' . Carbon::now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}