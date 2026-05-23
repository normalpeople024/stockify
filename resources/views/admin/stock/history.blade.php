{{-- resources/views/admin/stock/history.blade.php --}}
@extends('layouts.app1')
@section('title', 'Riwayat Stok')
@section('page-title', 'Riwayat Transaksi Stok')
@section('breadcrumb', 'Admin / Stok / Riwayat')

@section('content')
<div class="space-y-4">

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tipe</label>
                <select name="type" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Tipe</option>
                    <option value="in" @selected(request('type')==='in' )>Barang Masuk</option>
                    <option value="out" @selected(request('type')==='out' )>Barang Keluar</option>
                    <option value="opname" @selected(request('type')==='opname' )>Stock Opname</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
            </div>
            <button class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">
                Filter
            </button>
            @if(request()->hasAny(['type', 'date_from', 'date_to']))
            <a href="{{ route('admin.stock.history') }}"
                class="h-9 px-4 text-sm font-medium border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 transition flex items-center">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Summary bar --}}
    @php
    $totalIn = $transactions->where('type', 'in')->sum('quantity');
    $totalOut = $transactions->where('type', 'out')->sum('quantity');
    @endphp
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 px-5 py-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Masuk</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalIn) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 px-5 py-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Keluar</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalOut) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 px-5 py-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($transactions->total()) }}</p>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <h3 class="text-sm font-semibold text-gray-700">Semua Transaksi Terkonfirmasi</h3>
            <span class="text-xs text-gray-400">{{ $transactions->total() }} data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="px-5 py-3.5 text-left font-semibold">No. Ref</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Produk</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Oleh</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Tipe</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Qty</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Stok Sebelum</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Stok Sesudah</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Tanggal</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-5 py-3.5 font-mono text-xs text-gray-400">
                            {{ $trx->reference_no ?? '—' }}
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-gray-800 truncate max-w-[160px]">{{ $trx->product->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $trx->product->sku ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-sm text-gray-700">{{ $trx->user->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $trx->user->role_label ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($trx->type === 'in')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 16 16">
                                    <path d="M8 3v10M3 8l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Masuk
                            </span>
                            @elseif($trx->type === 'out')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 text-red-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 16 16">
                                    <path d="M8 13V3M3 8l5-5 5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Keluar
                            </span>
                            @else
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">Opname</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right font-bold text-gray-800">
                            {{ number_format($trx->quantity) }}
                        </td>
                        <td class="px-5 py-3.5 text-right text-gray-500">
                            {{ number_format($trx->stock_before) }}
                        </td>
                        <td class="px-5 py-3.5 text-right text-gray-500">
                            {{ number_format($trx->stock_after) }}
                        </td>
                        <td class="px-5 py-3.5 text-center text-xs text-gray-500 whitespace-nowrap">
                            {{ $trx->date->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5 text-xs text-gray-500 max-w-[140px] truncate">
                            {{ $trx->notes ?? '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-14 text-center">
                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada riwayat transaksi</p>
                            <p class="text-xs text-gray-400 mt-1">Transaksi yang dikonfirmasi akan muncul di sini</p>
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