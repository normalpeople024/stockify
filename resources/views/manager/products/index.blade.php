{{-- resources/views/manager/products/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Produk')
@section('page-title', 'Daftar Produk')
@section('breadcrumb', 'Manajer Gudang / Produk')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" class="flex flex-wrap gap-2 flex-1">
            <div class="relative min-w-[220px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / SKU..."
                    class="w-full pl-9 pr-4 h-9 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
            </div>
            <select name="category_id" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category_id')==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <select name="low_stock" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none">
                <option value="">Semua Stok</option>
                <option value="1" @selected(request('low_stock'))>Stok Menipis</option>
            </select>
            <button class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">Filter</button>
            @if(request()->hasAny(['search','category_id','low_stock']))
            <a href="{{ route('manager.products.index') }}" class="h-9 px-4 text-sm font-medium border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 flex items-center">Reset</a>
            @endif
        </form>
        <a href="{{ route('manager.products.create') }}"
            class="flex items-center gap-2 h-9 px-4 text-sm font-semibold text-white rounded-xl flex-shrink-0 transition"
            style="background:#1D9E75" onmouseover="this.style.background='#0F6E56'" onmouseout="this.style.background='#1D9E75'">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
            Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="px-6 py-3.5 text-left font-semibold">Produk</th>
                        <th class="px-6 py-3.5 text-left font-semibold">Kategori</th>
                        <th class="px-6 py-3.5 text-left font-semibold">Supplier</th>
                        <th class="px-6 py-3.5 text-right font-semibold">Harga Jual</th>
                        <th class="px-6 py-3.5 text-center font-semibold">Stok</th>
                        <th class="px-6 py-3.5 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 flex-shrink-0 overflow-hidden flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/><path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                                <p class="text-xs font-mono text-gray-400">{{ $product->sku ?? '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">
                            {{ $product->category->name ?? '—' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-xs">{{ $product->supplier->name ?? '—' }}</td>
                    <td class="px-6 py-4 text-right font-semibold text-gray-800">
                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($product->is_low_stock)
                        <span class="inline-flex flex-col items-center">
                            <span class="text-base font-bold text-red-600">{{ $product->stock }}</span>
                            <span class="text-[10px] font-semibold text-red-400 bg-red-50 px-1.5 rounded-full">menipis</span>
                        </span>
                        @else
                        <span class="text-base font-bold text-gray-700">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('manager.products.show', $product) }}"
                               class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition" title="Detail">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
                            </a>
                            <a href="{{ route('manager.stock.create-in') }}"
                               class="w-7 h-7 rounded-lg bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition" title="Barang Masuk">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                            <a href="{{ route('manager.stock.create-out') }}"
                               class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition" title="Barang Keluar">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-14 text-center">
                        <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0v10l-8 4m-8-4V7m8 4l8-4M4 7l8 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Tidak ada produk ditemukan</p>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $products->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection