{{-- resources/views/staff/dashboard/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Dashboard Staff')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Staff Gudang / Dashboard')

@section('content')
    <div class="space-y-6">

        {{-- Selamat datang --}}
        <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Selamat datang,</p>
                    <h2 class="text-2xl font-bold mt-0.5">{{ auth()->user()->name }}</h2>
                    <p class="text-green-100 text-sm mt-1">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-white/15 flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </span>
                </div>
            </div>

            {{-- Summary bar --}}
            <div class="grid grid-cols-3 gap-4 mt-5 pt-5 border-t border-white/20">
                <div class="text-center">
                    <p class="text-2xl font-bold">{{ $pendingInCount ?? 0 }}</p>
                    <p class="text-xs text-green-100 mt-0.5">Masuk Pending</p>
                </div>
                <div class="text-center border-x border-white/20">
                    <p class="text-2xl font-bold">{{ $pendingOutCount ?? 0 }}</p>
                    <p class="text-xs text-green-100 mt-0.5">Keluar Pending</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold">{{ $myTodayConfirmed }}</p>
                    <p class="text-xs text-green-100 mt-0.5">Saya Konfirmasi Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

            {{-- Barang Masuk Pending --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Barang Masuk Perlu Dikonfirmasi</h3>
                    </div>
                    @if ($pendingIn->count() > 0)
                        <span
                            class="text-xs font-bold px-2 py-1 rounded-full bg-green-50 text-green-700">{{ $pendingIn->count() }}</span>
                    @endif
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($pendingIn->take(5) as $trx)
                        <div class="flex items-center justify-between px-5 py-3 hover:bg-gray-50/50 transition">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $trx->product->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $trx->reference_no ?? 'Tanpa ref' }} · {{ $trx->date->format('d M Y') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 ml-3 flex-shrink-0">
                                <span class="text-sm font-bold text-green-600">+{{ $trx->quantity }}</span>
                                <div class="flex gap-1">
                                    <form method="POST" action="{{ route('staff.stock.confirm', $trx->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-7 h-7 rounded-lg bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition"
                                            title="Konfirmasi">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </form>
                                    <a href="{{ route('staff.stock.show', $trx->id) }}"
                                        class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition"
                                        title="Detail">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor"
                                                stroke-width="1.5" />
                                            <circle cx="12" cy="12" r="3" stroke="currentColor"
                                                stroke-width="1.5" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center">
                            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">Semua sudah dikonfirmasi</p>
                            <p class="text-xs text-gray-400 mt-0.5">Tidak ada barang masuk pending</p>
                        </div>
                    @endforelse
                </div>

                @if ($pendingIn->count() > 5)
                    <div class="px-5 py-3 border-t border-gray-50">
                        <a href="{{ route('staff.stock.index', ['type' => 'in']) }}"
                            class="text-xs font-medium text-green-600 hover:text-green-700">
                            Lihat {{ $pendingIn->count() - 5 }} lainnya →
                        </a>
                    </div>
                @endif
            </div>

            {{-- Barang Keluar Pending --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Barang Keluar Perlu Disiapkan</h3>
                    </div>
                    @if ($pendingOut->count() > 0)
                        <span
                            class="text-xs font-bold px-2 py-1 rounded-full bg-red-50 text-red-600">{{ $pendingOut->count() }}</span>
                    @endif
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($pendingOut->take(5) as $trx)
                        <div class="flex items-center justify-between px-5 py-3 hover:bg-gray-50/50 transition">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $trx->product->name ?? '—' }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $trx->reference_no ?? 'Tanpa ref' }} · {{ $trx->date->format('d M Y') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 ml-3 flex-shrink-0">
                                <span class="text-sm font-bold text-red-500">-{{ $trx->quantity }}</span>
                                <div class="flex gap-1">
                                    <form method="POST" action="{{ route('staff.stock.confirm', $trx->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-7 h-7 rounded-lg bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition"
                                            title="Konfirmasi">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </form>
                                    <a href="{{ route('staff.stock.show', $trx->id) }}"
                                        class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition"
                                        title="Detail">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor"
                                                stroke-width="1.5" />
                                            <circle cx="12" cy="12" r="3" stroke="currentColor"
                                                stroke-width="1.5" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center">
                            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">Tidak ada yang perlu disiapkan</p>
                            <p class="text-xs text-gray-400 mt-0.5">Tidak ada barang keluar pending</p>
                        </div>
                    @endforelse
                </div>

                @if ($pendingOut->count() > 5)
                    <div class="px-5 py-3 border-t border-gray-50">
                        <a href="{{ route('staff.stock.index', ['type' => 'out']) }}"
                            class="text-xs font-medium text-green-600 hover:text-green-700">
                            Lihat {{ $pendingOut->count() - 5 }} lainnya →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Ganti bagian tabel Aktivitas Saya --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">Transaksi Terbaru</h3>
                <a href="{{ route('staff.stock.index') }}"
                    class="text-xs font-medium text-green-600 hover:text-green-700">
                    Lihat pending →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                            <th class="px-5 py-3 text-left font-semibold">No. Ref</th>
                            <th class="px-5 py-3 text-left font-semibold">Produk</th>
                            <th class="px-5 py-3 text-left font-semibold">Dicatat Oleh</th>
                            <th class="px-5 py-3 text-center font-semibold">Tipe</th>
                            <th class="px-5 py-3 text-right font-semibold">Qty</th>
                            <th class="px-5 py-3 text-center font-semibold">Tanggal</th>
                            <th class="px-5 py-3 text-center font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($myActivity as $trx)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $trx->reference_no ?? '—' }}</td>
                                <td class="px-5 py-3 font-semibold text-gray-800 max-w-[140px] truncate">
                                    {{ $trx->product->name ?? '—' }}
                                </td>
                                <td class="px-5 py-3">
                                    <p class="text-xs text-gray-700">{{ $trx->user->name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400">{{ $trx->user->role_label ?? '' }}</p>
                                </td>
                                <td class="px-5 py-3 text-center">
                                    @if ($trx->type === 'in')
                                        <span
                                            class="text-xs font-semibold px-2 py-1 rounded-full bg-green-50 text-green-700">↓
                                            Masuk</span>
                                    @elseif($trx->type === 'out')
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-red-50 text-red-700">↑
                                            Keluar</span>
                                    @else
                                        <span
                                            class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-50 text-blue-700">Opname</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right font-bold text-gray-700">{{ $trx->quantity }}</td>
                                <td class="px-5 py-3 text-center text-xs text-gray-500 whitespace-nowrap">
                                    {{ $trx->date->format('d M Y') }}
                                </td>
                                <td class="px-5 py-3 text-center">
                                    @php
                                        $sc = [
                                            'pending' => 'bg-amber-50 text-amber-700',
                                            'confirmed' => 'bg-green-50 text-green-700',
                                            'rejected' => 'bg-red-50 text-red-600',
                                        ];
                                        $sl = [
                                            'pending' => 'Menunggu',
                                            'confirmed' => 'Dikonfirmasi',
                                            'rejected' => 'Ditolak',
                                        ];
                                    @endphp
                                    <span
                                        class="text-xs font-semibold px-2 py-1 rounded-full {{ $sc[$trx->status] ?? '' }}">
                                        {{ $sl[$trx->status] ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-400 text-sm">
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
