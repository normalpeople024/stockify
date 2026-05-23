{{-- resources/views/admin/reports/transactions.blade.php --}}
@extends('layouts.app1')
@section('title', 'Laporan Transaksi')
@section('page-title', 'Laporan Transaksi')
@section('breadcrumb', 'Admin / Laporan / Transaksi')

@section('content')
<div class="space-y-5">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_in']) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Total Masuk</p>
            <p class="text-xs text-gray-400">unit dikonfirmasi</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_out']) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Total Keluar</p>
            <p class="text-xs text-gray-400">unit dikonfirmasi</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_pending']) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Menunggu</p>
            <p class="text-xs text-gray-400">belum dikonfirmasi</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($summary['total_rejected']) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-1">Ditolak</p>
            <p class="text-xs text-gray-400">transaksi ditolak</p>
        </div>
    </div>

    {{-- Filter — gabungan dari kedua halaman --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <form method="GET" class="flex flex-wrap gap-3">

            {{-- Tipe --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tipe</label>
                <select name="type" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Tipe</option>
                    <option value="in"     @selected(request('type')==='in')>Barang Masuk</option>
                    <option value="out"    @selected(request('type')==='out')>Barang Keluar</option>
                    <option value="opname" @selected(request('type')==='opname')>Stock Opname</option>
                </select>
            </div>

            {{-- Status — dari transaksi stok --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Status</label>
                <select name="status" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Status</option>
                    <option value="pending"   @selected(request('status')==='pending')>Menunggu</option>
                    <option value="confirmed" @selected(request('status')==='confirmed')>Dikonfirmasi</option>
                    <option value="rejected"  @selected(request('status')==='rejected')>Ditolak</option>
                </select>
            </div>

            {{-- Produk — dari transaksi stok --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Produk</label>
                <select name="product_id" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Produk</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}" @selected(request('product_id')==$p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
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

            <div class="flex items-end gap-2">
                <button class="h-9 px-4 text-sm font-semibold text-white rounded-xl transition"
                    style="background:#1D9E75"
                    onmouseover="this.style.background='#0F6E56'"
                    onmouseout="this.style.background='#1D9E75'">
                    Filter
                </button>
                @if(request()->hasAny(['type','status','product_id','date_from','date_to']))
                <a href="{{ route('admin.reports.transactions') }}"
                   class="h-9 px-4 text-sm font-medium border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 flex items-center">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Data Transaksi</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $transactions->total() }} transaksi ditemukan</p>
            </div>
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
                        <th class="px-5 py-3.5 text-right font-semibold">Stok Sebelum</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Stok Sesudah</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Tanggal</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Dikonfirmasi Oleh</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Status</th>
                        <th class="px-5 py-3.5 text-center font-semibold">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50/50 transition">

                    {{-- No. Ref --}}
                    <td class="px-5 py-3.5 font-mono text-xs text-gray-400">
                        {{ $trx->reference_no ?? '—' }}
                    </td>

                    {{-- Produk --}}
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-gray-800 truncate max-w-[140px]">{{ $trx->product->name ?? '—' }}</p>
                        <p class="text-xs font-mono text-gray-400">{{ $trx->product->sku ?? '' }}</p>
                    </td>

                    {{-- Dicatat Oleh --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0"
                                 style="background: linear-gradient(135deg,#1D9E75,#0F6E56)">
                                {{ strtoupper(substr($trx->user->name ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-700">{{ $trx->user->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $trx->user->role_label ?? '' }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Tipe --}}
                    <td class="px-5 py-3.5 text-center">
                        @if($trx->type === 'in')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 12 12"><path d="M6 1v10M1 6l5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                Masuk
                            </span>
                        @elseif($trx->type === 'out')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 text-red-700">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 12 12"><path d="M6 11V1M1 6l5-5 5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                Keluar
                            </span>
                        @else
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">Opname</span>
                        @endif
                    </td>

                    {{-- Qty --}}
                    <td class="px-5 py-3.5 text-right font-bold text-gray-800">
                        {{ number_format($trx->quantity) }}
                        <span class="text-xs font-normal text-gray-400">{{ $trx->product->unit ?? '' }}</span>
                    </td>

                    {{-- Stok Sebelum & Sesudah — dari transaksi stok --}}
                    <td class="px-5 py-3.5 text-right text-gray-500 text-sm">{{ number_format($trx->stock_before) }}</td>
                    <td class="px-5 py-3.5 text-right text-gray-500 text-sm">{{ number_format($trx->stock_after) }}</td>

                    {{-- Tanggal --}}
                    <td class="px-5 py-3.5 text-center">
                        <p class="text-xs font-medium text-gray-600 whitespace-nowrap">{{ $trx->date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $trx->created_at->format('H:i') }}</p>
                    </td>

                    {{-- Dikonfirmasi Oleh — dari transaksi stok --}}
                    <td class="px-5 py-3.5 text-center">
                        @if($trx->confirmedByUser)
                            <div class="flex flex-col items-center gap-0.5">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center text-white text-[9px] font-bold flex-shrink-0
                                        {{ $trx->status === 'confirmed' ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ strtoupper(substr($trx->confirmedByUser->name, 0, 2)) }}
                                    </div>
                                    <p class="text-xs font-medium text-gray-600">{{ $trx->confirmedByUser->name }}</p>
                                </div>
                                @if($trx->confirmed_at)
                                <p class="text-xs text-gray-400">{{ $trx->confirmed_at->format('d M, H:i') }}</p>
                                @endif
                            </div>
                        @elseif($trx->status === 'pending')
                            <span class="text-xs text-amber-500 font-medium">Menunggu staff</span>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-3.5 text-center">
                        @if($trx->status === 'confirmed')
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">Dikonfirmasi</span>
                        @elseif($trx->status === 'pending')
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Menunggu</span>
                        @else
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 text-red-600">Ditolak</span>
                        @endif
                    </td>

                    {{-- Detail --}}
                    <td class="px-5 py-3.5 text-center">
                        <a href="{{ route('admin.stock.show', $trx->id) }}"
                           class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition mx-auto"
                           title="Detail">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-6 py-14 text-center">
                        <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Tidak ada transaksi ditemukan</p>
                        <p class="text-xs text-gray-400 mt-1">Coba ubah filter untuk hasil yang berbeda</p>
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