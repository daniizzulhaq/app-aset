@extends('layouts.admin')
@section('title', 'Kategori Aset')
@section('page_title', 'Kategori Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted small">Total: {{ $kategoris->total() }} kategori</span>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Nama Kategori</th><th>Keterangan</th><th>Jumlah Aset</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($kategoris as $i => $k)
                <tr>
                    <td class="text-muted small">{{ $kategoris->firstItem() + $i }}</td>
                    <td class="fw-semibold">{{ $k->nama_kategori }}</td>
                    <td class="text-muted">{{ $k->keterangan ?: '-' }}</td>
                    <td><span class="badge bg-primary">{{ $k->asets_count }}</span></td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $k) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.kategori.destroy', $k) }}"
                              style="display:inline"
                              onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kategoris->hasPages())
    <div class="card-footer bg-white">{{ $kategoris->links() }}</div>
    @endif
</div>
@endsection