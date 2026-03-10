<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Cuti Pegawai Pemkab Bima</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

            /* Background foto kantor */
            background-image: url('{{ asset('images/kantor-bupati-bima.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            position: relative;
            padding: 1.5rem;
        }

        /* Overlay gelap di atas foto */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 0;
        }

        /* ── Login Card ── */
        .login-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
            padding: 2.5rem;
        }

        /* ── Logo ── */
        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-logo img {
            width: 75px; height: 75px;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,.2));
        }

        /* ── Judul ── */
        .login-title {
            text-align: center;
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: .3rem;
        }

        .login-subtitle {
            text-align: center;
            font-size: .82rem;
            color: #64748b;
            margin-bottom: 1.75rem;
        }

        /* ── Alert ── */
        .alert-box {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .75rem 1rem;
            border-radius: 10px;
            font-size: .83rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
        }

        .alert-box.success {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
        }

        .alert-box.error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }

        /* ── Form ── */
        .form-group { margin-bottom: 1.1rem; }

        .form-label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .4rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0; top: 0;
            width: 44px; height: 100%;
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8;
            border-right: 1px solid #e2e8f0;
            pointer-events: none;
            font-size: .95rem;
        }

        .form-input {
            width: 100%;
            height: 46px;
            padding-left: 54px;
            padding-right: 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            font-size: .875rem;
            font-family: inherit;
            color: #0f172a;
            transition: all .2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        .form-input::placeholder { color: #cbd5e1; }

        /* ── Toggle Password ── */
        .toggle-pass {
            position: absolute;
            right: 0; top: 0;
            width: 44px; height: 100%;
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8;
            cursor: pointer;
            font-size: .95rem;
            transition: color .2s;
        }

        .toggle-pass:hover { color: #2563eb; }

        /* ── Ingat Saya ── */
        .remember-wrap {
            display: flex; align-items: center; gap: .5rem;
            font-size: .82rem;
            color: #475569;
            margin-bottom: 1.5rem;
        }

        .remember-wrap input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        /* ── Tombol Login ── */
        .btn-login {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #1e40af, #2563eb);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: .9rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            cursor: pointer;
            transition: all .2s;
            font-family: inherit;
            box-shadow: 0 4px 16px rgba(37,99,235,.35);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37,99,235,.45);
        }

        .btn-login:active { transform: translateY(0); }

        /* ── Divider ── */
        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 1.5rem 0;
        }

        /* ── Info Default Login ── */
        .default-login {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: .9rem 1rem;
        }

        .default-login-title {
            font-size: .75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .06em;
            display: flex; align-items: center; gap: .4rem;
            margin-bottom: .6rem;
        }

        .default-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: .3rem 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: .78rem;
        }

        .default-row:last-child { border: none; padding-bottom: 0; }

        .default-role {
            font-weight: 600;
            color: #374151;
        }

        .default-cred {
            color: #64748b;
            font-family: monospace;
            font-size: .75rem;
        }

        /* ── Footer ── */
        .login-footer {
            text-align: center;
            margin-top: 1.25rem;
            font-size: .75rem;
            color: rgba(255,255,255,.5);
        }
    </style>
</head>
<body>

<div class="login-wrap">

    <div class="login-card">

        {{-- Logo --}}
        <div class="login-logo">
            <img src="{{ asset('images/logo-pemkab-bima.png') }}"
                 alt="Logo Pemkab Bima"
                 onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='flex';">
            <div id="logo-fallback"
                 style="display:none; width:70px; height:70px; background:linear-gradient(135deg,#1e40af,#2563eb);
                        border-radius:18px; margin:0 auto; align-items:center; justify-content:center;
                        font-size:1.8rem; color:#fff; box-shadow:0 4px 16px rgba(37,99,235,.4);">
                🏛️
            </div>
        </div>

        {{-- Judul --}}
        <h1 class="login-title">Sistem Cuti Pegawai</h1>
        <p class="login-subtitle">Sekretariat Daerah Kabupaten Bima</p>

        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="alert-box success">
                <i class="bi bi-check-circle-fill"></i>
                <span>Anda telah berhasil logout.</span>
            </div>
        @endif

        {{-- Alert Error --}}
        @if($errors->any())
            <div class="alert-box error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>Email atau password salah. Silakan coba lagi.</span>
            </div>
        @endif

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <div class="input-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <input type="email"
                           id="email"
                           class="form-input"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="pegawai@setda.go.id"
                           required autofocus>
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                    </div>
                    <input type="password"
                           id="password"
                           class="form-input"
                           name="password"
                           placeholder="••••••••"
                           style="padding-right:44px;"
                           required>
                    <div class="toggle-pass" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggle-icon"></i>
                    </div>
                </div>
            </div>

            {{-- Ingat Saya --}}
            <div class="remember-wrap">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya</label>
            </div>

            {{-- Tombol Login --}}
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk
            </button>

        </form>

        {{-- Divider --}}
        <div class="divider"></div>

        {{-- Info Default Login --}}
        <div class="default-login">
            <div class="default-login-title">
                <i class="bi bi-info-circle"></i> Default Login
            </div>
            <div class="default-row">
                <span class="default-role">Admin</span>
                <span class="default-cred">admin@setda.go.id / password</span>
            </div>
            <div class="default-row">
                <span class="default-role">Atasan</span>
                <span class="default-cred">atasan@setda.go.id / password</span>
            </div>
            <div class="default-row">
                <span class="default-role">Pegawai</span>
                <span class="default-cred">pegawai@setda.go.id / password</span>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="login-footer">
        &copy; {{ date('Y') }} Pemkab Bima — Sistem Cuti Pegawai
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle show/hide password
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('toggle-icon');

        if (input.type === 'password') {
            input.type   = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type   = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>

</body>
</html>