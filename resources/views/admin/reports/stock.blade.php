{{-- resources/views/admin/reports/stock.blade.php --}}
@extends('layouts.app1')
@section('title', 'Laporan Stok')
@section('page-title', 'Laporan Stok Barang')
@section('breadcrumb', 'Admin / Laporan / Stok')

@section('content')
<div class="space-y-5">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        @php
        $cards = [
        ['label'=>'Total Produk', 'value'=>$summary['total_products'], 'color'=>'blue'],
        ['label'=>'Stok Menipis', 'value'=>$summary['total_low_stock'], 'color'=>'amber'],
        ['label'=>'Stok Kosong', 'value'=>$summary['total_empty'], 'color'=>'red'],
        ['label'=>'Nilai Stok', 'value'=>'Rp '.number_format($summary['total_value'],0,',','.'), 'color'=>'green'],
        ];
        $cc = ['blue'=>'bg-blue-50 text-blue-600','amber'=>'bg-amber-50 text-amber-600','red'=>'bg-red-50 text-red-600','green'=>'bg-green-50 text-green-600'];
        @endphp
        @foreach($cards as $c)
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">{{ $c['label'] }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $c['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1">Kategori</label>
                <select name="category_id" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('category_id')==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1">Status Stok</label>
                <select name="status" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua</option>
                    <option value="low" @selected(request('status')==='low' )>Stok Menipis</option>
                    <option value="empty" @selected(request('status')==='empty' )>Stok Kosong</option>
                </select>
            </div>
            <button class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">Terapkan</button>
            @if(request()->hasAny(['category_id','status']))
            <a href="{{ route('admin.reports.stock') }}" class="h-9 px-4 text-sm font-medium border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 flex items-center">Reset</a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <h3 class="text-sm font-semibold text-gray-700">Data Stok Produk</h3>
            <span class="text-xs text-gray-400">{{ $products->total() }} produk</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="px-6 py-3 text-left font-semibold">Produk</th>
                        <th class="px-6 py-3 text-left font-semibold">SKU</th>
                        <th class="px-6 py-3 text-left font-semibold">Kategori</th>
                        <th class="px-6 py-3 text-left font-semibold">Supplier</th>
                        <th class="px-6 py-3 text-right font-semibold">Harga Beli</th>
                        <th class="px-6 py-3 text-right font-semibold">Stok</th>
                        <th class="px-6 py-3 text-right font-semibold">Min. Stok</th>
                        <th class="px-6 py-3 text-right font-semibold">Nilai Stok</th>
                        <th class="px-6 py-3 text-center font-semibold">Kondisi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $p)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-3.5 font-semibold text-gray-800">{{ $p->name }}</td>
                        <td class="px-6 py-3.5 font-mono text-xs text-gray-400">{{ $p->sku ?? '—' }}</td>
                        <td class="px-6 py-3.5 text-gray-600 text-xs">{{ $p->category->name ?? '—' }}</td>
                        <td class="px-6 py-3.5 text-gray-600 text-xs">{{ $p->supplier->name ?? '—' }}</td>
                        <td class="px-6 py-3.5 text-right text-gray-700">Rp {{ number_format($p->purchase_price,0,',','.') }}</td>
                        <td class="px-6 py-3.5 text-right font-bold {{ $p->stock == 0 ? 'text-red-600' : ($p->is_low_stock ? 'text-amber-600' : 'text-gray-800') }}">{{ $p->stock }}</td>
                        <td class="px-6 py-3.5 text-right text-gray-500">{{ $p->minimum_stock }}</td>
                        <td class="px-6 py-3.5 text-right text-gray-700 font-medium">Rp {{ number_format($p->stock * $p->purchase_price,0,',','.') }}</td>
                        <td class="px-6 py-3.5 text-center">
                            @if($p->stock == 0)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-700">Kosong</span>
                            @elseif($p->is_low_stock)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">Menipis</span>
                            @else
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-green-50 text-green-700">Aman</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-gray-400">Tidak ada data produk.</td>
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