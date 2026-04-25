@extends('layouts.admin')

@section('title', 'Laporan Aset')
@section('page_title', 'Laporan Aset')

@section('content')

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card h-100" style="background:#1e3a5f;color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="font-size:.78rem;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">Total Aset</p>
                        <h3 class="mb-0 fw-bold">{{ $asets->count() }}</h3>
                    </div>
                    <div class="rounded-3 p-2" style="background:rgba(255,255,255,.15);">
                        <i class="bi bi-box-seam fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100" style="background:#198754;color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="font-size:.78rem;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">Aktif</p>
                        <h3 class="mb-0 fw-bold">{{ $asets->where('status','aktif')->count() }}</h3>
                    </div>
                    <div class="rounded-3 p-2" style="background:rgba(255,255,255,.2);">
                        <i class="bi bi-check-circle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100" style="background:#ffc107;color:#000;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="font-size:.78rem;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">Dipinjam</p>
                        <h3 class="mb-0 fw-bold">{{ $asets->where('status','dipinjam')->count() }}</h3>
                    </div>
                    <div class="rounded-3 p-2" style="background:rgba(0,0,0,.1);">
                        <i class="bi bi-arrow-up-right-circle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100" style="background:#dc3545;color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="font-size:.78rem;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">Rusak</p>
                        <h3 class="mb-0 fw-bold">{{ $asets->where('status','rusak')->count() }}</h3>
                    </div>
                    <div class="rounded-3 p-2" style="background:rgba(255,255,255,.2);">
                        <i class="bi bi-exclamation-triangle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Total Nilai --}}
<div class="card mb-4" style="border-left:4px solid #1e3a5f;">
    <div class="card-body py-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-currency-dollar fs-5 text-primary"></i>
            <span class="fw-semibold" style="font-size:.9rem;">Total Nilai Aset (hasil filter)</span>
        </div>
        <span class="fw-bold fs-5" style="color:#1e3a5f;">
            Rp {{ number_format($total_nilai, 0, ',', '.') }}
        </span>
    </div>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.laporan.index') }}" id="filterForm" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">KATEGORI</label>
                <select name="kategori_id" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">LOKASI</label>
                <select name="lokasi_id" class="form-select form-select-sm">
                    <option value="">Semua Lokasi</option>
                    @foreach($lokasis as $l)
                        <option value="{{ $l->id }}" {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">STATUS</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="rusak"    {{ request('status') === 'rusak'    ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
                <button type="button" class="btn btn-outline-danger btn-sm"
                    onclick="var f=document.createElement('form');f.method='GET';f.action='{{ route('admin.laporan.index') }}';['kategori_id','lokasi_id','status'].forEach(function(n){var el=document.querySelector('[name='+n+']');var i=document.createElement('input');i.type='hidden';i.name=n;i.value=el?el.value:'';f.appendChild(i);});var e=document.createElement('input');e.type='hidden';e.name='export';e.value='1';f.appendChild(e);document.body.appendChild(f);f.submit();">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                </button>
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
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Nilai Aset</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asets as $i => $aset)
                        @php $t = $aset->transaksis->first(); @endphp
                        <tr>
                            <td class="ps-4 text-muted" style="font-size:.85rem;">{{ $i + 1 }}</td>
                            <td class="font-monospace" style="font-size:.82rem;">{{ $aset->kode_aset }}</td>
                            <td class="fw-semibold" style="font-size:.9rem;">{{ $aset->nama_aset }}</td>
                            <td style="font-size:.85rem;">{{ $aset->kategori->nama_kategori ?? '-' }}</td>
                            <td style="font-size:.85rem;">{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                            <td style="font-size:.85rem;">
                                {{ $t?->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y')
                                    : '-' }}
                            </td>
                            <td style="font-size:.85rem;">
                                {{ $t?->tanggal_kembali
                                    ? \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y')
                                    : '-' }}
                            </td>
                            <td style="font-size:.85rem;">
                                @if($aset->nilai_aset)
                                    Rp {{ number_format($aset->nilai_aset, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($aset->status === 'aktif')
                                    <span class="badge badge-aktif px-2 py-1" style="font-size:.75rem;">Aktif</span>
                                @elseif($aset->status === 'dipinjam')
                                    <span class="badge badge-dipinjam px-2 py-1" style="font-size:.75rem;">Dipinjam</span>
                                @else
                                    <span class="badge badge-rusak px-2 py-1" style="font-size:.75rem;">Rusak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-bar-graph fs-2 d-block mb-2"></i>
                                Tidak ada data aset ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($asets->count() > 0)
                <tfoot>
                    <tr style="background:#f8f9fa;">
                        <td colspan="7" class="ps-4 fw-semibold text-end pe-3" style="font-size:.85rem;">
                            Total Nilai ({{ $asets->count() }} aset):
                        </td>
                        <td class="fw-bold" style="color:#1e3a5f;font-size:.88rem;">
                            Rp {{ number_format($total_nilai, 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection