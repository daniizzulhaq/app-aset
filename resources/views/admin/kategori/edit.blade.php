@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0 fw-bold">Edit Kategori</h5>
                <small class="text-muted">{{ $kategori->nama_kategori }}</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.kategori.update', $kategori) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_kategori"
                               class="form-control @error('nama_kategori') is-invalid @enderror"
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                               placeholder="Nama kategori">
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Keterangan <span class="text-muted fw-normal">(opsional)</span>
                        </label>
                        <textarea name="keterangan" rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  placeholder="Deskripsi singkat kategori...">{{ old('keterangan', $kategori->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Info jumlah aset --}}
                    <div class="alert alert-light border d-flex align-items-center gap-2 mb-4" style="font-size:.85rem;">
                        <i class="bi bi-box-seam text-primary"></i>
                        Kategori ini digunakan oleh
                        <b>{{ $kategori->asets_count ?? $kategori->asets()->count() }} aset</b>.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection