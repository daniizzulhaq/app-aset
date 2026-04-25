@extends('layouts.user')

@section('title', 'Detail Aset')
@section('page_title', 'Detail Aset')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('user.aset.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0 fw-bold">{{ $aset->nama_aset }}</h5>
                <small class="text-muted font-monospace">{{ $aset->kode_aset }}</small>
            </div>
            <div class="ms-auto">
                @if($aset->status === 'aktif')
                    <span class="badge badge-aktif px-3 py-2" style="font-size:.8rem;">
                        <i class="bi bi-check-circle me-1"></i>Aktif
                    </span>
                @elseif($aset->status === 'dipinjam')
                    <span class="badge badge-dipinjam px-3 py-2" style="font-size:.8rem;">
                        <i class="bi bi-arrow-up-right-circle me-1"></i>Dipinjam
                    </span>
                @else
                    <span class="badge badge-rusak px-3 py-2" style="font-size:.8rem;">
                        <i class="bi bi-exclamation-triangle me-1"></i>Rusak
                    </span>
                @endif
            </div>
        </div>

        {{-- Info Aset --}}
        <div class="card mb-3">
            <div class="card-header bg-white fw-semibold py-3" style="font-size:.9rem;">
                <i class="bi bi-box-seam me-2 text-primary"></i>Informasi Aset
            </div>
            <div class="card-body">
                <dl class="row mb-0" style="font-size:.88rem;">
                    <dt class="col-sm-4 text-muted">Nama Aset</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $aset->nama_aset }}</dd>

                    <dt class="col-sm-4 text-muted">Kode Aset</dt>
                    <dd class="col-sm-8 font-monospace">{{ $aset->kode_aset }}</dd>

                    <dt class="col-sm-4 text-muted">Kategori</dt>
                    <dd class="col-sm-8">{{ $aset->kategori->nama_kategori ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Lokasi</dt>
                    <dd class="col-sm-8">{{ $aset->lokasi->nama_lokasi ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Tanggal Perolehan</dt>
                    <dd class="col-sm-8">
                        {{ $aset->tanggal_perolehan
                            ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d M Y')
                            : '-' }}
                    </dd>

                    <dt class="col-sm-4 text-muted">Nilai Aset</dt>
                    <dd class="col-sm-8">
                        {{ $aset->nilai_aset
                            ? 'Rp ' . number_format($aset->nilai_aset, 0, ',', '.')
                            : '-' }}
                    </dd>

                    <dt class="col-sm-4 text-muted">Status</dt>
                    <dd class="col-sm-8">
                        @if($aset->status === 'aktif')
                            <span class="badge badge-aktif px-2 py-1">Aktif</span>
                        @elseif($aset->status === 'dipinjam')
                            <span class="badge badge-dipinjam px-2 py-1">Dipinjam</span>
                        @else
                            <span class="badge badge-rusak px-2 py-1">Rusak</span>
                        @endif
                    </dd>

                    @if($aset->keterangan)
                        <dt class="col-sm-4 text-muted">Keterangan</dt>
                        <dd class="col-sm-8">{{ $aset->keterangan }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Tombol Pinjam --}}
        @if($aset->status === 'aktif')
            <div class="card" style="border:1px solid #d4edda;background:#f8fff9;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-semibold" style="font-size:.9rem;">Aset ini tersedia untuk dipinjam</div>
                        <small class="text-muted">Klik tombol di samping untuk mengajukan peminjaman.</small>
                    </div>
                    <a href="{{ route('user.transaksi.create', ['aset_id' => $aset->id]) }}"
                       class="btn btn-success btn-sm px-3">
                        <i class="bi bi-arrow-up-right-circle me-1"></i> Pinjam Aset
                    </a>
                </div>
            </div>
        @elseif($aset->status === 'dipinjam')
            <div class="alert alert-warning d-flex align-items-center gap-2" style="border-radius:10px;">
                <i class="bi bi-clock-history fs-5"></i>
                <span style="font-size:.88rem;">Aset ini sedang dipinjam dan tidak tersedia saat ini.</span>
            </div>
        @else
            <div class="alert alert-danger d-flex align-items-center gap-2" style="border-radius:10px;">
                <i class="bi bi-exclamation-triangle fs-5"></i>
                <span style="font-size:.88rem;">Aset ini sedang dalam kondisi rusak dan tidak bisa dipinjam.</span>
            </div>
        @endif

    </div>
</div>
@endsection