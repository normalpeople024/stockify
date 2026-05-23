{{-- resources/views/manager/dashboard/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Dashboard Manager')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Manajer Gudang / Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($todayIn) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Masuk Hari Ini</p>
            <p class="text-xs text-gray-400 mt-0.5">unit diterima</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($todayOut) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Keluar Hari Ini</p>
            <p class="text-xs text-gray-400 mt-0.5">unit dikirim</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($pendingCount) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Menunggu Konfirmasi</p>
            <p class="text-xs text-gray-400 mt-0.5">transaksi pending</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($lowStockCount) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Stok Menipis</p>
            <p class="text-xs text-gray-400 mt-0.5">perlu direstok</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('manager.stock.create-in') }}"
           class="flex items-center gap-4 bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm hover:border-green-200 transition group">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-100 transition flex-shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">Catat Barang Masuk</p>
                <p class="text-xs text-gray-400 mt-0.5">Penerimaan stok baru</p>
            </div>
            <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>

        <a href="{{ route('manager.stock.create-out') }}"
           class="flex items-center gap-4 bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm hover:border-red-200 transition group">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-100 transition flex-shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">Catat Barang Keluar</p>
                <p class="text-xs text-gray-400 mt-0.5">Pengeluaran stok gudang</p>
            </div>
            <svg class="w-4 h-4 text-gray-300 ml-auto" fill="none" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- Transaksi Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">Transaksi Terbaru</h3>
                <a href="{{ route('manager.reports.transactions') }}" class="text-xs font-medium text-green-600 hover:text-green-700">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-400 uppercase">
                            <th class="px-6 py-3 text-left font-semibold">Produk</th>
                            <th class="px-6 py-3 text-center font-semibold">Tipe</th>
                            <th class="px-6 py-3 text-right font-semibold">Qty</th>
                            <th class="px-6 py-3 text-center font-semibold">Status</th>
                            <th class="px-6 py-3 text-center font-semibold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-3 font-medium text-gray-700 max-w-[160px] truncate">
                            {{ $trx->product->name ?? '—' }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            @if($trx->type === 'in')
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-50 text-green-700">↓ Masuk</span>
                            @elseif($trx->type === 'out')
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-red-50 text-red-700">↑ Keluar</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-50 text-blue-700">Opname</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right font-bold text-gray-700">{{ $trx->quantity }}</td>
                        <td class="px-6 py-3 text-center">
                            @php
                            $sc = ['pending'=>'bg-amber-50 text-amber-700','confirmed'=>'bg-green-50 text-green-700','rejected'=>'bg-red-50 text-red-600'];
                            $sl = ['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','rejected'=>'Ditolak'];
                            @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $sc[$trx->status] ?? '' }}">
                                {{ $sl[$trx->status] ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-center text-xs text-gray-500">
                            {{ $trx->date->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 text-sm">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Stok Menipis --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">Stok Menipis</h3>
                @if($lowStockCount > 0)
                <span class="text-xs font-bold px-2 py-1 rounded-full bg-red-50 text-red-600">{{ $lowStockCount }}</span>
                @endif
            </div>
            <div class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                @forelse($lowStockProducts as $p)
                <div class="flex items-center justify-between px-5 py-3 hover:bg-gray-50/50 transition">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-700 truncate">{{ $p->name }}</p>
                        <p class="text-xs text-gray-400">{{ $p->category->name ?? '—' }} · Min: {{ $p->minimum_stock }}</p>
                    </div>
                    <div class="ml-3 text-right flex-shrink-0">
                        <span class="text-lg font-bold text-red-600">{{ $p->stock }}</span>
                        <p class="text-xs text-gray-400">{{ $p->unit }}</p>
                    </div>
                </div>
                @empty
                <div class="px-5 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Semua stok aman</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection