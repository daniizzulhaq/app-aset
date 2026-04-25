@extends('layouts.admin')
@section('title', 'Data Aset')
@section('page_title', 'Data Aset')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.aset.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Cari</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Kode / Nama Aset" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Kategori</label>
                <select name="kategori_id" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Lokasi</label>
                <select name="lokasi_id" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($lokasis as $l)
                        <option value="{{ $l->id }}" {{ request('lokasi_id') == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="rusak"    {{ request('status') === 'rusak'    ? 'selected' : '' }}>Rusak</option>
                    <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.aset.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                <a href="{{ route('admin.aset.create') }}" class="btn btn-success btn-sm ms-auto">
                    <i class="bi bi-plus-lg me-1"></i>Tambah
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Aset</th>
                    <th>Nama Aset</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Tgl Beli</th>
                    <th>Nilai Aset</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asets as $i => $aset)
                <tr>
                    <td class="text-muted small">{{ $asets->firstItem() + $i }}</td>
                    <td><code>{{ $aset->kode_aset }}</code></td>
                    <td class="fw-semibold">{{ $aset->nama_aset }}</td>
                    <td>{{ $aset->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $aset->lokasi->nama_lokasi ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($aset->tanggal_beli)->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($aset->nilai_aset, 0, ',', '.') }}</td>
                    <td>
                        @if($aset->status === 'aktif')
                            <span class="badge badge-aktif px-2 py-1 rounded">Aktif</span>
                        @elseif($aset->status === 'rusak')
                            <span class="badge badge-rusak px-2 py-1 rounded">Rusak</span>
                        @else
                            <span class="badge badge-dipinjam px-2 py-1 rounded">Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.aset.show', $aset) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.aset.edit', $aset) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.aset.destroy', $aset) }}"
                              style="display:inline"
                              onsubmit="return confirm('Yakin hapus aset ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada data aset.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($asets->hasPages())
    <div class="card-footer bg-white">
        {{ $asets->links() }}
    </div>
    @endif
</div>
@endsection