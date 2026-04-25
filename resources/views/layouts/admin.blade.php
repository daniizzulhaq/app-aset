<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — SIM Aset PT. Toplan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: #1e3a5f;
            width: 250px;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }
        .sidebar .brand {
            padding: 20px 16px;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: 10px 20px;
            border-radius: 6px;
            margin: 2px 8px;
            font-size: .9rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,.15);
            color: #fff;
        }
        .sidebar .nav-section {
            padding: 12px 20px 4px;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: rgba(255,255,255,.4);
        }
        .main-content {
            margin-left: 250px;
            padding: 0;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 12px 24px;
        }
        .page-content { padding: 24px; }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); border-radius: 10px; }
        .stat-card { border-radius: 12px; border: none; }
        .badge-aktif    { background: #d4edda; color: #155724; }
        .badge-rusak    { background: #f8d7da; color: #721c24; }
        .badge-dipinjam { background: #fff3cd; color: #856404; }
        .table th { font-size: .82rem; text-transform: uppercase; color: #6c757d; background: #f8f9fa; }
        .btn-sm { font-size: .8rem; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar d-flex flex-column">
    <div class="brand">
        <i class="bi bi-building me-2"></i> PT. Toplan Fondamen
    </div>
    <nav class="mt-2 flex-grow-1">
        <div class="nav-section">Menu</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <div class="nav-section">Master Data</div>
        <a href="{{ route('admin.aset.index') }}"
           class="nav-link {{ request()->routeIs('admin.aset.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam me-2"></i> Data Aset
        </a>
        <a href="{{ route('admin.kategori.index') }}"
           class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
            <i class="bi bi-tags me-2"></i> Kategori
        </a>
        <a href="{{ route('admin.lokasi.index') }}"
           class="nav-link {{ request()->routeIs('admin.lokasi.*') ? 'active' : '' }}">
            <i class="bi bi-geo-alt me-2"></i> Lokasi
        </a>

        <div class="nav-section">Transaksi</div>
        <a href="{{ route('admin.transaksi.index') }}"
           class="nav-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right me-2"></i> Peminjaman
        </a>

        <div class="nav-section">Laporan</div>
        <a href="{{ route('admin.laporan.index') }}"
           class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Aset
        </a>
    </nav>
    <a href="{{ route('admin.user.index') }}"
   class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
    <i class="bi bi-people me-2"></i> Manajemen User
</a>
    <div class="p-3 border-top" style="border-color:rgba(255,255,255,.1)!important">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm w-100" style="background:rgba(255,255,255,.1);color:#fff;">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>
</div>

{{-- MAIN --}}
<div class="main-content">
    <div class="topbar d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold text-secondary">@yield('page_title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle text-secondary"></i>
            <small class="text-secondary">{{ auth()->user()->name }}</small>
            <span class="badge bg-primary">Admin</span>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>