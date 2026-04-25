@extends('layouts.admin')
@section('title', 'Tambah Aset')
@section('page_title', 'Tambah Aset Baru')

@section('content')
<div class="card" style="max-width:760px">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-semibold">Form Tambah Aset</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.aset.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Kode Aset <span class="text-danger">*</span></label>
                    <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror"
                           value="{{ old('kode_aset') }}" placeholder="cth: AST-001" required>
                    @error('kode_aset')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Nama Aset <span class="text-danger">*</span></label>
                    <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror"
                           value="{{ old('nama_aset') }}" placeholder="cth: Laptop Dell Latitude" required>
                    @error('nama_aset')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Lokasi <span class="text-danger">*</span></label>
                    <select name="lokasi_id" class="form-select @error('lokasi_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($lokasis as $l)
                            <option value="{{ $l->id }}" {{ old('lokasi_id') == $l->id ? 'selected' : '' }}>
                                {{ $l->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                    @error('lokasi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Tanggal Beli <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_beli"
                           class="form-control @error('tanggal_beli') is-invalid @enderror"
                           value="{{ old('tanggal_beli') }}" required>
                    @error('tanggal_beli')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Nilai Aset (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="nilai_aset" step="1"
                           class="form-control @error('nilai_aset') is-invalid @enderror"
                           value="{{ old('nilai_aset') }}" placeholder="cth: 15000000" required>
                    @error('nilai_aset')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="aktif"    {{ old('status','aktif') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="rusak"    {{ old('status') === 'rusak'    ? 'selected' : '' }}>Rusak</option>
                        <option value="dipinjam" {{ old('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold small">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"
                              placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Aset
                </button>
                <a href="{{ route('admin.aset.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection