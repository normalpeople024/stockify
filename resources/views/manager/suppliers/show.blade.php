{{-- resources/views/manager/suppliers/show.blade.php --}}
@extends('layouts.app1')
@section('title', 'Detail Supplier')
@section('page-title', 'Detail Supplier')
@section('breadcrumb', 'Manajer Gudang / Supplier / Detail')

@section('content')
<div class="space-y-5">

    <a href="{{ route('manager.suppliers.index') }}"
       class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition w-fit">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
            <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali ke Daftar Supplier
    </a>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- Info Utama --}}
        <div class="xl:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $supplier->name }}</h2>
                        @if($supplier->contact_person)
                        <p class="text-sm text-gray-400 mt-1">Kontak: {{ $supplier->contact_person }}</p>
                        @endif
                    </div>
                    @if($supplier->is_active)
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-green-50 text-green-700 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">No. Telepon</p>
                        <p class="text-sm font-medium text-gray-700">{{ $supplier->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Email</p>
                        <p class="text-sm font-medium text-gray-700">{{ $supplier->email ?? '—' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Alamat</p>
                        <p class="text-sm font-medium text-gray-700 leading-relaxed">{{ $supplier->address ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Terdaftar Sejak</p>
                        <p class="text-sm font-medium text-gray-700">{{ $supplier->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Total Produk</p>
                        <p class="text-sm font-bold text-gray-700">{{ $supplier->products->count() }} produk</p>
                    </div>
                </div>
            </div>

            {{-- Daftar Produk dari Supplier --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700">Produk dari Supplier Ini</h3>
                    <span class="text-xs text-gray-400">{{ $supplier->products->count() }} produk</span>
                </div>
                @if($supplier->products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                                <th class="px-5 py-3 text-left font-semibold">Produk</th>
                                <th class="px-5 py-3 text-left font-semibold">Kategori</th>
                                <th class="px-5 py-3 text-right font-semibold">Harga Beli</th>
                                <th class="px-5 py-3 text-center font-semibold">Stok</th>
                                <th class="px-5 py-3 text-center font-semibold">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        @foreach($supplier->products as $product)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-3">
                                <a href="{{ route('manager.products.show', $product) }}"
                                   class="font-semibold text-gray-800 hover:text-green-600 transition">
                                    {{ $product->name }}
                                </a>
                                <p class="text-xs font-mono text-gray-400">{{ $product->sku ?? '—' }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                                    {{ $product->category->name ?? '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right font-medium text-gray-700">
                                Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-center font-bold {{ $product->is_low_stock ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $product->stock }}
                                <span class="text-xs font-normal text-gray-400">{{ $product->unit }}</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($product->stock == 0)
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-700">Kosong</span>
                                @elseif($product->is_low_stock)
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Menipis</span>
                                @else
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-green-50 text-green-700">Aman</span>
                                @endif
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
                            <path d="M20 7l-8-4-8 4m16 0v10l-8 4m-8-4V7m8 4l8-4M4 7l8 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Belum ada produk dari supplier ini</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
                <h3 class="text-sm font-semibold text-gray-700">Ringkasan</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Produk</span>
                        <span class="text-sm font-bold text-gray-700">{{ $supplier->products->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Produk Aktif</span>
                        <span class="text-sm font-bold text-green-600">
                            {{ $supplier->products->where('is_active', true)->count() }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-50">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Stok Menipis</span>
                        <span class="text-sm font-bold text-red-600">
                            {{ $supplier->products->filter(fn($p) => $p->is_low_stock)->count() }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</span>
                        @if($supplier->is_active)
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">Aktif</span>
                        @else
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Aksi Cepat</p>
                <a href="{{ route('manager.products.index') }}"
                   class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0v10l-8 4m-8-4V7m8 4l8-4M4 7l8 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Lihat Semua Produk
                </a>
                <a href="{{ route('manager.stock.create-in') }}"
                   class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-green-50 hover:text-green-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Catat Barang Masuk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection