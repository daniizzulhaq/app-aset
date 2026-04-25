@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Riwayat Peminjaman</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('user.transaksi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Pinjam Aset
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('user.transaksi.index') }}" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label class="col-form-label fw-semibold small">Filter Status:</label>
                </div>
                <div class="col-auto">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="dipinjam"   {{ request('status') === 'dipinjam'   ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                @if (request('status'))
                    <div class="col-auto">
                        <a href="{{ route('user.transaksi.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Reset
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Aset</th>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th class="text-center pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $transaksi)
                            <tr>
                                <td class="ps-3 text-muted small">
                                    {{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $transaksi->aset->nama_aset ?? '-' }}</div>
                                    <div class="text-muted small">{{ $transaksi->aset->kode_aset ?? '' }}</div>
                                </td>
                                <td>{{ $transaksi->nama_peminjam }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
                                <td>
                                    {{ $transaksi->tanggal_kembali
                                        ? \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y')
                                        : '<span class="text-muted">—</span>' }}
                                </td>
                                <td>
                                    @if ($transaksi->status === 'dipinjam')
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @elseif ($transaksi->status === 'dikembalikan')
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($transaksi->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center pe-3">
                                    <a href="{{ route('user.transaksi.show', $transaksi) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada transaksi peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($transaksis->hasPages())
            <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $transaksis->firstItem() }}–{{ $transaksis->lastItem() }}
                    dari {{ $transaksis->total() }} transaksi
                </small>
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>

</div>
@endsection