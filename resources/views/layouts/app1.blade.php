<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ \App\Models\AppSetting::get('app_name', 'Stockify') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@400;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-sora {
            font-family: 'Sora', sans-serif;
        }

        /* ── Background body dengan subtle pattern ── */
        body {
            background-color: #F0F2F5;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(29, 158, 117, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.03) 0%, transparent 40%);
        }

        /* ── Sidebar ── */
        #sidebar {
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.06);
            border-right: 1px solid rgba(0, 0, 0, 0.06);
        }

        /* ── Topbar ── */
        .topbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 1px 12px rgba(0, 0, 0, 0.05);
        }

        /* ── Card default lebih berkedalaman ── */
        .card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 16px rgba(0, 0, 0, 0.04);
        }

        /* ── Stat card hover ── */
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        /* ── Nav active glow ── */
        .nav-active {
            box-shadow: 0 2px 12px rgba(29, 158, 117, 0.3);
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #E5E7EB;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #D1D5DB;
        }

        /* ── Overlay transition ── */
        #sidebar-overlay {
            transition: opacity 0.25s ease;
        }

        /* ── Sidebar logo area ── */
        .sidebar-logo {
            background: linear-gradient(135deg, #f8fffe 0%, #f0faf6 100%);
            border-bottom: 1px solid rgba(29, 158, 117, 0.08);
        }

        /* ── User area di sidebar ── */
        .sidebar-user {
            background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        }
    </style>
    @stack('styles')
</head>

<body class="overflow-hidden">

    <div class="flex h-screen">

        {{-- ── OVERLAY (mobile) ── --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/40 opacity-0 pointer-events-none lg:hidden"
            onclick="closeSidebar()">
        </div>

        {{-- ── SIDEBAR ── --}}
        <aside id="sidebar"
            class="fixed lg:relative z-40 inset-y-0 left-0
                  w-64 flex flex-col flex-shrink-0
                  -translate-x-full lg:translate-x-0">

            {{-- Logo --}}
            <div class="sidebar-logo h-16 flex items-center justify-between px-4 flex-shrink-0">
                <div class="flex items-center gap-3">
                    @php
                        $logo = \App\Models\AppSetting::get('app_logo');
                        $appName = \App\Models\AppSetting::get('app_name', 'Stockify');
                    @endphp
                    @if ($logo)
                        <img src="{{ asset('storage/' . $logo) }}" class="w-8 h-8 object-contain rounded-xl">
                    @else
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm"
                            style="background: linear-gradient(135deg, #1D9E75, #0F6E56)">
                            <span class="font-sora font-bold text-white text-sm">
                                {{ strtoupper(substr($appName, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                    <span class="font-sora font-semibold text-gray-800 text-lg truncate">{{ $appName }}</span>
                </div>

                {{-- Tutup (mobile) --}}
                <button onclick="closeSidebar()"
                    class="lg:hidden w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            {{-- User info --}}
            <div class="sidebar-user px-4 py-3 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0 shadow-sm"
                        style="background: linear-gradient(135deg, #1D9E75, #0F6E56)">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-700 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->role_label }}</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-0.5">
                @include('layouts.partials.sidebar')
            </nav>

            {{-- Logout --}}
            <div class="p-3 flex-shrink-0" style="border-top: 1px solid rgba(0,0,0,0.06)">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-500
                           hover:bg-red-50 hover:text-red-600 transition text-sm font-medium group">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- ── MAIN CONTENT ── --}}
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            {{-- Topbar --}}
            <header class="topbar h-16 flex items-center justify-between px-4 sm:px-6 flex-shrink-0 relative z-20">
                <div class="flex items-center gap-3">

                    {{-- Hamburger (mobile) --}}
                    <button onclick="openSidebar()"
                        class="lg:hidden w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-sm sm:text-base font-semibold text-gray-800 leading-tight">
                            @yield('page-title', 'Dashboard')
                        </h1>
                        <p class="text-xs text-gray-400 hidden sm:block">@yield('breadcrumb')</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Tanggal --}}
                    <span class="text-xs text-gray-400 hidden md:block">
                        {{ now()->isoFormat('dddd, D MMMM Y') }}
                    </span>

                    {{-- Notif stok menipis --}}
                    @php
                        $lowCount =
                            \App\Models\AppSetting::get('low_stock_alert', '1') === '1'
                                ? \App\Models\Product::lowStock()->count()
                                : 0;
                    @endphp
                    @if ($lowCount > 0)
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.products.index', ['low_stock' => 1]) : '#' }}"
                            class="relative flex items-center justify-center w-9 h-9 rounded-xl text-amber-600 transition"
                            style="background: linear-gradient(135deg, #FFF8EC, #FEF3C7); box-shadow: 0 1px 4px rgba(245,158,11,0.2)">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <path
                                    d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <span
                                class="absolute -top-1 -right-1 w-4 h-4 text-white text-[10px] font-bold rounded-full flex items-center justify-center"
                                style="background: linear-gradient(135deg, #F59E0B, #D97706)">
                                {{ $lowCount > 9 ? '9+' : $lowCount }}
                            </span>
                        </a>
                    @endif

                    {{-- User dropdown --}}
                    <div class="relative" id="user-menu-wrap">
                        <button onclick="toggleUserMenu()"
                            class="flex items-center gap-2 h-9 px-2 sm:px-3 rounded-xl hover:bg-gray-100 transition">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                style="background: linear-gradient(135deg, #1D9E75, #0F6E56)">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden sm:block max-w-[120px] truncate">
                                {{ auth()->user()->name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div id="user-menu"
                            class="hidden absolute right-0 top-12 w-52 bg-white rounded-2xl overflow-hidden z-50"
                            style="box-shadow: 0 8px 32px rgba(0,0,0,0.12); border: 1px solid rgba(0,0,0,0.06)">
                            <div class="px-4 py-3" style="border-bottom: 1px solid rgba(0,0,0,0.06)">
                                <p class="text-xs font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ auth()->user()->role_label }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="p-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="px-4 sm:px-6 pt-4 space-y-2 flex-shrink-0">
                @if (session('success'))
                    <div id="flash-success"
                        class="flex items-center gap-3 text-green-700 rounded-xl px-4 py-3 text-sm"
                        style="background: linear-gradient(135deg, #F0FDF6, #DCFCE7); border: 1px solid rgba(34,197,94,0.2); box-shadow: 0 1px 8px rgba(34,197,94,0.1)">
                        <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 16 16">
                                <path d="M2 8l4 4 8-8" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <span class="flex-1 font-medium">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 16 16">
                                <path d="M4 4l8 8M4 12L12 4" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error') || $errors->any())
                    <div id="flash-error" class="flex items-start gap-3 text-red-700 rounded-xl px-4 py-3 text-sm"
                        style="background: linear-gradient(135deg, #FFF5F5, #FEE2E2); border: 1px solid rgba(239,68,68,0.2); box-shadow: 0 1px 8px rgba(239,68,68,0.1)">
                        <div
                            class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="7.25" stroke="currentColor"
                                    stroke-width="1.5" />
                                <path d="M8 4.5v4M8 10.5v1" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            @if (session('error'))
                                <p class="font-medium">{{ session('error') }}</p>
                            @endif
                            @foreach ($errors->all() as $e)
                                <p>{{ $e }}</p>
                            @endforeach
                        </div>
                        <button onclick="this.parentElement.remove()"
                            class="text-red-400 hover:text-red-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 16 16">
                                <path d="M4 4l8 8M4 12L12 4" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 flex flex-col">
                <div class="flex-1">
                    @yield('content')
                </div>

                {{-- ── FOOTER ── --}}
                <footer class="mt-8 pt-4" style="border-top: 1px solid rgba(0,0,0,0.06)">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-2">

                        {{-- Kiri: Logo + Copyright --}}
                        <div class="flex items-center gap-2">
                            @php
                                $appName = \App\Models\AppSetting::get('app_name', 'Stockify');
                                $compName = \App\Models\AppSetting::get('company_name', '');
                                $appLogo = \App\Models\AppSetting::get('app_logo');
                                $initial = strtoupper(substr($appName, 0, 1));
                            @endphp

                            {{-- Logo Dinamis (sama seperti login & sidebar) --}}
                            @if ($appLogo)
                                <img src="{{ asset('storage/' . $appLogo) }}" alt="{{ $appName }}"
                                    class="w-5 h-5 object-contain rounded-md"
                                    style="background: #fff; padding: 2px; border: 1px solid #e5e7eb;">
                            @else
                                <div class="w-5 h-5 rounded-md flex items-center justify-center flex-shrink-0"
                                    style="background: linear-gradient(135deg, #1D9E75, #0F6E56)">
                                    <span class="text-white font-bold" style="font-size:9px">
                                        {{ $initial }}
                                    </span>
                                </div>
                            @endif

                            <p class="text-xs text-gray-400">
                                &copy; {{ date('Y') }}
                                <span class="font-medium text-gray-500">{{ $compName ?: $appName }}</span>
                                · Semua hak dilindungi
                            </p>
                        </div>

                        {{-- Kanan: info versi + role --}}
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400">
                                Login sebagai
                                <span class="font-semibold text-gray-500">{{ auth()->user()->role_label }}</span>
                            </span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full"
                                style="background: linear-gradient(135deg,#F0FDF6,#DCFCE7); color:#166534; border:1px solid rgba(34,197,94,0.15)">
                                {{ $appName }} v1.0
                            </span>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script>
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebar();
                document.body.style.overflow = '';
            }
        });

        function toggleUserMenu() {
            document.getElementById('user-menu').classList.toggle('hidden');
        }

        document.addEventListener('click', (e) => {
            const wrap = document.getElementById('user-menu-wrap');
            if (wrap && !wrap.contains(e.target)) {
                document.getElementById('user-menu')?.classList.add('hidden');
            }
        });

        setTimeout(() => {
            document.getElementById('flash-success')?.remove();
            document.getElementById('flash-error')?.remove();
        }, 5000);
    </script>
    @stack('scripts')
</body>

</html>
