@extends('layouts.admin')
@section('title', 'Detail Aset')
@section('page_title', 'Detail Aset')

@section('content')
<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-semibold">Informasi Aset</div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><th class="text-muted small" width="140">Kode Aset</th>
                        <td><code>{{ $aset->kode_aset }}</code></td></tr>
                    <tr><th class="text-muted small">Nama Aset</th>
                        <td class="fw-semibold">{{ $aset->nama_aset }}</td></tr>
                    <tr><th class="text-muted small">Kategori</th>
                        <td>{{ $aset->kategori->nama_kategori ?? '-' }}</td></tr>
                    <tr><th class="text-muted small">Lokasi</th>
                        <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td></tr>
                    <tr><th class="text-muted small">Tanggal Beli</th>
                        <td>{{ \Carbon\Carbon::parse($aset->tanggal_beli)->format('d F Y') }}</td></tr>
                    <tr><th class="text-muted small">Nilai Aset</th>
                        <td class="fw-semibold">Rp {{ number_format($aset->nilai_aset, 0, ',', '.') }}</td></tr>
                    <tr><th class="text-muted small">Status</th>
                        <td>
                            @if($aset->status === 'aktif')
                                <span class="badge badge-aktif px-2 py-1">Aktif</span>
                            @elseif($aset->status === 'rusak')
                                <span class="badge badge-rusak px-2 py-1">Rusak</span>
                            @else
                                <span class="badge badge-dipinjam px-2 py-1">Dipinjam</span>
                            @endif
                        </td></tr>
                    <tr><th class="text-muted small">Keterangan</th>
                        <td>{{ $aset->keterangan ?: '-' }}</td></tr>
                </table>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('admin.aset.edit', $aset) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <a href="{{ route('admin.aset.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white fw-semibold">Riwayat Transaksi</div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr><th>Peminjam</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($aset->transaksis as $t)
                        <tr>
                            <td>{{ $t->nama_peminjam }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ $t->tanggal_kembali ? \Carbon\Carbon::parse($t->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($t->status === 'dipinjam')
                                    <span class="badge badge-dipinjam px-2 py-1">Dipinjam</span>
                                @else
                                    <span class="badge badge-aktif px-2 py-1">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection