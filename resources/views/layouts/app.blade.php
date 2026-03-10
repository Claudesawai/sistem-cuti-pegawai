<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Cuti Pegawai') - Pemkab Bima</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════
           ROOT VARIABLES
        ═══════════════════════════════════════ */
        :root {
            --primary:        #2563eb;
            --primary-dark:   #1d4ed8;
            --primary-light:  #dbeafe;
            --primary-glow:   rgba(37, 99, 235, 0.15);
            --success:        #10b981;
            --warning:        #f59e0b;
            --danger:         #ef4444;
            --secondary:      #64748b;

            --navy:           #0f172a;
            --navy-mid:       #1e293b;
            --navy-light:     #334155;

            --bg:             #f1f5f9;
            --surface:        #ffffff;
            --surface-2:      #f8fafc;
            --border:         #e2e8f0;
            --text:           #0f172a;
            --text-muted:     #64748b;
            --text-light:     #94a3b8;

            --sidebar-width:  265px;
            --topbar-height:  65px;

            --radius:         14px;
            --radius-sm:      10px;
            --radius-xs:      8px;

            --shadow-sm:      0 1px 3px rgba(0,0,0,.06), 0 1px 8px rgba(0,0,0,.04);
            --shadow:         0 2px 8px rgba(0,0,0,.07), 0 4px 20px rgba(0,0,0,.05);
            --shadow-lg:      0 8px 32px rgba(0,0,0,.10), 0 2px 8px rgba(0,0,0,.06);
        }

        /* ═══════════════════════════════════════
           BASE
        ═══════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════ */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--navy-mid) 0%, var(--navy) 100%);
            color: white;
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Scrollbar sidebar */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 99px; }

        /* Logo / Header */
        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            flex-shrink: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            width: 40px; height: 40px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.15rem; color: white;
            box-shadow: 0 4px 14px rgba(37,99,235,.4);
            flex-shrink: 0;
        }

        .sidebar-brand-text .title {
            font-size: .875rem;
            font-weight: 700;
            color: #f1f5f9;
            line-height: 1.2;
        }

        .sidebar-brand-text .subtitle {
            font-size: .7rem;
            color: #475569;
            font-weight: 400;
        }

        /* Nav */
        .sidebar-menu {
            padding: .75rem 0;
            flex: 1;
        }

        .sidebar-section-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #475569;
            padding: .75rem 1.25rem .4rem;
        }

        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .7rem 1.25rem;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: .85rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all .2s ease;
            margin: 1px 0;
        }

        .sidebar-menu .nav-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-menu .nav-link:hover {
            color: #e2e8f0;
            background: rgba(255,255,255,.05);
            border-left-color: rgba(37,99,235,.5);
        }

        .sidebar-menu .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(37,99,235,.2), rgba(37,99,235,.06));
            border-left-color: var(--primary);
        }

        .sidebar-menu .nav-link.active i {
            color: #60a5fa;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,.07);
            margin: .5rem 1.25rem;
        }

        /* Footer User */
        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem .75rem;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,.05);
            margin-bottom: .75rem;
        }

        .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .8rem; color: white;
            flex-shrink: 0;
        }

        .user-details { flex: 1; min-width: 0; }

        .user-name {
            font-weight: 600;
            font-size: .8rem;
            color: #e2e8f0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: .68rem;
            color: #60a5fa;
            font-weight: 500;
            text-transform: capitalize;
        }

        .btn-logout {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            padding: .55rem;
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.2);
            border-radius: var(--radius-xs);
            color: #fca5a5;
            font-size: .8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
            font-family: inherit;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: rgba(239,68,68,.2);
            color: #fca5a5;
        }

        /* ═══════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════ */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin .3s ease;
            display: flex;
            flex-direction: column;
        }

        /* ═══════════════════════════════════════
           TOPBAR
        ═══════════════════════════════════════ */
        .topbar {
            background: var(--surface);
            height: var(--topbar-height);
            padding: 0 2rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: var(--shadow-sm);
        }

        .topbar-left { display: flex; align-items: center; gap: 1rem; }

        .page-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text);
            margin: 0;
        }

        .topbar-right { display: flex; align-items: center; gap: .75rem; }

        .topbar-date {
            display: flex; align-items: center; gap: .5rem;
            font-size: .78rem;
            color: var(--text-muted);
            font-weight: 500;
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: .45rem 1rem;
            border-radius: 30px;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: 1px solid var(--border);
            border-radius: var(--radius-xs);
            padding: .4rem .6rem;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 1.1rem;
            transition: all .2s;
        }

        .mobile-toggle:hover {
            background: var(--surface-2);
            color: var(--text);
        }

        /* ═══════════════════════════════════════
           CONTENT WRAPPER
        ═══════════════════════════════════════ */
        .content-wrapper {
            padding: 1.75rem 2rem;
            flex: 1;
        }

        /* ═══════════════════════════════════════
           STAT CARDS
        ═══════════════════════════════════════ */
        .stat-card {
            background: var(--surface);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: transform .25s ease, box-shadow .25s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .stat-card.primary::before { background: linear-gradient(90deg, #2563eb, #60a5fa); }
        .stat-card.success::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-card.warning::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .stat-card.danger::before  { background: linear-gradient(90deg, #ef4444, #f87171); }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-icon.primary { background: #eff6ff; color: var(--primary); }
        .stat-icon.success { background: #ecfdf5; color: var(--success); }
        .stat-icon.warning { background: #fffbeb; color: var(--warning); }
        .stat-icon.danger  { background: #fef2f2; color: var(--danger);  }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
            margin-bottom: .35rem;
        }

        .stat-label {
            font-size: .8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ═══════════════════════════════════════
           CARDS
        ═══════════════════════════════════════ */
        .card {
            border: 1px solid var(--border) !important;
            border-radius: var(--radius) !important;
            box-shadow: var(--shadow-sm) !important;
            background: var(--surface);
        }

        .card-header {
            background: var(--surface) !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 1.1rem 1.5rem !important;
            border-radius: var(--radius) var(--radius) 0 0 !important;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .card-title::before {
            content: '';
            width: 4px; height: 18px;
            background: var(--primary);
            border-radius: 99px;
            display: inline-block;
        }

        .card-body { padding: 1.5rem !important; }

        /* ═══════════════════════════════════════
           TABLES
        ═══════════════════════════════════════ */
        .table-container {
            background: var(--surface);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .table { margin-bottom: 0; }

        .table thead th {
            background: var(--surface-2);
            border-bottom: 2px solid var(--border);
            font-weight: 600;
            color: var(--text-muted);
            padding: .9rem 1rem;
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .table tbody td {
            padding: .9rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
            font-size: .875rem;
            color: var(--text);
        }

        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover { background: var(--surface-2); }

        /* ═══════════════════════════════════════
           BADGES
        ═══════════════════════════════════════ */
        .badge {
            padding: .4rem .85rem;
            border-radius: 99px;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .02em;
        }

        .badge-warning { background: rgba(245,158,11,.12); color: #b45309; }
        .badge-success { background: rgba(16,185,129,.12); color: #047857; }
        .badge-danger  { background: rgba(239,68,68,.12);  color: #b91c1c; }
        .badge-info    { background: rgba(37,99,235,.12);  color: #1d4ed8; }

        /* ═══════════════════════════════════════
           BUTTONS
        ═══════════════════════════════════════ */
        .btn {
            padding: .55rem 1.1rem;
            border-radius: var(--radius-xs);
            font-weight: 600;
            font-size: .85rem;
            transition: all .2s ease;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37,99,235,.3);
        }

        .btn-success {
            background: var(--success);
            border-color: var(--success);
        }

        .btn-success:hover {
            background: #059669;
            border-color: #059669;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: var(--danger);
            border-color: var(--danger);
        }

        .btn-danger:hover {
            background: #dc2626;
            border-color: #dc2626;
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            transform: translateY(-1px);
        }

        /* ═══════════════════════════════════════
           FORMS
        ═══════════════════════════════════════ */
        .form-label {
            font-weight: 600;
            font-size: .83rem;
            color: var(--text);
            margin-bottom: .4rem;
        }

        .form-control, .form-select {
            border-radius: var(--radius-xs);
            border: 1.5px solid var(--border);
            padding: .6rem .9rem;
            font-size: .875rem;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
            outline: none;
        }

        .form-control::placeholder { color: var(--text-light); }

        /* ═══════════════════════════════════════
           ALERTS
        ═══════════════════════════════════════ */
        .alert {
            border: none;
            border-radius: var(--radius-sm);
            padding: .875rem 1.25rem;
            font-size: .875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .alert-success {
            background: rgba(16,185,129,.1);
            color: #047857;
            border-left: 4px solid var(--success) !important;
        }

        .alert-danger {
            background: rgba(239,68,68,.1);
            color: #b91c1c;
            border-left: 4px solid var(--danger) !important;
        }

        .alert-warning {
            background: rgba(245,158,11,.1);
            color: #92400e;
            border-left: 4px solid var(--warning) !important;
        }

        .alert-info {
            background: rgba(37,99,235,.08);
            color: #1e40af;
            border-left: 4px solid var(--primary) !important;
        }

        /* ═══════════════════════════════════════
           LOGIN PAGE
        ═══════════════════════════════════════ */
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 60%, #1e3a5f 100%);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .login-page::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.15), transparent 70%);
            top: -200px; right: -200px;
        }

        .login-page::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(124,58,237,.12), transparent 70%);
            bottom: -150px; left: -100px;
        }

        .login-card {
            background: var(--surface);
            border-radius: 20px;
            box-shadow: 0 24px 64px rgba(0,0,0,.35);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255,255,255,.08);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .login-logo-icon {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            border-radius: 20px;
            display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 2rem; color: white;
            box-shadow: 0 8px 24px rgba(37,99,235,.4);
            margin-bottom: 1.25rem;
        }

        .login-title {
            text-align: center;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: .35rem;
        }

        .login-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: .85rem;
            margin-bottom: 2rem;
        }

        /* ═══════════════════════════════════════
           EMPTY STATE
        ═══════════════════════════════════════ */
        .empty-state {
            text-align: center;
            padding: 3.5rem 2rem;
        }

        .empty-state-icon {
            width: 72px; height: 72px;
            background: var(--surface-2);
            border-radius: 20px;
            display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 2rem;
            color: var(--text-light);
            margin-bottom: 1.25rem;
        }

        .empty-state h5 {
            font-size: .95rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .5rem;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: .85rem;
            max-width: 260px;
            margin: 0 auto;
        }

        /* ═══════════════════════════════════════
           PAGINATION
        ═══════════════════════════════════════ */
        .pagination { margin-bottom: 0; }

        .page-link {
            border: 1px solid var(--border);
            color: var(--primary);
            padding: .45rem .8rem;
            font-size: .83rem;
            font-weight: 500;
            font-family: inherit;
            transition: all .2s;
        }

        .page-link:hover { background: var(--primary-light); border-color: var(--primary); }
        .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }
        .page-item.disabled .page-link { color: var(--text-light); }

        /* ═══════════════════════════════════════
           ANIMATIONS
        ═══════════════════════════════════════ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-in { animation: fadeUp .45s ease forwards; }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: flex !important; align-items: center; }
            .content-wrapper { padding: 1.25rem; }
            .topbar { padding: 0 1.25rem; }
        }

        @media (min-width: 992px) {
            .mobile-toggle { display: none !important; }
        }
    </style>

    @yield('styles')
</head>
<body>

@auth
    @include('layouts.sidebar')

    <div class="main-content">
        @include('layouts.topbar')

        <div class="content-wrapper fade-in">

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Alert Error --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

        </div>
    </div>

@else
    @yield('content')
@endauth

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Auto-hide alerts setelah 5 detik
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
            setTimeout(function () {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    // Mobile sidebar toggle
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('show');
    }
</script>

@yield('scripts')
</body>
</html>