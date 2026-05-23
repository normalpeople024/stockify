{{-- resources/views/manager/stock/opname.blade.php --}}
@extends('layouts.app1')
@section('title', 'Stock Opname')
@section('page-title', 'Stock Opname')
@section('breadcrumb', 'Manajer Gudang / Stok / Stock Opname')

@section('content')
<div class="space-y-5">

    {{-- Info --}}
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24">
            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-blue-700">Panduan Stock Opname</p>
            <p class="text-xs text-blue-600 mt-1 leading-relaxed">
                Masukkan jumlah stok fisik aktual yang dihitung langsung di gudang.
                Sistem akan menghitung selisih secara otomatis dan memperbarui stok setelah disimpan.
                Produk yang stoknya tidak berubah tidak perlu diubah nilainya.
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama / SKU produk..."
                    class="w-full pl-9 pr-4 h-9 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-green-400">
            </div>
            <select name="category_id"
                class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">
                Filter
            </button>
            @if(request()->hasAny(['search','category_id']))
            <a href="{{ route('manager.stock.opname') }}"
               class="h-9 px-4 text-sm font-medium border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 flex items-center">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Form Opname --}}
    <form method="POST" action="{{ route('manager.stock.opname.store') }}">
    @csrf

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-50">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Data Stok Produk</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $products->total() }} produk</p>
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <div class="w-full sm:w-auto">
                    <input type="text" name="notes"
                        placeholder="Catatan opname (opsional)"
                        class="h-9 px-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-green-400 w-full sm:w-64">
                </div>
                <button type="submit"
                    class="flex items-center gap-2 h-9 px-4 text-sm font-semibold text-white rounded-xl transition whitespace-nowrap"
                    style="background:#1D9E75"
                    onmouseover="this.style.background='#0F6E56'"
                    onmouseout="this.style.background='#1D9E75'"
                    onclick="return confirm('Simpan hasil stock opname? Stok akan langsung diperbarui.')">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
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
                        <th class="px-5 py-3 text-center font-semibold w-44">Stok Aktual (Fisik)</th>
                        <th class="px-5 py-3 text-center font-semibold">Selisih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @foreach($products as $i => $product)
                <tr class="hover:bg-gray-50/30 transition" id="row-{{ $product->id }}">
                    <td class="px-5 py-3.5">
                        <input type="hidden" name="items[{{ $i }}][product_id]" value="{{ $product->id }}">
                        <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                        <p class="text-xs font-mono text-gray-400">{{ $product->sku ?? '—' }}</p>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                            {{ $product->category->name ?? '—' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="text-base font-bold {{ $product->is_low_stock ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $product->stock }}
                        </span>
                        <span class="text-xs text-gray-400 ml-1">{{ $product->unit }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <input type="number"
                            name="items[{{ $i }}][actual_stock]"
                            value="{{ $product->stock }}"
                            min="0"
                            id="actual-{{ $product->id }}"
                            onchange="calcDiff({{ $product->id }}, {{ $product->stock }})"
                            oninput="calcDiff({{ $product->id }}, {{ $product->stock }})"
                            class="w-28 h-9 px-3 text-center border border-gray-200 rounded-xl text-sm font-semibold
                                   focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-500/20
                                   transition">
                    </td>
                    <td class="px-5 py-3.5 text-center" id="diff-{{ $product->id }}">
                        <span class="text-xs font-semibold text-gray-300">—</span>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">
            {{ $products->withQueryString()->links() }}
        </div>
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
                    <td class="px-5 py-3">
                        <p class="font-semibold text-gray-800">{{ $trx->product->name ?? '—' }}</p>
                    </td>
                    <td class="px-5 py-3 text-right text-gray-600">{{ $trx->stock_before }}</td>
                    <td class="px-5 py-3 text-right text-gray-600">{{ $trx->stock_after }}</td>
                    <td class="px-5 py-3 text-center">
                        @if($diff > 0)
                            <span class="text-xs font-bold text-green-600">+{{ $diff }}</span>
                        @elseif($diff < 0)
                            <span class="text-xs font-bold text-red-600">{{ $diff }}</span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-500">{{ $trx->user->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-center text-xs text-gray-500 whitespace-nowrap">
                        {{ $trx->date->format('d M Y') }}
                    </td>
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
    const input  = document.getElementById('actual-' + productId);
    const diffEl = document.getElementById('diff-' + productId);
    const row    = document.getElementById('row-' + productId);
    const actual = parseInt(input.value) || 0;
    const diff   = actual - systemStock;

    // Reset class row
    row.classList.remove('bg-green-50/30', 'bg-red-50/30');

    if (diff > 0) {
        diffEl.innerHTML = `<span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">+${diff}</span>`;
        row.classList.add('bg-green-50/30');
    } else if (diff < 0) {
        diffEl.innerHTML = `<span class="inline-flex items-center gap-1 text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">${diff}</span>`;
        row.classList.add('bg-red-50/30');
    } else {
        diffEl.innerHTML = `<span class="text-xs font-semibold text-gray-300">—</span>`;
    }

    // Update warna border input
    input.classList.remove('border-green-400', 'border-red-400', 'border-gray-200');
    if (diff > 0)      input.classList.add('border-green-400');
    else if (diff < 0) input.classList.add('border-red-400');
    else               input.classList.add('border-gray-200');
}
</script>
@endpush