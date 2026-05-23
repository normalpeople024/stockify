{{-- resources/views/admin/stock/show.blade.php --}}
@extends('layouts.app1')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('breadcrumb', 'Admin / Stok / Detail')

@section('content')
<div class="max-w-2xl space-y-5">

    <a href="{{ route('admin.reports.transactions') }}"
       class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
            <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali ke Laporan Transaksi
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-50
            {{ $transaction->type === 'in' ? 'bg-green-50' : ($transaction->type === 'out' ? 'bg-red-50' : 'bg-blue-50') }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                        {{ $transaction->type === 'in' ? 'bg-green-100 text-green-600' : ($transaction->type === 'out' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600') }}">
                        @if($transaction->type === 'in')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @elseif($transaction->type === 'out')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide
                            {{ $transaction->type === 'in' ? 'text-green-600' : ($transaction->type === 'out' ? 'text-red-600' : 'text-blue-600') }}">
                            {{ $transaction->type_label }}
                        </p>
                        <p class="font-mono font-semibold text-gray-800">
                            {{ $transaction->reference_no ?? 'Tanpa Referensi' }}
                        </p>
                    </div>
                </div>
                @php
                $sc = ['pending'=>'bg-amber-50 text-amber-700 border-amber-200','confirmed'=>'bg-green-50 text-green-700 border-green-200','rejected'=>'bg-red-50 text-red-600 border-red-200'];
                $sl = ['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','rejected'=>'Ditolak'];
                @endphp
                <span class="text-sm font-semibold px-3 py-1.5 rounded-full border {{ $sc[$transaction->status] ?? '' }}">
                    {{ $sl[$transaction->status] ?? '-' }}
                </span>
            </div>
        </div>

        <div class="p-6 space-y-5">

            {{-- Info Produk --}}
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                <div class="w-12 h-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if($transaction->product?->image)
                        <img src="{{ asset('storage/'.$transaction->product->image) }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/><path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $transaction->product->name ?? '—' }}</p>
                    <p class="text-xs font-mono text-gray-400">{{ $transaction->product->sku ?? '' }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $transaction->product->category->name ?? '' }}</p>
                </div>
                <a href="{{ route('admin.products.show', $transaction->product_id) }}"
                   class="ml-auto text-xs font-medium px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition flex-shrink-0">
                    Lihat Produk
                </a>
            </div>

            {{-- Grid Detail --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jumlah</p>
                    <p class="text-2xl font-bold {{ $transaction->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction->type === 'in' ? '+' : '-' }}{{ number_format($transaction->quantity) }}
                        <span class="text-sm font-normal text-gray-500">{{ $transaction->product->unit ?? '' }}</span>
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Transaksi</p>
                    <p class="text-base font-bold text-gray-800">{{ $transaction->date->format('d M Y') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Stok Sebelum</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ number_format($transaction->stock_before) }}
                        <span class="text-sm font-normal text-gray-500">{{ $transaction->product->unit ?? '' }}</span>
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Stok Sesudah</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ number_format($transaction->stock_after) }}
                        <span class="text-sm font-normal text-gray-500">{{ $transaction->product->unit ?? '' }}</span>
                    </p>
                </div>
            </div>

            {{-- Catatan --}}
            @if($transaction->notes)
            <div class="p-4 bg-blue-50 rounded-xl">
                <p class="text-xs font-semibold text-blue-400 uppercase tracking-wider mb-1.5">Catatan</p>
                <p class="text-sm text-blue-700 leading-relaxed">{{ $transaction->notes }}</p>
            </div>
            @endif

            {{-- Dicatat Oleh --}}
            <div class="border border-gray-100 rounded-xl overflow-hidden">
                <div class="px-4 py-2 bg-gray-50 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Riwayat Proses</p>
                </div>

                {{-- Yang mencatat --}}
                <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-50">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold text-gray-700">{{ $transaction->user->name ?? '—' }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 font-medium">
                                {{ $transaction->user->role_label ?? '' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">Mencatat transaksi</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</p>
                    </div>
                </div>

                {{-- Yang konfirmasi/tolak --}}
                @if($transaction->status !== 'pending' && $transaction->confirmedByUser)
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0
                        {{ $transaction->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ strtoupper(substr($transaction->confirmedByUser->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold text-gray-700">
                                {{ $transaction->confirmedByUser->name ?? '—' }}
                            </p>
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $transaction->status === 'confirmed' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $transaction->confirmedByUser->role_label ?? '' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $transaction->status === 'confirmed' ? 'Mengkonfirmasi transaksi' : 'Menolak transaksi' }}
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        @if($transaction->confirmed_at)
                        <p class="text-xs text-gray-500">{{ $transaction->confirmed_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $transaction->confirmed_at->format('H:i') }}</p>
                        @endif
                    </div>
                </div>

                @elseif($transaction->status === 'pending')
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-amber-700">Menunggu Konfirmasi Staff</p>
                        <p class="text-xs text-gray-400 mt-0.5">Belum ada staff yang mengkonfirmasi</p>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection