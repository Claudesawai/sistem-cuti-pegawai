<div class="topbar">
    <div class="d-flex align-items-center">
        <button class="btn btn-link text-dark mobile-toggle me-3" onclick="toggleSidebar()">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
    </div>
    
    <div class="d-flex align-items-center gap-3">
        <span class="text-muted">
            <i class="bi bi-calendar3 me-2"></i>
            {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        </span>
    </div>
</div>
