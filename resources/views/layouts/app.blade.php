<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'KanbanEsitec')) - KanbanEsitec</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        display: ['Syne', 'sans-serif'],
                    },
                    colors: {
                        brand: { 50: '#eef8fb', 100: '#d7f0f3', 500: '#0f7fc7', 600: '#0b5f9f', 700: '#073f78' },
                        ink: { 900: '#09214a', 800: '#102b55', 700: '#203a63', 400: '#64748b', 200: '#cbd5e1', 100: '#e5eef5', 50: '#f6fafc' }
                    },
                }
            }
        }
    </script>

    <style>
        :root {
            --brand-blue:#0b5f9f;
            --brand-blue-soft:#eaf4fb;
            --brand-teal:#009e92;
            --brand-teal-dark:#00786f;
            --ink:#09214a;
            --muted:#64748b;
            --line:#dce8ef;
            --surface:#ffffff;
            --page:#f6fafc;
        }
        body { background-color:var(--page); }
        .navbar { background:rgba(255,255,255,.94); backdrop-filter:blur(10px); border-bottom:1px solid var(--line); }
        .brand-logo { display:block; width:auto; object-fit:contain; }
        .brand-logo-nav { height:88px; max-width:430px; }
        .brand-logo-auth { height:220px; max-width:760px; margin:0 auto; }
        .brand-logo-footer { height:70px; max-width:360px; opacity:.9; }
        .nav-link { color:var(--muted); font-size:.875rem; font-weight:500; padding:.375rem .75rem; border-radius:8px; transition:.15s; text-decoration:none; }
        .nav-link:hover { color:var(--ink); background:var(--brand-blue-soft); }
        .nav-link.active { color:var(--brand-blue); background:var(--brand-blue-soft); }
        .role-badge { font-size:.7rem; font-weight:600; letter-spacing:.05em; text-transform:uppercase; padding:2px 8px; border-radius:999px; }
        .avatar { width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--brand-blue),var(--brand-teal)); display:flex; align-items:center; justify-content:center; font-size:.8rem; font-weight:700; color:white; flex-shrink:0; }
        .flash { animation:slideDown .3s ease-out; }
        @keyframes slideDown { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
        .dropdown-menu { display:none; position:absolute; right:0; top:calc(100% + 8px); background:white; border:1px solid #e8e9f2; border-radius:12px; box-shadow:0 8px 24px rgba(14,15,26,.08); min-width:180px; z-index:50; overflow:hidden; }
        .dropdown-menu.open { display:block; }
        .dropdown-item { display:block; padding:.625rem 1rem; font-size:.875rem; color:#1a1b2e; text-decoration:none; transition:background .1s; }
        .dropdown-item:hover { background:#f5f5fb; }
        .dropdown-item.danger { color:#dc2626; }
        .dropdown-item.danger:hover { background:#fef2f2; }
        main { min-height:calc(100vh - 65px); }
    </style>

    @stack('styles')
</head>
<body class="font-sans text-ink-900 antialiased">
<nav class="navbar sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-[104px] flex items-center gap-6">
        <a href="{{ route('projects.index') }}" class="mr-2" style="text-decoration:none;" aria-label="KanbanEsitec">
            <img src="{{ asset('logo.png') }}" alt="KanbanEsitec" class="brand-logo brand-logo-nav">
        </a>

        @auth
            <div class="flex items-center gap-1">
                <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">Projets</a>
            </div>
        @endauth

        <div class="flex-1"></div>

        @auth
            <div class="flex items-center gap-3">
                @if(auth()->user()->isAdmin())
                    <span class="role-badge" style="background:#eaf4fb;color:#0b5f9f;">Admin</span>
                @else
                    <span class="role-badge" style="background:#e8f7f5;color:#00786f;">Membre</span>
                @endif

                <div class="relative" id="user-menu">
                    <button type="button" onclick="toggleDropdown()" class="flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-ink-100 transition-colors" style="border:none;background:none;cursor:pointer;">
                        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                        <span class="text-sm font-medium text-ink-800 hidden sm:block">{{ auth()->user()->name }}</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6b6d8a" stroke-width="2" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>

                    <div class="dropdown-menu" id="dropdown-menu">
                        <div style="padding:.75rem 1rem;border-bottom:1px solid #e8e9f2;">
                            <p class="text-xs font-medium text-ink-400">Session ouverte</p>
                            <p class="text-sm font-semibold text-ink-900 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">Mon profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item danger w-full text-left">Se déconnecter</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold px-4 py-2 rounded-xl text-white transition-all" style="background:var(--brand-teal);text-decoration:none;">S'inscrire</a>
            </div>
        @endauth
    </div>
</nav>

@if(session('success') || session('error') || session('warning'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-4">
        @foreach(['success' => '#166534', 'error' => '#991b1b', 'warning' => '#92400e'] as $type => $color)
            @if(session($type))
                <div class="flash flex items-center gap-3 px-4 py-3 rounded-xl mb-3" style="background:#fff;border:1px solid #e8e9f2;color:{{ $color }};">
                    <span class="text-sm font-medium">{{ session($type) }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="ml-auto" style="border:none;background:none;cursor:pointer;color:inherit;">x</button>
                </div>
            @endif
        @endforeach
    </div>
@endif

@isset($header)
    <header class="bg-white border-b border-ink-100">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{{ $header }}</div>
    </header>
@endisset

<main>
    @isset($slot)
        {{ $slot }}
    @else
        @yield('content')
    @endisset>
</main>

<footer style="border-top:1px solid #e8e9f2;margin-top:4rem;padding:1.5rem 0;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between">
        <img src="{{ asset('logo.png') }}" alt="KanbanEsitec" class="brand-logo brand-logo-footer">
        <span class="text-xs text-ink-400">Projet Laravel - {{ date('Y') }}</span>
    </div>
</footer>

<script>
    function toggleDropdown() {
        document.getElementById('dropdown-menu')?.classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('user-menu');
        const dropdown = document.getElementById('dropdown-menu');
        if (menu && dropdown && !menu.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });

    setTimeout(() => {
        document.querySelectorAll('.flash').forEach(el => {
            el.style.transition = 'opacity .4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        });
    }, 4000);
</script>

@stack('scripts')
</body>
</html>
