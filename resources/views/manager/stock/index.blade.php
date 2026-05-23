{{-- resources/views/manager/stock/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Riwayat Stok')
@section('page-title', 'Riwayat Transaksi Stok')
@section('breadcrumb', 'Manajer Gudang / Stok')

@section('content')
    <div class="space-y-4">

        {{-- Filter --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-4">
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="type"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Tipe</option>
                    <option value="in" @selected(request('type') === 'in')>Barang Masuk</option>
                    <option value="out" @selected(request('type') === 'out')>Barang Keluar</option>
                </select>
                <select name="status"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                    <option value="confirmed" @selected(request('status') === 'confirmed')>Dikonfirmasi</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
                </select>
                <select name="product_id"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Produk</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}" @selected(request('product_id') == $p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                <button
                    class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">Filter</button>
                @if (request()->hasAny(['type', 'status', 'product_id', 'date_from', 'date_to']))
                    <a href="{{ route('manager.stock.index') }}"
                        class="h-9 px-4 text-sm font-medium border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 flex items-center">Reset</a>
                @endif
            </form>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-3 justify-end">
            <a href="{{ route('manager.stock.create-in') }}"
                class="flex items-center gap-2 h-9 px-4 text-sm font-semibold text-white rounded-xl transition"
                style="background:#1D9E75" onmouseover="this.style.background='#0F6E56'"
                onmouseout="this.style.background='#1D9E75'">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="white" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Barang Masuk
            </a>
            <a href="{{ route('manager.stock.create-out') }}"
                class="flex items-center gap-2 h-9 px-4 text-sm font-semibold text-red-600 border border-red-200 rounded-xl hover:bg-red-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Barang Keluar
            </a>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                            <th class="px-5 py-3.5 text-left font-semibold">No. Ref</th>
                            <th class="px-5 py-3.5 text-left font-semibold">Produk</th>
                            <th class="px-5 py-3.5 text-center font-semibold">Tipe</th>
                            <th class="px-5 py-3.5 text-right font-semibold">Qty</th>
                            <th class="px-5 py-3.5 text-right font-semibold">Stok Sesudah</th>
                            <th class="px-5 py-3.5 text-center font-semibold">Tanggal</th>
                            <th class="px-5 py-3.5 text-center font-semibold">Status</th>
                            <th class="px-5 py-3.5 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 font-mono text-xs text-gray-400">{{ $trx->reference_no ?? '—' }}</td>
                                <td class="px-5 py-3.5">
                                    <p class="font-semibold text-gray-800 truncate max-w-[150px]">
                                        {{ $trx->product->name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400">oleh {{ $trx->user->name ?? '—' }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-center">
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
                                <td class="px-5 py-3.5 text-right font-bold text-gray-700">{{ $trx->quantity }}</td>
                                <td class="px-5 py-3.5 text-right text-gray-500">{{ $trx->stock_after }}</td>
                                <td class="px-5 py-3.5 text-center text-xs text-gray-500 whitespace-nowrap">
                                    {{ $trx->date->format('d M Y') }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
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
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('manager.stock.show', $trx->id) }}"
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-14 text-center">
                                    <div
                                        class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24">
                                            <path
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Belum ada transaksi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($transactions->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">{{ $transactions->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection
