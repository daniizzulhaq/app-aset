@extends('layouts.user')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-0">Detail Peminjaman</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.transaksi.index') }}">Transaksi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">

        {{-- Informasi Transaksi --}}
        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="fas fa-file-alt me-1 text-primary"></i> Informasi Transaksi
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted fw-normal">Nama Peminjam</dt>
                        <dd class="col-sm-8 fw-semibold">{{ $transaksi->nama_peminjam }}</dd>

                        <dt class="col-sm-4 text-muted fw-normal">Tanggal Pinjam</dt>
                        <dd class="col-sm-8">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">Tanggal Kembali</dt>
                        <dd class="col-sm-8">
                            @if ($transaksi->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->translatedFormat('d F Y') }}
                            @else
                                <span class="text-muted fst-italic">Belum dikembalikan</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">Status</dt>
                        <dd class="col-sm-8">
                            @if ($transaksi->status === 'dipinjam')
                                <span class="badge bg-warning text-dark fs-6">Dipinjam</span>
                            @elseif ($transaksi->status === 'dikembalikan')
                                <span class="badge bg-success fs-6">Dikembalikan</span>
                            @else
                                <span class="badge bg-secondary fs-6">{{ ucfirst($transaksi->status) }}</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">Keterangan</dt>
                        <dd class="col-sm-8">
                            {{ $transaksi->keterangan ?: '—' }}
                        </dd>

                        <dt class="col-sm-4 text-muted fw-normal">Dibuat Pada</dt>
                        <dd class="col-sm-8 text-muted small">
                            {{ $transaksi->created_at->translatedFormat('d F Y, H:i') }} WIB
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Informasi Aset --}}
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">
                    <i class="fas fa-box me-1 text-success"></i> Informasi Aset
                </div>
                <div class="card-body">
                    @if ($transaksi->aset)
                        <dl class="row mb-0">
                            <dt class="col-sm-5 text-muted fw-normal">Nama Aset</dt>
                            <dd class="col-sm-7 fw-semibold">{{ $transaksi->aset->nama_aset }}</dd>

                            <dt class="col-sm-5 text-muted fw-normal">Kode Aset</dt>
                            <dd class="col-sm-7">{{ $transaksi->aset->kode_aset ?? '—' }}</dd>

                            <dt class="col-sm-5 text-muted fw-normal">Kategori</dt>
                            <dd class="col-sm-7">
                                {{ $transaksi->aset->kategori->nama_kategori ?? '—' }}
                            </dd>

                            <dt class="col-sm-5 text-muted fw-normal">Lokasi</dt>
                            <dd class="col-sm-7">
                                {{ $transaksi->aset->lokasi->nama_lokasi ?? '—' }}
                            </dd>

                            <dt class="col-sm-5 text-muted fw-normal">Status Aset</dt>
                            <dd class="col-sm-7">
                                @php $statusAset = $transaksi->aset->status; @endphp
                                @if ($statusAset === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif ($statusAset === 'dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($statusAset) }}</span>
                                @endif
                            </dd>
                        </dl>

                        <div class="mt-3">
                            <a href="{{ route('user.aset.show', $transaksi->aset) }}"
                               class="btn btn-sm btn-outline-success">
                                <i class="fas fa-external-link-alt me-1"></i> Lihat Detail Aset
                            </a>
                        </div>
                    @else
                        <p class="text-muted fst-italic mb-0">Data aset tidak tersedia.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Back Button --}}
    <div class="mt-4">
        <a href="{{ route('user.transaksi.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

</div>
@endsection