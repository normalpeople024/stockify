{{-- resources/views/admin/stock/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Transaksi Stok')
@section('page-title', 'Transaksi Stok')
@section('breadcrumb', 'Admin / Stok')

@section('content')
    <div class="space-y-4">
        <form method="GET" class="flex flex-wrap gap-2">
            <select name="type" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none">
                <option value="">Semua Tipe</option>
                <option value="in" @selected(request('type') === 'in')>Barang Masuk</option>
                <option value="out" @selected(request('type') === 'out')>Barang Keluar</option>
                <option value="opname" @selected(request('type') === 'opname')>Stock Opname</option>
            </select>
            <select name="status" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none">
                <option value="">Semua Status</option>
                <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                <option value="confirmed" @selected(request('status') === 'confirmed')>Dikonfirmasi</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
            </select>
            <select name="product_id"
                class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none">
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
                class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl">Filter</button>
            @if (request()->hasAny(['type', 'status', 'product_id', 'date_from', 'date_to']))
                <a href="{{ route('admin.stock.index') }}"
                    class="h-9 px-4 text-sm font-medium border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 flex items-center">Reset</a>
            @endif
        </form>

        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
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
                            <th class="px-5 py-3.5 text-center font-semibold">Tgl</th>
                            <th class="px-5 py-3.5 text-center font-semibold">Status</th>
                            <th class="px-5 py-3.5 text-center font-semibold">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 font-mono text-xs text-gray-400">{{ $trx->reference_no ?? '—' }}</td>
                                <td class="px-5 py-3.5 font-medium text-gray-700 max-w-[150px] truncate">
                                    {{ $trx->product->name ?? '—' }}</td>
                                <td class="px-5 py-3.5 text-xs text-gray-500">{{ $trx->user->name ?? '—' }}</td>
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
                                <td class="px-5 py-3.5 text-right text-gray-500">{{ $trx->stock_before }}</td>
                                <td class="px-5 py-3.5 text-right text-gray-500">{{ $trx->stock_after }}</td>
                                <td class="px-5 py-3.5 text-center text-xs text-gray-500">{{ $trx->date->format('d/m/Y') }}</td>

                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Status label (tidak ada tombol konfirmasi/tolak untuk admin) --}}
                                        @if ($trx->status === 'pending')
                                            <span
                                                class="text-xs font-semibold px-2 py-1 rounded-full bg-amber-50 text-amber-700">
                                                Menunggu Staff
                                            </span>
                                        @elseif($trx->status === 'confirmed')
                                            <span
                                                class="text-xs font-semibold px-2 py-1 rounded-full bg-green-50 text-green-700">
                                                Dikonfirmasi
                                            </span>
                                        @else
                                            <span
                                                class="text-xs font-semibold px-2 py-1 rounded-full bg-red-50 text-red-600">
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Tambah tombol detail --}}
                                        <a href="{{ route('admin.stock.show', $trx->id) }}"
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
                                <td colspan="10" class="px-6 py-12 text-center text-gray-400">Tidak ada transaksi
                                    ditemukan.</td>
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
