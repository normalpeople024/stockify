{{-- resources/views/manager/products/show.blade.php --}}
@extends('layouts.app1')
@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')
@section('breadcrumb', 'Manajer Gudang / Produk / Detail')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('manager.products.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali ke Daftar Produk
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('manager.stock.create-in') }}"
               class="flex items-center gap-2 h-9 px-4 text-sm font-semibold text-white rounded-xl transition"
               style="background:#1D9E75"
               onmouseover="this.style.background='#0F6E56'"
               onmouseout="this.style.background='#1D9E75'">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Barang Masuk
            </a>
            <a href="{{ route('manager.stock.create-out') }}"
               class="flex items-center gap-2 h-9 px-4 text-sm font-semibold text-red-600 border border-red-200 rounded-xl hover:bg-red-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Barang Keluar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- Kolom Kiri --}}
        <div class="xl:col-span-2 space-y-5">

            {{-- Info Utama --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-400 mt-1 font-mono">{{ $product->sku ?? 'Tidak ada SKU' }}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                        @if($product->is_active)
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                            </span>
                        @endif
                        @if($product->is_low_stock)
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-red-50 text-red-700 border border-red-200">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 16 16"><path d="M8 6v4M8 11.5v.5M6.29 2.57L1.14 11a2 2 0 001.71 3h10.3a2 2 0 001.71-3L9.71 2.57a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                                Stok Menipis
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Kategori</p>
                        <span class="inline-flex text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">
                            {{ $product->category->name ?? '—' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Supplier</p>
                        <p class="font-medium text-gray-700">{{ $product->supplier->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Satuan</p>
                        <p class="font-medium text-gray-700">{{ $product->unit }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Ditambahkan</p>
                        <p class="font-medium text-gray-700">{{ $product->created_at->format('d M Y') }}</p>
                    </div>
                    @if($product->description)
                    <div class="col-span-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Deskripsi</p>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Harga & Stok --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-5">Harga & Stok</h3>
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Harga Beli</p>
                        <p class="text-lg font-bold text-gray-800">
                            Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Harga Jual</p>
                        <p class="text-lg font-bold text-gray-800">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="{{ $product->is_low_stock ? 'bg-red-50' : 'bg-green-50' }} rounded-xl p-4">
                        <p class="text-xs font-semibold {{ $product->is_low_stock ? 'text-red-400' : 'text-green-400' }} uppercase tracking-wider mb-2">Stok Saat Ini</p>
                        <p class="text-lg font-bold {{ $product->is_low_stock ? 'text-red-700' : 'text-green-700' }}">
                            {{ number_format($product->stock) }}
                            <span class="text-sm font-normal">{{ $product->unit }}</span>
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Stok Minimum</p>
                        <p class="text-lg font-bold text-gray-800">
                            {{ number_format($product->minimum_stock) }}
                            <span class="text-sm font-normal text-gray-500">{{ $product->unit }}</span>
                        </p>
                    </div>
                </div>

                {{-- Nilai stok --}}
                <div class="mt-4 p-4 bg-blue-50 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-blue-400 uppercase tracking-wider">Total Nilai Stok</p>
                        <p class="text-sm text-blue-600 mt-0.5">
                            {{ $product->stock }} × Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                        </p>
                    </div>
                    <p class="text-xl font-bold text-blue-700">
                        Rp {{ number_format($product->stock * $product->purchase_price, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Atribut --}}
            @if($product->attributes->count() > 0)
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Atribut Produk</h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($product->attributes as $attr)
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-xl">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ $attr->name }}</span>
                        <span class="text-sm font-semibold text-gray-700">{{ $attr->value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Riwayat Transaksi --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700">Riwayat Transaksi</h3>
                    <a href="{{ route('manager.reports.transactions', ['product_id' => $product->id]) }}"
                       class="text-xs font-medium text-green-600 hover:text-green-700">Lihat semua →</a>
                </div>
                @if($product->stockTransactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                                <th class="px-5 py-3 text-left font-semibold">No. Ref</th>
                                <th class="px-5 py-3 text-center font-semibold">Tipe</th>
                                <th class="px-5 py-3 text-right font-semibold">Qty</th>
                                <th class="px-5 py-3 text-right font-semibold">Stok Sesudah</th>
                                <th class="px-5 py-3 text-left font-semibold">Oleh</th>
                                <th class="px-5 py-3 text-center font-semibold">Tanggal</th>
                                <th class="px-5 py-3 text-center font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        @foreach($product->stockTransactions->sortByDesc('created_at')->take(10) as $trx)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $trx->reference_no ?? '—' }}</td>
                            <td class="px-5 py-3 text-center">
                                @if($trx->type === 'in')
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-50 text-green-700">↓ Masuk</span>
                                @elseif($trx->type === 'out')
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-red-50 text-red-700">↑ Keluar</span>
                                @else
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-50 text-blue-700">Opname</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right font-bold text-gray-700">{{ $trx->quantity }}</td>
                            <td class="px-5 py-3 text-right text-gray-500">{{ $trx->stock_after }}</td>
                            <td class="px-5 py-3 text-gray-600 text-xs">{{ $trx->user->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-center text-xs text-gray-500 whitespace-nowrap">
                                {{ $trx->date->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @php
                                $sc = ['pending'=>'bg-amber-50 text-amber-700','confirmed'=>'bg-green-50 text-green-700','rejected'=>'bg-red-50 text-red-600'];
                                $sl = ['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','rejected'=>'Ditolak'];
                                @endphp
                                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $sc[$trx->status] ?? '' }}">
                                    {{ $sl[$trx->status] ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Belum ada transaksi</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="space-y-5">

            {{-- Gambar --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Gambar Produk</h3>
                <div class="rounded-xl overflow-hidden bg-gray-50 border border-gray-100 flex items-center justify-center" style="min-height:200px">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full object-contain max-h-64">
                    @else
                        <div class="text-center py-8 px-4">
                            <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/>
                                    <path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-400 font-medium">Tidak ada gambar</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info Singkat --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
                <h3 class="text-sm font-semibold text-gray-700">Informasi Singkat</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">SKU</span>
                        <span class="font-mono text-xs text-gray-700 font-semibold">{{ $product->sku ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Kategori</span>
                        <span class="text-sm font-semibold text-gray-700">{{ $product->category->name ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Supplier</span>
                        <span class="text-sm font-semibold text-gray-700 text-right max-w-[130px] truncate">{{ $product->supplier->name ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Satuan</span>
                        <span class="text-sm font-semibold text-gray-700">{{ $product->unit }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Atribut</span>
                        <span class="text-sm font-semibold text-gray-700">{{ $product->attributes->count() }} item</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Update</span>
                        <span class="text-xs text-gray-600">{{ $product->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Aksi Cepat</p>
                <a href="{{ route('manager.stock.create-in') }}"
                   class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-green-50 hover:text-green-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Catat Barang Masuk
                </a>
                <a href="{{ route('manager.stock.create-out') }}"
                   class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Catat Barang Keluar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection