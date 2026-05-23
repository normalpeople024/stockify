{{-- resources/views/manager/stock/create-in.blade.php --}}
@extends('layouts.app1')
@section('title', 'Barang Masuk')
@section('page-title', 'Catat Barang Masuk')
@section('breadcrumb', 'Manajer Gudang / Stok / Barang Masuk')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-100 p-6">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6 pb-5 border-b border-gray-50">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Form Penerimaan Barang</h3>
                <p class="text-xs text-gray-400 mt-0.5">Isi data barang yang diterima dari supplier</p>
            </div>
        </div>

        <form method="POST" action="{{ route('manager.stock.store-in') }}" class="space-y-5">
        @csrf

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Produk <span class="text-red-500">*</span>
                </label>
                <select name="product_id" required id="product-select"
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('product_id') border-red-400 @enderror">
                    <option value="">— Pilih Produk —</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}"
                        data-stock="{{ $p->stock }}"
                        data-unit="{{ $p->unit }}"
                        data-category="{{ $p->category->name ?? '' }}"
                        @selected(old('product_id') == $p->id)>
                        {{ $p->name }} (Stok: {{ $p->stock }} {{ $p->unit }})
                    </option>
                    @endforeach
                </select>
                @error('product_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

                {{-- Info stok saat ini --}}
                <div id="stock-info" class="hidden mt-2 p-3 bg-blue-50 rounded-xl">
                    <p class="text-xs text-blue-700">
                        Stok saat ini: <strong id="current-stock">0</strong> <span id="stock-unit"></span>
                        · Kategori: <span id="stock-category"></span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" min="1" required
                        placeholder="0"
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('quantity') border-red-400 @enderror">
                    @error('quantity')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    No. Referensi
                </label>
                <input type="text" name="reference_no" value="{{ old('reference_no') }}"
                    placeholder="Otomatis jika dikosongkan"
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                <p class="text-xs text-gray-400 mt-1">Contoh: NO-PO, nomor surat jalan, dll.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Catatan
                </label>
                <textarea name="notes" rows="3"
                    placeholder="Catatan tambahan (kondisi barang, keterangan lain, dll.)"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 resize-none">{{ old('notes') }}</textarea>
            </div>

            {{-- Info proses --}}
            <div class="p-4 bg-amber-50 rounded-xl">
                <p class="text-xs font-semibold text-amber-700 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Informasi
                </p>
                <p class="text-xs text-amber-600 mt-1">
                    Transaksi akan berstatus <strong>Menunggu</strong> hingga dikonfirmasi.
                    Stok baru akan bertambah setelah transaksi dikonfirmasi.
                </p>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="h-10 px-6 text-sm font-semibold text-white rounded-xl transition"
                    style="background:#1D9E75"
                    onmouseover="this.style.background='#0F6E56'"
                    onmouseout="this.style.background='#1D9E75'">
                    Simpan Transaksi
                </button>
                <a href="{{ route('manager.reports.transactions') }}"
                   class="h-10 px-6 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('product-select').addEventListener('change', function () {
    const opt   = this.options[this.selectedIndex];
    const info  = document.getElementById('stock-info');
    if (!this.value) { info.classList.add('hidden'); return; }
    document.getElementById('current-stock').textContent  = opt.dataset.stock;
    document.getElementById('stock-unit').textContent     = opt.dataset.unit;
    document.getElementById('stock-category').textContent = opt.dataset.category;
    info.classList.remove('hidden');
});

// Trigger jika ada old value
const sel = document.getElementById('product-select');
if (sel.value) sel.dispatchEvent(new Event('change'));
</script>
@endpush