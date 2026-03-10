<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Cuti Pegawai Pemkab Bima</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* ============================================
           BACKGROUND FOTO KANTOR BUPATI BIMA
           ============================================ */
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            
            /* Background foto kantor */
            background-image: url('{{ asset('images/kantor-bupati-bima.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            
            /* Flexbox untuk center */
            display: flex;
            align-items: center;
            justify-content: center;
            
            /* Font */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            
            /* Overlay hitam agar form terbaca */
            position: relative;
        }
        
        /* Overlay gelap di atas foto */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* 40% gelap */
            z-index: -1;
        }

        /* ============================================
   KOTAK LOGIN TRANSPARAN
   ============================================ */
.login-container {
    /* Putih transparan 75% - foto kantor terlihat */
    background: rgba(255, 255, 255, 0.75);
    
    /* Blur lebih kuat agar teks tetap terbaca */
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    
    border-radius: 20px;
    /* Border tipis agar kotak terlihat jelas */
    border: 1px solid rgba(255, 255, 255, 0.5);
    
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    padding: 40px;
    width: 100%;
    max-width: 420px;
    margin: 20px;
    text-align: center;
}

        /* ============================================
           LOGO PEMKAB BIMA
           ============================================ */
        .logo-wrapper {
            margin-bottom: 20px;
        }

        .logo-wrapper img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        /* ============================================
           JUDUL
           ============================================ */
        .login-title {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
        }

        /* ============================================
           ALERT
           ============================================ */
        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
        }

        /* ============================================
           FORM INPUT (ICON DI KIRI)
           ============================================ */
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            display: block;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 45px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            border-right: 1px solid #e5e7eb;
            z-index: 10;
        }

        .form-control {
            width: 100%;
            height: 48px;
            padding-left: 55px;
            padding-right: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #f9fafb;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* ============================================
           CHECKBOX INGAT SAYA
           ============================================ */
        .remember-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }

        .remember-wrapper input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #3b82f6;
        }

        /* ============================================
           TOMBOL LOGIN (BIRU)
           ============================================ */
        .btn-login {
            width: 100%;
            height: 48px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* ============================================
           GARIS PEMISAH
           ============================================ */
        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 25px 0;
        }

        /* ============================================
           FOOTER DEFAULT LOGIN
           ============================================ */
        .default-login {
            color: #666;
            font-size: 13px;
            line-height: 1.8;
        }

        .default-login-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 10px;
            color: #666;
        }

        .default-login strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        
        <!-- Logo -->
        <div class="logo-wrapper">
            <img src="{{ asset('images/logo-pemkab-bima.png') }}" 
                 alt="Logo Pemkab Bima"
                 onerror="this.src='https://via.placeholder.com/80/1e5631/ffffff?text=LOGO'">
        </div>

        <!-- Judul -->
        <h1 class="login-title">Sistem Cuti Pegawai</h1>
        <p class="login-subtitle">Sekretariat Daerah Kabupaten Bima</p>

        <!-- Alert Success -->
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                <span>Anda telah berhasil logout.</span>
            </div>
        @endif

        <!-- Alert Error -->
        @if($errors->any())
            <div class="alert-success" style="background: #fee2e2; border-color: #fecaca; color: #991b1b;">
                <i class="fas fa-exclamation-circle"></i>
                <span>Email atau password salah!</span>
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-wrapper">
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" 
                           class="form-control" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="pegawai@setda.go.id" 
                           required>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" 
                           class="form-control" 
                           name="password" 
                           placeholder="••••••••" 
                           required>
                </div>
            </div>

            <!-- Ingat Saya -->
            <div class="remember-wrapper">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <!-- Tombol Login -->
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </button>
        </form>

        <!-- Garis Pemisah -->
        <div class="divider"></div>

        <!-- Default Login Info -->
        <div class="default-login">
            <div class="default-login-title">
                <i class="fas fa-info-circle"></i>
                <span>Default login:</span>
            </div>
            <div><strong>Admin:</strong> admin@setda.go.id / password</div>
            <div><strong>Atasan:</strong> atasan@setda.go.id / password</div>
            <div><strong>Pegawai:</strong> pegawai@setda.go.id / password</div>
        </div>

    </div>
</body>
</html>