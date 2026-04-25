@extends('layouts.user')

@section('title', 'Pinjam Aset')

@section('content')
<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-0">Pinjam Aset</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.transaksi.index') }}">Transaksi</a></li>
                <li class="breadcrumb-item active">Pinjam Aset</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">
                    <i class="fas fa-hand-holding-medical me-1 text-primary"></i> Form Peminjaman
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.transaksi.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Aset --}}
                        <div class="mb-3">
                            <label for="aset_id" class="form-label fw-semibold">
                                Aset <span class="text-danger">*</span>
                            </label>
                            <select name="aset_id" id="aset_id"
                                    class="form-select @error('aset_id') is-invalid @enderror">
                                <option value="">— Pilih Aset —</option>
                                @foreach ($asets as $aset)
                                    <option value="{{ $aset->id }}"
                                        {{ old('aset_id') == $aset->id ? 'selected' : '' }}>
                                        {{ $aset->nama_aset }}
                                        @if ($aset->kode_aset) ({{ $aset->kode_aset }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('aset_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($asets->isEmpty())
                                <div class="form-text text-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Tidak ada aset yang tersedia saat ini.
                                </div>
                            @endif
                        </div>

                        {{-- Nama Peminjam --}}
                        <div class="mb-3">
                            <label for="nama_peminjam" class="form-label fw-semibold">
                                Nama Peminjam <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_peminjam" id="nama_peminjam"
                                   class="form-control @error('nama_peminjam') is-invalid @enderror"
                                   value="{{ old('nama_peminjam', auth()->user()->name) }}"
                                   placeholder="Masukkan nama peminjam">
                            @error('nama_peminjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Pinjam --}}
                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label fw-semibold">
                                Tanggal Pinjam <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                   class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                   value="{{ old('tanggal_pinjam', date('Y-m-d')) }}">
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                      class="form-control @error('keterangan') is-invalid @enderror"
                                      placeholder="Tuliskan keperluan peminjaman (opsional)">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-1"></i> Kirim Permintaan
                            </button>
                            <a href="{{ route('user.transaksi.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection