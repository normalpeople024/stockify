<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Stockify</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-sora {
            font-family: 'Sora', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0">
            <div class="h-16 flex items-center gap-3 px-5 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#1D9E75">
                    <span class="font-sora font-bold text-white text-sm">S</span>
                </div>
                <span class="font-sora font-semibold text-gray-800 text-lg">Stockify</span>
            </div>

            <div class="px-4 py-3 border-b border-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-xs font-semibold text-green-700">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700 truncate max-w-[130px]">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->role_label }}</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-0.5">
                @include('layouts.partials.sidebar-menu')
            </nav>

            <div class="p-3 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0">
                <div>
                    <h1 class="text-base font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-400">@yield('breadcrumb')</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-gray-400 hidden md:block">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                    @php $lowCount = \App\Models\Product::lowStock()->count(); @endphp
                    @if($lowCount > 0)
                    <div class="relative flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-amber-500 text-white text-xs rounded-full flex items-center justify-center">{{ $lowCount }}</span>
                    </div>
                    @endif
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-5 text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 16 16">
                        <path d="M2 8l4 4 8-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error') || $errors->any())
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm">
                    <svg class="w-4 h-4 mt-0.5" fill="none" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="7.25" stroke="currentColor" stroke-width="1.5" />
                        <path d="M8 4.5v4M8 10.5v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <div>
                        @if(session('error')){{ session('error') }}@endif
                        @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    @stack('scripts')
</body>

</html>