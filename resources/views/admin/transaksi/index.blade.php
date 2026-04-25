@extends('layouts.admin')

@section('title', 'Peminjaman Aset')
@section('page_title', 'Peminjaman Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 fw-bold">Daftar Peminjaman</h5>
        <p class="text-muted mb-0" style="font-size:.85rem">Kelola seluruh transaksi peminjaman aset.</p>
    </div>
    <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Catat Peminjaman
    </a>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.transaksi.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">STATUS</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="dipinjam"     {{ request('status') === 'dipinjam'     ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
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
                        <th>Aset</th>
                        <th>Nama Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                        <tr>
                            <td class="ps-4 text-muted" style="font-size:.85rem;">
                                {{ $transaksis->firstItem() + $loop->index }}
                            </td>
                            <td>
                                <div class="fw-semibold" style="font-size:.9rem;">{{ $t->aset->nama_aset ?? '-' }}</div>
                                <small class="text-muted">{{ $t->aset->kode_aset ?? '' }}</small>
                            </td>
                            <td style="font-size:.88rem;">{{ $t->nama_peminjam }}</td>
                            <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</td>
                            <td style="font-size:.85rem;">
                                {{ $t->tanggal_kembali ? \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') : '-' }}
                            </td>
                            <td>
                                @if($t->status === 'dipinjam')
                                    <span class="badge badge-dipinjam px-2 py-1" style="font-size:.75rem;">
                                        <i class="bi bi-arrow-up-right-circle me-1"></i>Dipinjam
                                    </span>
                                @else
                                    <span class="badge badge-aktif px-2 py-1" style="font-size:.75rem;">
                                        <i class="bi bi-check-circle me-1"></i>Dikembalikan
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('admin.transaksi.show', $t) }}"
                                       class="btn btn-sm btn-outline-secondary" title="Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @if($t->status === 'dipinjam')
                                        <form method="POST"
                                              action="{{ route('admin.transaksi.kembalikan', $t) }}"
                                              onsubmit="return confirm('Konfirmasi pengembalian aset {{ $t->aset->nama_aset ?? '' }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Kembalikan">
                                                <i class="bi bi-box-arrow-in-left"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-arrow-left-right fs-2 d-block mb-2"></i>
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transaksis->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $transaksis->links() }}
        </div>
    @endif
</div>
@endsection