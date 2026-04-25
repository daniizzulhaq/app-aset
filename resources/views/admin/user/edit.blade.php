@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Edit Akun User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

        <div class="d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0 fw-bold">Edit Akun: {{ $user->name }}</h5>
                <small class="text-muted">Kosongkan password jika tidak ingin mengubah password</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.user.update', $user) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
                               placeholder="Nama lengkap">
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
                               value="{{ old('email', $user->email) }}"
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
                        <select name="role" class="form-select @error('role') is-invalid @enderror"
                                {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="user"  {{ old('role', $user->role) === 'user'  ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @if($user->id === auth()->id())
                            {{-- Kirim tetap via hidden jika disabled --}}
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Tidak dapat mengubah role akun sendiri.
                            </div>
                        @endif
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-3">
                    <p class="text-muted" style="font-size:.82rem;">
                        <i class="bi bi-info-circle me-1"></i>
                        Kosongkan field password di bawah jika tidak ingin mengubah password.
                    </p>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Kosongkan jika tidak diubah">
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
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="passwordConfirm"
                                   class="form-control"
                                   placeholder="Ulangi password baru">
                            <button type="button" class="btn btn-outline-secondary" id="toggleConfirm">
                                <i class="bi bi-eye" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
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
        document.getElementById(btnId).addEventListener('click', function () {
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
    toggleVisibility('password',        'eyeIcon',        'togglePassword');
    toggleVisibility('passwordConfirm', 'eyeIconConfirm', 'toggleConfirm');
</script>
@endsection