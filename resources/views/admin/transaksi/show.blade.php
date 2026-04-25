@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page_title', 'Detail Transaksi Peminjaman')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Back + Header --}}
        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0 fw-bold">Detail Transaksi</h5>
                <small class="text-muted">Informasi lengkap peminjaman aset</small>
            </div>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3">

            {{-- Informasi Transaksi --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-transparent py-2 px-3">
                        <span class="fw-semibold" style="font-size:.88rem;">
                            <i class="bi bi-file-text me-1 text-primary"></i> Informasi Transaksi
                        </span>
                    </div>
                    <div class="card-body p-3">
                        <dl class="row mb-0" style="font-size:.88rem;">

                            <dt class="col-5 text-muted fw-normal">Status</dt>
                            <dd class="col-7">
                                @if ($transaksi->status === 'dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @elseif ($transaksi->status === 'dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($transaksi->status) }}
                                    </span>
                                @endif
                            </dd>

                            <dt class="col-5 text-muted fw-normal">Nama Peminjam</dt>
                            <dd class="col-7 fw-semibold">{{ $transaksi->nama_peminjam }}</dd>

                            <dt class="col-5 text-muted fw-normal">Tgl. Pinjam</dt>
                            <dd class="col-7">
                                {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->translatedFormat('d F Y') }}
                            </dd>

                            <dt class="col-5 text-muted fw-normal">Tgl. Kembali</dt>
                            <dd class="col-7">
                                @if ($transaksi->tanggal_kembali)
                                    {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->translatedFormat('d F Y') }}
                                @else
                                    <span class="text-muted fst-italic">Belum dikembalikan</span>
                                @endif
                            </dd>

                            <dt class="col-5 text-muted fw-normal">Keterangan</dt>
                            <dd class="col-7">{{ $transaksi->keterangan ?: '—' }}</dd>

                            <dt class="col-5 text-muted fw-normal">Dicatat Oleh</dt>
                            <dd class="col-7">{{ $transaksi->user->name ?? '—' }}</dd>

                            <dt class="col-5 text-muted fw-normal">Dibuat Pada</dt>
                            <dd class="col-7 text-muted">
                                {{ $transaksi->created_at->translatedFormat('d F Y, H:i') }}
                            </dd>

                        </dl>
                    </div>
                </div>
            </div>

            {{-- Informasi Aset --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-transparent py-2 px-3">
                        <span class="fw-semibold" style="font-size:.88rem;">
                            <i class="bi bi-box-seam me-1 text-success"></i> Informasi Aset
                        </span>
                    </div>
                    <div class="card-body p-3">
                        @if ($transaksi->aset)
                            <dl class="row mb-0" style="font-size:.88rem;">

                                <dt class="col-5 text-muted fw-normal">Nama Aset</dt>
                                <dd class="col-7 fw-semibold">{{ $transaksi->aset->nama_aset }}</dd>

                                <dt class="col-5 text-muted fw-normal">Kode Aset</dt>
                                <dd class="col-7">{{ $transaksi->aset->kode_aset ?? '—' }}</dd>

                                <dt class="col-5 text-muted fw-normal">Kategori</dt>
                                <dd class="col-7">
                                    {{ $transaksi->aset->kategori->nama_kategori ?? '—' }}
                                </dd>

                                <dt class="col-5 text-muted fw-normal">Lokasi</dt>
                                <dd class="col-7">
                                    {{ $transaksi->aset->lokasi->nama_lokasi ?? '—' }}
                                </dd>

                                <dt class="col-5 text-muted fw-normal">Status Aset</dt>
                                <dd class="col-7">
                                    @php $statusAset = $transaksi->aset->status; @endphp
                                    @if ($statusAset === 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif ($statusAset === 'dipinjam')
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($statusAset) }}
                                        </span>
                                    @endif
                                </dd>

                            </dl>

                            <div class="mt-3">
                                <a href="{{ route('admin.aset.show', $transaksi->aset) }}"
                                   class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Detail Aset
                                </a>
                            </div>
                        @else
                            <p class="text-muted fst-italic mb-0" style="font-size:.88rem;">
                                Data aset tidak tersedia.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Kembalikan Action --}}
        @if ($transaksi->status === 'dipinjam')
            <div class="card mt-3 border-warning">
                <div class="card-body py-3 px-3 d-flex align-items-center justify-content-between">
                    <div style="font-size:.88rem;">
                        <i class="bi bi-exclamation-triangle text-warning me-1"></i>
                        Aset ini belum dikembalikan. Proses pengembalian jika aset sudah diterima kembali.
                    </div>
                    <form action="{{ route('admin.transaksi.kembalikan', $transaksi) }}"
                          method="POST"
                          onsubmit="return confirm('Konfirmasi pengembalian aset ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-warning ms-3">
                            <i class="bi bi-arrow-return-left me-1"></i> Kembalikan Aset
                        </button>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection