{{-- resources/views/staff/stock/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Konfirmasi Stok')
@section('page-title', 'Konfirmasi Transaksi Stok')
@section('breadcrumb', 'Staff Gudang / Konfirmasi Stok')

@section('content')
<div class="space-y-4">

    {{-- Summary --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 px-5 py-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Barang Masuk Pending</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingInCount }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 px-5 py-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Barang Keluar Pending</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingOutCount }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="flex gap-2">
        <a href="{{ route('staff.stock.index') }}"
           class="h-9 px-4 text-sm font-medium rounded-xl transition flex items-center
           {{ !request('type') ? 'text-white' : 'border border-gray-200 text-gray-500 hover:bg-gray-50' }}"
           @if(!request('type')) style="background:#1D9E75" @endif>
            Semua ({{ $pendingInCount + $pendingOutCount }})
        </a>
        <a href="{{ route('staff.stock.index', ['type' => 'in']) }}"
           class="h-9 px-4 text-sm font-medium rounded-xl transition flex items-center
           {{ request('type')==='in' ? 'bg-green-50 text-green-700 font-semibold' : 'border border-gray-200 text-gray-500 hover:bg-gray-50' }}">
            Masuk ({{ $pendingInCount }})
        </a>
        <a href="{{ route('staff.stock.index', ['type' => 'out']) }}"
           class="h-9 px-4 text-sm font-medium rounded-xl transition flex items-center
           {{ request('type')==='out' ? 'bg-red-50 text-red-600 font-semibold' : 'border border-gray-200 text-gray-500 hover:bg-gray-50' }}">
            Keluar ({{ $pendingOutCount }})
        </a>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <h3 class="text-sm font-semibold text-gray-700">Transaksi Menunggu Konfirmasi</h3>
            <span class="text-xs text-gray-400">{{ $transactions->total() }} transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="px-5 py-3.5 text-left font-semibold">No. Ref</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Produk</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Dicatat Oleh</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Tipe</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Qty</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Stok Saat Ini</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Tanggal</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4 font-mono text-xs text-gray-400">
                        {{ $trx->reference_no ?? '—' }}
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-gray-800 truncate max-w-[150px]">
                            {{ $trx->product->name ?? '—' }}
                        </p>
                        <p class="text-xs font-mono text-gray-400">{{ $trx->product->sku ?? '' }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-sm text-gray-700">{{ $trx->user->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400">{{ $trx->user->role_label ?? '' }}</p>
                    </td>
                    <td class="px-5 py-4 text-center">
                        @if($trx->type === 'in')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 12 12"><path d="M6 1v10M1 6l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                Masuk
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 text-red-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 12 12"><path d="M6 11V1M1 6l5-5 5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                Keluar
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-right">
                        <span class="text-base font-bold {{ $trx->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trx->type === 'in' ? '+' : '-' }}{{ number_format($trx->quantity) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ number_format($trx->stock_before) }}
                        </span>
                        <span class="text-xs text-gray-400 ml-1">{{ $trx->product->unit ?? '' }}</span>
                    </td>
                    <td class="px-5 py-4 text-center text-xs text-gray-500 whitespace-nowrap">
                        {{ $trx->date->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            {{-- Detail --}}
                            <a href="{{ route('staff.stock.show', $trx->id) }}"
                               class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition" title="Detail">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
                            </a>
                            {{-- Konfirmasi --}}
                            <form method="POST" action="{{ route('staff.stock.confirm', $trx->id) }}">
                                @csrf
                                <button type="submit"
                                    class="w-7 h-7 rounded-lg bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition" title="Konfirmasi">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </form>
                            {{-- Tolak --}}
                            <form method="POST" action="{{ route('staff.stock.reject', $trx->id) }}"
                                  onsubmit="return confirm('Tolak transaksi ini?')">
                                @csrf
                                <button type="submit"
                                    class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition" title="Tolak">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-14 text-center">
                        <div class="w-16 h-16 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-600">Semua transaksi sudah dikonfirmasi!</p>
                        <p class="text-xs text-gray-400 mt-1">Tidak ada transaksi yang menunggu konfirmasi</p>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">
            {{ $transactions->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection