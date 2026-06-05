<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jay-Mart') — Jay-Mart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-dark-900 text-slate-100 font-sans">
<div class="flex min-h-screen">

    {{-- ═══════ SIDEBAR ═══════ --}}
    <aside id="sidebar" class="w-64 bg-dark-800 border-r border-dark-400 flex flex-col fixed inset-y-0 left-0 z-50 overflow-y-auto">

        {{-- Brand --}}
        <div class="flex items-center gap-2.5 px-5 py-5 border-b border-dark-400">
            <div class="w-9 h-9 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center text-base shadow-md shadow-emerald-500/30 shrink-0">
                🏪
            </div>
            <span class="text-lg font-extrabold tracking-tight">Jay<span class="text-emerald-400">-Mart</span></span>
        </div>

        {{-- User Info --}}
        <div class="px-5 py-4 border-b border-dark-400">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-gradient-to-br from-emerald-700 to-emerald-900 rounded-full flex items-center justify-center text-sm font-bold shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-emerald-400 font-medium">{{ auth()->user()->role_label }}</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-3">
            @include('layouts.sidebar-nav')
        </nav>

        {{-- Logout --}}
        <div class="p-3 border-t border-dark-400">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm font-semibold
                           text-red-400 bg-red-500/8 border border-red-500/20
                           hover:bg-red-500/15 transition-all duration-200">
                    <i class="fas fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══════ MAIN CONTENT ═══════ --}}
    <div class="ml-64 flex-1 flex flex-col min-h-screen">

        {{-- Topbar --}}
        <header class="h-16 bg-dark-800 border-b border-dark-400 flex items-center justify-between px-6 sticky top-0 z-40">
            <div>
                <h2 class="text-base font-bold leading-tight">@yield('page-title', 'Dashboard')</h2>
                <p class="text-xs text-slate-400">@yield('page-subtitle', now()->translatedFormat('l, d F Y'))</p>
            </div>
            <div class="flex items-center gap-3">
                @if(auth()->user()->cabang)
                    <span class="badge-green">
                        <i class="fas fa-store text-[10px]"></i>
                        {{ auth()->user()->cabang->nama_cabang }}
                    </span>
                @else
                    <span class="badge-blue">
                        <i class="fas fa-globe text-[10px]"></i> Semua Cabang
                    </span>
                @endif
                <span id="realtime-clock" class="text-xs text-slate-500 font-mono">{{ now()->format('H:i:s') }} WIB</span>
            </div>
        </header>

        {{-- Page Body --}}
        <main class="flex-1 p-6">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert-success" id="flashMsg">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert-error" id="flashMsg">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="alert-warning" id="flashMsg">
                    <i class="fas fa-triangle-exclamation"></i> {{ session('warning') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@stack('scripts')
<script>
    const flash = document.getElementById('flashMsg');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.5s';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }, 4000);
    }

    // Realtime Clock
    setInterval(() => {
        const clock = document.getElementById('realtime-clock');
        if (clock) {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            clock.textContent = `${h}:${m}:${s} WIB`;
        }
    }, 1000);

    // Auto-refresh data secara berkala (tanpa reload penuh)
    setInterval(() => {
        const autoRefreshElements = document.querySelectorAll('.auto-refresh');
        if (autoRefreshElements.length > 0) {
            fetch(window.location.href)
                .then(res => res.text())
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    autoRefreshElements.forEach((el) => {
                        const id = el.getAttribute('id');
                        if (id) {
                            const newEl = doc.getElementById(id);
                            if (newEl) el.innerHTML = newEl.innerHTML;
                        }
                    });
                });
        }
    }, 10000); // 10 detik
</script>
</body>
</html>
