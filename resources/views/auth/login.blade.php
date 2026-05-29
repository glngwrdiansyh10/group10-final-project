<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Jay-Mart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-dark-900 flex items-center justify-center relative overflow-hidden">

    {{-- Background glow effects --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500/8 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    {{-- Login Card --}}
    <div class="relative z-10 w-full max-w-md mx-4">
        <div class="bg-dark-700 border border-dark-400 rounded-2xl p-10 shadow-2xl">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-emerald-500/30 text-3xl">
                    🏪
                </div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">
                    Jay<span class="text-emerald-400">-Mart</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1">Sistem Informasi Mini Market</p>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope text-emerald-500 mr-1.5"></i>Email
                    </label>
                    <input
                        id="email" type="email" name="email"
                        class="form-input @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                        placeholder="contoh@jaymart.id"
                        value="{{ old('email') }}"
                        autofocus autocomplete="email"
                    >
                    @error('email')
                        <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="form-label" for="password">
                        <i class="fas fa-lock text-emerald-500 mr-1.5"></i>Password
                    </label>
                    <div class="relative">
                        <input
                            id="password" type="password" name="password"
                            class="form-input pr-11 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >
                        <button type="button" onclick="togglePwd()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input id="remember" type="checkbox" name="remember"
                        class="w-4 h-4 accent-emerald-500 rounded">
                    <label for="remember" class="text-sm text-slate-400 cursor-pointer">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
                    <i class="fas fa-right-to-bracket"></i> Masuk
                </button>
            </form>

            <p class="text-center text-xs text-slate-600 mt-6">
                &copy; {{ date('Y') }} Jay-Mart. Hak cipta dilindungi.
            </p>
        </div>
    </div>

    <script>
    function togglePwd() {
        const p = document.getElementById('password');
        const i = document.getElementById('eyeIcon');
        p.type = p.type === 'password' ? 'text' : 'password';
        i.className = p.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    }
    </script>
</body>
</html>
