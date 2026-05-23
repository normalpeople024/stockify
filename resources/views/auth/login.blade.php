<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — {{ $settings['app_name'] ?? 'Stockify' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }

        /* ── Background dengan pola dekoratif ── */
        .login-bg {
            background-color: #0D4F3C;
            background-image:
                radial-gradient(ellipse at 0% 0%, rgba(29,158,117,0.5) 0%, transparent 50%),
                radial-gradient(ellipse at 100% 100%, rgba(6,78,59,0.8) 0%, transparent 50%),
                radial-gradient(ellipse at 100% 0%, rgba(16,185,129,0.2) 0%, transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Lingkaran dekoratif besar di background */
        .login-bg::before {
            content: '';
            position: absolute;
            top: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(29,158,117,0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-bg::after {
            content: '';
            position: absolute;
            bottom: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Grid dot pattern */
        .dot-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        /* Card login */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 900px;
            background: rgba(255,255,255,0.98);
            border-radius: 24px;
            overflow: hidden;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.1),
                0 32px 80px rgba(0,0,0,0.35),
                0 8px 24px rgba(0,0,0,0.2);
        }

        /* Panel kiri */
        .left-panel {
            background: linear-gradient(145deg, #0F6E56 0%, #1D9E75 45%, #059669 100%);
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(0,0,0,0.08);
        }

        /* Garis dekoratif di panel kiri */
        .left-lines {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(135deg, rgba(255,255,255,0.03) 25%, transparent 25%),
                linear-gradient(225deg, rgba(255,255,255,0.03) 25%, transparent 25%);
            background-size: 60px 60px;
        }

        /* Input */
        .inp {
            width: 100%;
            height: 48px;
            padding: 0 16px 0 40px;
            border: 1.5px solid #E5E7EB;
            border-radius: 14px;
            background: #FAFAFA;
            font-size: 14px;
            color: #1F2937;
            outline: none;
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .inp:focus {
            border-color: #1D9E75;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(29,158,117,0.1);
        }
        .inp::placeholder { color: #9CA3AF; }

        /* Button */
        .btn-login {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #1D9E75, #0F6E56);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(29,158,117,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(29,158,117,0.5);
        }
        .btn-login:active { transform: translateY(0); }

        /* Floating badge dekoratif */
        .float-badge {
            position: absolute;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 8px 14px;
            color: rgba(255,255,255,0.9);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Checkbox custom */
        input[type=checkbox] {
            accent-color: #1D9E75;
            width: 16px;
            height: 16px;
        }
    </style>
</head>

<body class="login-bg">

    {{-- Dot pattern overlay --}}
    <div class="dot-pattern"></div>

    {{-- Elemen dekoratif mengambang --}}
    <div class="absolute top-8 left-8 opacity-40 hidden lg:block"
         style="width:80px;height:80px;border-radius:50%;border:2px solid rgba(255,255,255,0.15)"></div>
    <div class="absolute top-16 left-16 opacity-20 hidden lg:block"
         style="width:40px;height:40px;border-radius:50%;border:2px solid rgba(255,255,255,0.2)"></div>
    <div class="absolute bottom-12 right-12 opacity-30 hidden lg:block"
         style="width:100px;height:100px;border-radius:50%;border:2px solid rgba(255,255,255,0.1)"></div>
    <div class="absolute bottom-24 right-28 opacity-15 hidden lg:block"
         style="width:50px;height:50px;border-radius:50%;border:2px solid rgba(255,255,255,0.15)"></div>

@php
    $appName   = $settings['app_name']        ?? 'Stockify';
    $appDesc   = $settings['app_description'] ?? 'Sistem Manajemen Stok Gudang';
    $appLogo   = $settings['app_logo']        ?? null;
    $compName  = $settings['company_name']    ?? '';
    $compPhone = $settings['company_phone']   ?? '';
    $compEmail = $settings['company_email']   ?? '';
    $compAddr  = $settings['company_address'] ?? '';
    $initial   = strtoupper(substr($appName, 0, 1));
@endphp

    {{-- Card --}}
    <div class="login-card flex" style="min-height:580px">

        {{-- ── Panel Kiri ── --}}
        <div class="left-panel hidden md:flex flex-col justify-between p-10 w-5/12">
            <div class="left-lines"></div>

            {{-- Logo --}}
            <div class="flex items-center gap-3 z-10 relative">
                @if($appLogo)
                    <img src="{{ asset('storage/'.$appLogo) }}" alt="{{ $appName }}"
                         class="w-11 h-11 object-contain rounded-2xl"
                         style="background:rgba(255,255,255,0.15);padding:6px;border:1px solid rgba(255,255,255,0.2)">
                @else
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0"
                         style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);backdrop-filter:blur(4px)">
                        <span class="font-sora font-bold text-white text-xl">{{ $initial }}</span>
                    </div>
                @endif
                <span class="font-sora font-semibold text-white text-xl tracking-wide">{{ $appName }}</span>
            </div>

            {{-- Tagline --}}
            <div class="z-10 relative">
                <h1 class="font-sora text-white leading-tight mb-3" style="font-size:28px;font-weight:300">
                    {{ $appDesc }}
                </h1>
                @if($compName)
                <p class="text-white/80 text-sm font-semibold mt-2">{{ $compName }}</p>
                @endif
            </div>

            {{-- Info kontak / Fitur --}}
            <div class="z-10 relative space-y-3">
                @if($compPhone)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.15)">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="text-white/80 text-sm">{{ $compPhone }}</span>
                </div>
                @endif

                @if($compEmail)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.15)">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="text-white/80 text-sm">{{ $compEmail }}</span>
                </div>
                @endif

                @if($compAddr)
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5"
                         style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.15)">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="text-white/80 text-sm leading-relaxed">{{ $compAddr }}</span>
                </div>
                @endif

                @if(!$compPhone && !$compEmail && !$compAddr)
                @foreach(['Monitoring stok real-time','Barang masuk & keluar','Laporan transaksi lengkap','Multi-role pengguna'] as $f)
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0"
                         style="background:rgba(255,255,255,0.15)">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 12 12">
                            <path d="M2 6l3 3 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="text-white/80 text-sm">{{ $f }}</span>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        {{-- ── Panel Kanan ── --}}
        <div class="flex-1 flex flex-col justify-center p-8 sm:p-12"
             style="background: linear-gradient(160deg, #ffffff 0%, #fafffe 100%)">

            {{-- Logo mobile --}}
            <div class="flex items-center gap-2.5 mb-6 md:hidden">
                @if($appLogo)
                    <img src="{{ asset('storage/'.$appLogo) }}" class="w-8 h-8 object-contain rounded-xl">
                @else
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center"
                         style="background:linear-gradient(135deg,#1D9E75,#0F6E56)">
                        <span class="font-sora font-bold text-white text-sm">{{ $initial }}</span>
                    </div>
                @endif
                <span class="font-sora font-semibold text-gray-800">{{ $appName }}</span>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                    Selamat datang
                </p>
                <h2 class="font-sora text-2xl sm:text-3xl font-semibold text-gray-900">
                    Masuk ke akun Anda
                </h2>
                @if($compName)
                <p class="text-sm text-gray-400 mt-1.5">{{ $compName }}</p>
                @endif
            </div>

            {{-- Error alert --}}
            @if($errors->any())
            <div class="flex items-center gap-3 rounded-2xl px-4 py-3 mb-6 text-sm text-red-700"
                 style="background: linear-gradient(135deg,#FFF5F5,#FEE2E2);border:1px solid rgba(239,68,68,0.2)">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="7.25" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M8 4.5v4M8 10.5v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" style="space-y:0">
            @csrf

                {{-- Email --}}
                <div style="margin-bottom:20px">
                    <label style="display:block;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">
                        Email
                    </label>
                    <div style="position:relative">
                        <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#9CA3AF" fill="none" viewBox="0 0 20 20">
                            <path d="M2.5 5.5A1.5 1.5 0 014 4h12a1.5 1.5 0 011.5 1.5v9A1.5 1.5 0 0116 16H4a1.5 1.5 0 01-1.5-1.5v-9z" stroke="currentColor" stroke-width="1.25"/>
                            <path d="M3 6l7 5 7-5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"/>
                        </svg>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="email@perusahaan.com" class="inp">
                    </div>
                </div>

                {{-- Password --}}
                <div style="margin-bottom:20px">
                    <label style="display:block;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">
                        Password
                    </label>
                    <div style="position:relative">
                        <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#9CA3AF" fill="none" viewBox="0 0 20 20">
                            <rect x="3.5" y="8.5" width="13" height="9" rx="1.5" stroke="currentColor" stroke-width="1.25"/>
                            <path d="M6.5 8.5V6a3.5 3.5 0 017 0v2.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"/>
                            <circle cx="10" cy="13" r="1.25" fill="currentColor"/>
                        </svg>
                        <input type="password" name="password" id="password" required
                            placeholder="Masukkan password" class="inp" style="padding-right:44px">
                        <button type="button" onclick="togglePass()"
                            style="position:absolute;right:13px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9CA3AF;padding:2px;display:flex;align-items:center">
                            <svg id="eye-show" style="width:16px;height:16px" fill="none" viewBox="0 0 20 20">
                                <ellipse cx="10" cy="10" rx="8" ry="5" stroke="currentColor" stroke-width="1.25"/>
                                <circle cx="10" cy="10" r="2" stroke="currentColor" stroke-width="1.25"/>
                            </svg>
                            <svg id="eye-hide" style="width:16px;height:16px;display:none" fill="none" viewBox="0 0 20 20">
                                <path d="M3 3l14 14M8.5 7.5A3.5 3.5 0 0114 13M5.5 5.5C4 7 3 8.5 3 10s3 6 7 6 5.5-2 7-4" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember + Forgot --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="checkbox" name="remember">
                        <span style="font-size:13px;color:#6B7280">Ingat saya</span>
                    </label>
                  
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login">
                    Masuk
                    <svg style="width:16px;height:16px" fill="none" viewBox="0 0 20 20">
                        <path d="M4 10h12M12 6l4 4-4 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>

            {{-- Footer --}}
            <div style="margin-top:28px;padding-top:20px;border-top:1px solid #F3F4F6;text-align:center">
                <p style="font-size:12px;color:#9CA3AF">
                    &copy; {{ date('Y') }}
                    {{ $compName ?: $appName }}
                    &middot; Powered by <strong style="color:#1D9E75">{{ $appName }}</strong>
                </p>
            </div>
        </div>
    </div>

<script>
function togglePass() {
    const inp  = document.getElementById('password');
    const show = document.getElementById('eye-show');
    const hide = document.getElementById('eye-hide');
    if (inp.type === 'password') {
        inp.type = 'text';
        show.style.display = 'none';
        hide.style.display = 'block';
    } else {
        inp.type = 'password';
        show.style.display = 'block';
        hide.style.display = 'none';
    }
}
</script>
</body>
</html>