{{-- resources/views/admin/stock/opname.blade.php --}}
@extends('layouts.app1')
@section('title', 'Stock Opname')
@section('page-title', 'Stock Opname')
@section('breadcrumb', 'Admin / Stok / Stock Opname')

@section('content')
<div class="space-y-5">

    {{-- Info --}}
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        <div>
            <p class="text-sm font-semibold text-blue-700">Cara melakukan Stock Opname</p>
            <p class="text-xs text-blue-600 mt-1">
                Masukkan jumlah stok fisik aktual untuk setiap produk. Sistem akan otomatis menghitung selisih dan memperbarui stok.
                Produk yang stoknya sama tidak perlu diubah. Stock opname langsung dikonfirmasi tanpa perlu persetujuan staff.
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                    class="w-full pl-9 pr-4 h-9 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:border-green-400">
            </div>
            <select name="category_id" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">Filter</button>
        </form>
    </div>

    {{-- Form Opname --}}
    <form method="POST" action="{{ route('admin.stock.opname.store') }}">
    @csrf
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <h3 class="text-sm font-semibold text-gray-700">Data Stok Produk</h3>
            <div class="flex items-center gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1">Catatan Opname</label>
                    <input type="text" name="notes" placeholder="Contoh: Opname bulanan Oktober 2024"
                        class="h-8 px-3 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-green-400 w-64">
                </div>
                <button type="submit"
                    class="flex items-center gap-2 h-9 px-4 text-sm font-semibold text-white rounded-xl transition mt-4"
                    style="background:#1D9E75"
                    onmouseover="this.style.background='#0F6E56'"
                    onmouseout="this.style.background='#1D9E75'"
                    onclick="return confirm('Simpan hasil stock opname? Stok akan diperbarui sesuai data aktual.')">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Simpan Opname
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="px-5 py-3 text-left font-semibold">Produk</th>
                        <th class="px-5 py-3 text-left font-semibold">Kategori</th>
                        <th class="px-5 py-3 text-center font-semibold">Stok Sistem</th>
                        <th class="px-5 py-3 text-center font-semibold w-40">Stok Aktual</th>
                        <th class="px-5 py-3 text-center font-semibold">Selisih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="opname-table">
                @foreach($products as $i => $product)
                <tr class="hover:bg-gray-50/50 transition" data-system="{{ $product->stock }}" id="row-{{ $product->id }}">
                    <td class="px-5 py-3">
                        <input type="hidden" name="items[{{ $i }}][product_id]" value="{{ $product->id }}">
                        <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                        <p class="text-xs font-mono text-gray-400">{{ $product->sku ?? '—' }}</p>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-500">{{ $product->category->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-center font-bold text-gray-700" id="system-{{ $product->id }}">
                        {{ $product->stock }}
                        <span class="text-xs font-normal text-gray-400">{{ $product->unit }}</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <input type="number"
                            name="items[{{ $i }}][actual_stock]"
                            value="{{ $product->stock }}"
                            min="0"
                            id="actual-{{ $product->id }}"
                            onchange="calcDiff({{ $product->id }}, {{ $product->stock }})"
                            class="w-28 h-9 px-3 text-center border border-gray-200 rounded-lg text-sm font-semibold focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-500/20">
                    </td>
                    <td class="px-5 py-3 text-center" id="diff-{{ $product->id }}">
                        <span class="text-xs font-semibold text-gray-400">—</span>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $products->withQueryString()->links() }}</div>
        @endif
    </div>
    </form>

    {{-- Riwayat Opname --}}
    @if($history->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50">
            <h3 class="text-sm font-semibold text-gray-700">Riwayat Stock Opname</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="px-5 py-3 text-left font-semibold">No. Ref</th>
                        <th class="px-5 py-3 text-left font-semibold">Produk</th>
                        <th class="px-5 py-3 text-right font-semibold">Stok Sebelum</th>
                        <th class="px-5 py-3 text-right font-semibold">Stok Sesudah</th>
                        <th class="px-5 py-3 text-center font-semibold">Selisih</th>
                        <th class="px-5 py-3 text-left font-semibold">Oleh</th>
                        <th class="px-5 py-3 text-center font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @foreach($history as $trx)
                @php $diff = $trx->stock_after - $trx->stock_before; @endphp
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-3 font-mono text-xs text-gray-400">{{ $trx->reference_no }}</td>
                    <td class="px-5 py-3 font-semibold text-gray-800">{{ $trx->product->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-right text-gray-600">{{ $trx->stock_before }}</td>
                    <td class="px-5 py-3 text-right text-gray-600">{{ $trx->stock_after }}</td>
                    <td class="px-5 py-3 text-center">
                        @if($diff > 0)
                            <span class="text-xs font-bold text-green-600">+{{ $diff }}</span>
                        @elseif($diff < 0)
                            <span class="text-xs font-bold text-red-600">{{ $diff }}</span>
                        @else
                            <span class="text-xs text-gray-400">0</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-500">{{ $trx->user->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-center text-xs text-gray-500">{{ $trx->date->format('d M Y') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function calcDiff(productId, systemStock) {
    const actual = parseInt(document.getElementById('actual-' + productId).value) || 0;
    const diff   = actual - systemStock;
    const el     = document.getElementById('diff-' + productId);
    const row    = document.getElementById('row-' + productId);

    if (diff > 0) {
        el.innerHTML  = `<span class="text-xs font-bold text-green-600">+${diff}</span>`;
        row.classList.add('bg-green-50/30');
        row.classList.remove('bg-red-50/30');
    } else if (diff < 0) {
        el.innerHTML  = `<span class="text-xs font-bold text-red-600">${diff}</span>`;
        row.classList.add('bg-red-50/30');
        row.classList.remove('bg-green-50/30');
    } else {
        el.innerHTML  = `<span class="text-xs text-gray-400">—</span>`;
        row.classList.remove('bg-green-50/30', 'bg-red-50/30');
    }
}
</script>
@endpush