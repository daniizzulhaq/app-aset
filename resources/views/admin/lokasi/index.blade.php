@extends('layouts.admin')

@section('title', 'Lokasi Aset')
@section('page_title', 'Lokasi Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted small">Total: {{ $lokasis->total() }} lokasi</span>
    <a href="{{ route('admin.lokasi.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Lokasi
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Lokasi</th>
                    <th>Keterangan</th>
                    <th>Jumlah Aset</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lokasis as $i => $l)
                <tr>
                    <td class="ps-4 text-muted small">{{ $lokasis->firstItem() + $i }}</td>
                    <td class="fw-semibold">
                        <i class="bi bi-geo-alt text-primary me-1"></i>{{ $l->nama_lokasi }}
                    </td>
                    <td class="text-muted">{{ $l->keterangan ?: '-' }}</td>
                    <td><span class="badge bg-primary">{{ $l->asets_count }}</span></td>
                    <td>
                        <a href="{{ route('admin.lokasi.edit', $l) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.lokasi.destroy', $l) }}"
                              style="display:inline"
                              onsubmit="return confirm('Yakin hapus lokasi {{ $l->nama_lokasi }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-geo-alt fs-2 d-block mb-2"></i>
                        Belum ada lokasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($lokasis->hasPages())
        <div class="card-footer bg-white">{{ $lokasis->links() }}</div>
    @endif
</div>
@endsection