@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page_title', 'Manajemen User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 fw-bold">Daftar Akun User</h5>
        <p class="text-muted mb-0" style="font-size:.85rem">Kelola semua akun admin dan user sistem.</p>
    </div>
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah User
    </a>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.user.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">CARI USER</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label mb-1" style="font-size:.8rem;font-weight:600;color:#6c757d;">ROLE</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4 text-muted" style="font-size:.85rem;">
                                {{ $users->firstItem() + $loop->index }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                         style="width:34px;height:34px;font-size:.8rem;
                                                background:{{ $user->role === 'admin' ? '#1e3a5f' : '#0d6efd' }}">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold" style="font-size:.9rem;">{{ $user->name }}</span>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-success" style="font-size:.65rem;">Anda</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-muted" style="font-size:.87rem;">{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge" style="background:#1e3a5f;font-size:.75rem;">
                                        <i class="bi bi-shield-fill me-1"></i>Admin
                                    </span>
                                @else
                                    <span class="badge bg-primary" style="font-size:.75rem;">
                                        <i class="bi bi-person-fill me-1"></i>User
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted" style="font-size:.85rem;">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('admin.user.edit', $user) }}"
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.user.destroy', $user) }}"
                                              onsubmit="return confirm('Hapus akun {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-danger" disabled title="Tidak dapat menghapus diri sendiri">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Belum ada user ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection