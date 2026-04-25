<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIM Aset PT. Toplan Fondamen Sukses</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy:   #0f2340;
            --navy-2: #1a3560;
            --blue:   #2563eb;
            --blue-l: #3b82f6;
            --gold:   #c9a84c;
            --text:   #1e293b;
            --muted:  #64748b;
            --border: #e2e8f0;
            --bg:     #f8fafc;
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* ── Layout ── */
        .page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ── Left panel ── */
        .left {
            background: var(--navy);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 56px 64px;
            position: relative;
            overflow: hidden;
        }
        .left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 110% 10%, rgba(37,99,235,.35) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at -10% 90%, rgba(201,168,76,.15) 0%, transparent 55%);
        }
        .left-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }
        .left > * { position: relative; z-index: 1; }

        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 42px; height: 42px;
            background: var(--gold);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: var(--navy);
        }
        .brand-name {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            color: #fff;
            line-height: 1.15;
        }
        .brand-sub { font-size: .72rem; color: rgba(255,255,255,.5); letter-spacing: .04em; }

        .hero-text { color: #fff; }
        .hero-text h1 {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2rem, 3vw, 2.8rem);
            line-height: 1.2;
            margin-bottom: 16px;
        }
        .hero-text h1 span { color: var(--gold); }
        .hero-text p {
            font-size: .92rem;
            color: rgba(255,255,255,.55);
            line-height: 1.7;
            max-width: 340px;
        }

        .stats { display: flex; gap: 32px; }
        .stat-item { color: rgba(255,255,255,.9); }
        .stat-num {
            font-family: 'DM Serif Display', serif;
            font-size: 1.75rem;
            color: #fff;
            line-height: 1;
        }
        .stat-lbl { font-size: .73rem; color: rgba(255,255,255,.45); margin-top: 3px; letter-spacing: .03em; }

        /* ── Right panel ── */
        .right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 64px;
            background: #fff;
        }
        .form-wrap { width: 100%; max-width: 380px; }

        .form-eyebrow {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--blue);
            margin-bottom: 8px;
        }
        .form-title {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            color: var(--navy);
            margin-bottom: 6px;
        }
        .form-sub { font-size: .88rem; color: var(--muted); margin-bottom: 36px; }

        /* inputs */
        .field { margin-bottom: 20px; }
        .field label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 7px;
            letter-spacing: .02em;
        }
        .input-wrap { position: relative; }
        .input-wrap .ico {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: .95rem;
            pointer-events: none;
            transition: color .2s;
        }
        .input-wrap input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            color: var(--text);
            background: var(--bg);
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .input-wrap input::placeholder { color: #a0aec0; }
        .input-wrap input:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }
        .input-wrap input:focus + .ico,
        .input-wrap input:focus ~ .ico { color: var(--blue); }
        .input-wrap .ico { left: 14px; }

        /* password toggle */
        .toggle-pw {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            cursor: pointer;
            font-size: .95rem;
            transition: color .2s;
        }
        .toggle-pw:hover { color: var(--blue); }

        /* alert */
        .alert-err {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .83rem;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* submit */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: .93rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
            transition: background .2s, transform .1s, box-shadow .2s;
            letter-spacing: .01em;
        }
        .btn-submit:hover {
            background: var(--navy-2);
            box-shadow: 0 6px 20px rgba(15,35,64,.25);
        }
        .btn-submit:active { transform: scale(.985); }

        .form-footer {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: .78rem;
            color: var(--muted);
        }
        .form-footer i { font-size: .85rem; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .page { grid-template-columns: 1fr; }
            .left { display: none; }
            .right { padding: 40px 28px; background: var(--bg); }
        }

        /* ── Enter animation ── */
        .form-wrap { animation: fadeUp .55s cubic-bezier(.22,1,.36,1) both; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .left .hero-text { animation: fadeUp .6s .1s cubic-bezier(.22,1,.36,1) both; }
        .left .stats     { animation: fadeUp .6s .2s cubic-bezier(.22,1,.36,1) both; }
    </style>
</head>
<body>

<div class="page">

    {{-- ── Left panel ── --}}
    <div class="left">
        <div class="left-grid"></div>

        <div class="brand">
            <div class="brand-icon"><i class="bi bi-building"></i></div>
            <div>
                <div class="brand-name">SIM Aset</div>
                <div class="brand-sub">PT. Toplan Fondamen Sukses</div>
            </div>
        </div>

        <div class="hero-text">
            <h1>Kelola Aset<br>Perusahaan dengan<br><span>Lebih Efisien</span></h1>
            <p>Sistem informasi manajemen aset terpadu untuk memantau, mencatat, dan mengoptimalkan seluruh aset perusahaan secara real-time.</p>
        </div>

        <div class="stats">
            <div class="stat-item">
                <div class="stat-num">100%</div>
                <div class="stat-lbl">Terintegrasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">Real‑time</div>
                <div class="stat-lbl">Pemantauan Aset</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">Aman</div>
                <div class="stat-lbl">Berbasis Peran</div>
            </div>
        </div>
    </div>

    {{-- ── Right panel ── --}}
    <div class="right">
        <div class="form-wrap">

            <div class="form-eyebrow">Selamat Datang</div>
            <div class="form-title">Masuk ke Akun</div>
            <div class="form-sub">Masukkan kredensial Anda untuk mengakses sistem.</div>

            @if($errors->any())
                <div class="alert-err">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="field">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope ico"></i>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@toplan.com"
                               required autofocus
                               class="@error('email') is-invalid @enderror">
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock ico"></i>
                        <input type="password" id="password" name="password"
                               placeholder="••••••••" required>
                        <span class="toggle-pw" onclick="togglePw()">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk ke Sistem
                </button>
            </form>

            <div class="form-footer">
                <i class="bi bi-shield-lock"></i>
                Akses dibatasi untuk pengguna yang berwenang
            </div>

        </div>
    </div>

</div>

<script>
function togglePw() {
    var pw  = document.getElementById('password');
    var ico = document.getElementById('eyeIcon');
    if (pw.type === 'password') {
        pw.type = 'text';
        ico.className = 'bi bi-eye-slash';
    } else {
        pw.type = 'password';
        ico.className = 'bi bi-eye';
    }
}
</script>

</body>
</html>