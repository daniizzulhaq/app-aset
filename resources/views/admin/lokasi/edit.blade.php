@extends('layouts.admin')

@section('title', 'Edit Lokasi')
@section('page_title', 'Edit Lokasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('admin.lokasi.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0 fw-bold">Edit Lokasi</h5>
                <small class="text-muted">{{ $lokasi->nama_lokasi }}</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.lokasi.update', $lokasi) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Nama Lokasi <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_lokasi"
                               class="form-control @error('nama_lokasi') is-invalid @enderror"
                               value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}"
                               placeholder="Nama lokasi">
                        @error('nama_lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Keterangan <span class="text-muted fw-normal">(opsional)</span>
                        </label>
                        <textarea name="keterangan" rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  placeholder="Deskripsi singkat lokasi...">{{ old('keterangan', $lokasi->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Info jumlah aset --}}
                    <div class="alert alert-light border d-flex align-items-center gap-2 mb-4" style="font-size:.85rem;">
                        <i class="bi bi-box-seam text-primary"></i>
                        Lokasi ini digunakan oleh
                        <b>{{ $lokasi->asets_count ?? $lokasi->asets()->count() }} aset</b>.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.lokasi.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection