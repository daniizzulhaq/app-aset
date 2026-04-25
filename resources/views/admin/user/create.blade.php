@extends('layouts.admin')

@section('title', 'Tambah User')
@section('page_title', 'Tambah Akun User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0 fw-bold">Buat Akun User Baru</h5>
                <small class="text-muted">Admin membuat akun untuk pegawai / user sistem</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.user.store') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Contoh: Budi Santoso">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="contoh@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Role <span class="text-danger">*</span>
                        </label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="" disabled selected>-- Pilih Role --</option>
                            <option value="user"  {{ old('role') === 'user'  ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            <b>User</b>: hanya bisa lihat aset & ajukan peminjaman.
                            <b>Admin</b>: akses penuh ke semua fitur.
                        </div>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-3">

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 8 karakter">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Konfirmasi Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="passwordConfirm"
                                   class="form-control"
                                   placeholder="Ulangi password">
                            <button type="button" class="btn btn-outline-secondary" id="toggleConfirm">
                                <i class="bi bi-eye" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-person-plus me-1"></i> Buat Akun
                        </button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function toggleVisibility(inputId, iconId, btnId) {
        const btn = document.getElementById(btnId);
        btn.addEventListener('click', function () {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    }

    toggleVisibility('password',       'eyeIcon',        'togglePassword');
    toggleVisibility('passwordConfirm','eyeIconConfirm', 'toggleConfirm');
</script>
@endsection