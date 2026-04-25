@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3" style="border-left:4px solid #1e3a5f!important">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#e8edf5">
                    <i class="bi bi-box-seam text-primary fs-5"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Aset</div>
                    <div class="fw-bold fs-4">{{ $total_aset }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="border-left:4px solid #27ae60!important">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#e9f7ef">
                    <i class="bi bi-check-circle text-success fs-5"></i>
                </div>
                <div>
                    <div class="text-muted small">Aset Aktif</div>
                    <div class="fw-bold fs-4 text-success">{{ $aset_aktif }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="border-left:4px solid #e74c3c!important">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#fdecea">
                    <i class="bi bi-tools text-danger fs-5"></i>
                </div>
                <div>
                    <div class="text-muted small">Aset Rusak</div>
                    <div class="fw-bold fs-4 text-danger">{{ $aset_rusak }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3" style="border-left:4px solid #f39c12!important">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;background:#fef9e7">
                    <i class="bi bi-arrow-left-right text-warning fs-5"></i>
                </div>
                <div>
                    <div class="text-muted small">Sedang Dipinjam</div>
                    <div class="fw-bold fs-4 text-warning">{{ $aset_dipinjam }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <div class="text-muted small mb-1">Total Kategori</div>
            <div class="fw-bold fs-3">{{ $total_kategori }}</div>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-primary mt-2">Kelola</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <div class="text-muted small mb-1">Total Lokasi</div>
            <div class="fw-bold fs-3">{{ $total_lokasi }}</div>
            <a href="{{ route('admin.lokasi.index') }}" class="btn btn-sm btn-outline-primary mt-2">Kelola</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <div class="text-muted small mb-1">Transaksi Aktif</div>
            <div class="fw-bold fs-3">{{ $transaksi_aktif }}</div>
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-outline-warning mt-2">Lihat</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Aset Terbaru</h6>
        <a href="{{ route('admin.aset.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Kode</th><th>Nama Aset</th><th>Kategori</th><th>Lokasi</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aset_terbaru as $aset)
                <tr>
                    <td><code>{{ $aset->kode_aset }}</code></td>
                    <td>{{ $aset->nama_aset }}</td>
                    <td>{{ $aset->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                    <td>
                        @if($aset->status === 'aktif')
                            <span class="badge badge-aktif px-2 py-1 rounded">Aktif</span>
                        @elseif($aset->status === 'rusak')
                            <span class="badge badge-rusak px-2 py-1 rounded">Rusak</span>
                        @else
                            <span class="badge badge-dipinjam px-2 py-1 rounded">Dipinjam</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada aset.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection