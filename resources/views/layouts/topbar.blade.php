<div class="topbar">

    {{-- ══════════ KIRI: Toggle + Judul Halaman ══════════ --}}
    <div class="topbar-left">

        {{-- Tombol toggle untuk mobile --}}
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>

        {{-- Judul halaman (diisi dari masing-masing blade) --}}
        <div>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        </div>

    </div>

    {{-- ══════════ KANAN: Sapaan + Tanggal ══════════ --}}
    <div class="topbar-right">

        {{-- Sapaan otomatis pagi/siang/sore/malam --}}
        <span style="font-size: .8rem; color: var(--text-muted); font-weight: 500;">
            @php
                $jam = now()->hour;
                if ($jam >= 5 && $jam < 12) {
                    $sapaan = '🌤️ Selamat Pagi';
                } elseif ($jam >= 12 && $jam < 15) {
                    $sapaan = '☀️ Selamat Siang';
                } elseif ($jam >= 15 && $jam < 18) {
                    $sapaan = '🌤️ Selamat Sore';
                } else {
                    $sapaan = '🌙 Selamat Malam';
                }
            @endphp
            {{ $sapaan }}, <strong style="color: var(--text);">{{ auth()->user()->name }}</strong>
        </span>

        {{-- Pemisah --}}
        <div style="width: 1px; height: 20px; background: var(--border);"></div>

        {{-- Tanggal --}}
        <div class="topbar-date">
            <i class="bi bi-calendar3"></i>
            {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        </div>

    </div>

</div>