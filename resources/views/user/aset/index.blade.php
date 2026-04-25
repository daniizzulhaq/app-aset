@extends('layouts.user')

@section('title', 'Data Aset')
@section('page_title', 'Data Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 fw-bold">Daftar Aset</h5>
        <p class="text-muted mb-0" style="font-size:.85rem">Lihat seluruh aset PT. Toplan Fondamen.</p>
    </div>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('user.aset.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">CARI</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Nama / kode aset..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">KATEGORI</label>
                <select name="kategori_id" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">LOKASI</label>
                <select name="lokasi_id" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($lokasis as $l)
                        <option value="{{ $l->id }}" {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">STATUS</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="rusak"    {{ request('status') === 'rusak'    ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                <a href="{{ route('user.aset.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th class="text-center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asets as $aset)
                        <tr>
                            <td class="ps-4 text-muted" style="font-size:.85rem;">
                                {{ $asets->firstItem() + $loop->index }}
                            </td>
                            <td class="font-monospace" style="font-size:.82rem;">{{ $aset->kode_aset }}</td>
                            <td class="fw-semibold" style="font-size:.9rem;">{{ $aset->nama_aset }}</td>
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                                Tidak ada aset ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($asets->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $asets->links() }}
        </div>
    @endif
</div>
@endsection