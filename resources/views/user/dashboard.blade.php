@extends('layouts.user')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

{{-- Welcome --}}
<div class="mb-4">
    <h5 class="fw-bold mb-1">Selamat datang, {{ auth()->user()->name }} 👋</h5>
    <p class="text-muted mb-0" style="font-size:.88rem;">Berikut ringkasan informasi aset PT. Toplan Fondamen.</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100" style="background:#1e3a5f;color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="font-size:.75rem;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">Total Aset</p>
                        <h3 class="mb-0 fw-bold">{{ $total_aset }}</h3>
                    </div>
                    <div class="rounded-3 p-2" style="background:rgba(255,255,255,.15);">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100" style="background:#198754;color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="font-size:.75rem;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">Aset Aktif</p>
                        <h3 class="mb-0 fw-bold">{{ $aset_aktif }}</h3>
                    </div>
                    <div class="rounded-3 p-2" style="background:rgba(255,255,255,.2);">
                        <i class="bi bi-check-circle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100" style="background:#ffc107;color:#000;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="font-size:.75rem;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">Dipinjam</p>
                        <h3 class="mb-0 fw-bold">{{ $aset_dipinjam }}</h3>
                    </div>
                    <div class="rounded-3 p-2" style="background:rgba(0,0,0,.1);">
                        <i class="bi bi-arrow-up-right-circle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100" style="background:#0dcaf0;color:#000;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="font-size:.75rem;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">Peminjaman Saya</p>
                        <h3 class="mb-0 fw-bold">{{ $transaksi_saya }}</h3>
                    </div>
                    <div class="rounded-3 p-2" style="background:rgba(0,0,0,.1);">
                        <i class="bi bi-person-check fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Aset Terbaru --}}
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <span class="fw-semibold" style="font-size:.9rem;">
            <i class="bi bi-clock-history me-2 text-primary"></i>Aset Terbaru Ditambahkan
        </span>
        <a href="{{ route('user.aset.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Nama Aset</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aset_terbaru as $aset)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold" style="font-size:.9rem;">{{ $aset->nama_aset }}</div>
                                <small class="text-muted font-monospace">{{ $aset->kode_aset }}</small>
                            </td>
                            <td style="font-size:.85rem;">{{ $aset->kategori->nama_kategori ?? '-' }}</td>
                            <td style="font-size:.85rem;">{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                            <td>
                                @if($aset->status === 'aktif')
                                    <span class="badge badge-aktif px-2 py-1" style="font-size:.75rem;">Aktif</span>
                                @elseif($aset->status === 'dipinjam')
                                    <span class="badge badge-dipinjam px-2 py-1" style="font-size:.75rem;">Dipinjam</span>
                                @else
                                    <span class="badge badge-rusak px-2 py-1" style="font-size:.75rem;">Rusak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('user.aset.show', $aset) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada aset.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection