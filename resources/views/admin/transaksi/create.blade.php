@extends('layouts.admin')

@section('title', 'Catat Peminjaman')
@section('page_title', 'Catat Peminjaman Aset')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0 fw-bold">Form Peminjaman Aset</h5>
                <small class="text-muted">Isi data peminjaman aset di bawah ini</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.transaksi.store') }}">
                    @csrf

                    {{-- Pilih Aset --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Aset <span class="text-danger">*</span>
                        </label>
                        <select name="aset_id" class="form-select @error('aset_id') is-invalid @enderror">
                            <option value="" disabled selected>-- Pilih Aset --</option>
                            @foreach($asets as $aset)
                                <option value="{{ $aset->id }}" {{ old('aset_id') == $aset->id ? 'selected' : '' }}>
                                    {{ $aset->nama_aset }} ({{ $aset->kode_aset }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Hanya menampilkan aset dengan status <b>Aktif</b>.</div>
                        @error('aset_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Peminjam --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Nama Peminjam <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_peminjam"
                               class="form-control @error('nama_peminjam') is-invalid @enderror"
                               value="{{ old('nama_peminjam') }}"
                               placeholder="Nama lengkap peminjam">
                        @error('nama_peminjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Pinjam --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Tanggal Pinjam <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_pinjam"
                               class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}">
                        @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Keterangan <span class="text-muted fw-normal">(opsional)</span>
                        </label>
                        <textarea name="keterangan" rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection