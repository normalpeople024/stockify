{{-- resources/views/admin/products/edit.blade.php --}}
@extends('layouts.app1')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('breadcrumb', 'Admin / Produk / Edit')

@section('content')
<div class="space-y-5">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}"
                class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Kembali ke Daftar Produk
            </a>
        </div>
        
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            <div class="xl:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-5">Informasi Produk</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama
                                Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kategori
                                    <span class="text-red-500">*</span></label>
                                <select name="category_id" required
                                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Supplier</label>
                                <select name="supplier_id"
                                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                                    <option value="">— Pilih Supplier —</option>
                                    @foreach ($suppliers as $s)
                                        <option value="{{ $s->id }}" @selected(old('supplier_id', $product->supplier_id) == $s->id)>{{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">SKU</label>
                                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Satuan
                                    <span class="text-red-500">*</span></label>
                                <select name="unit" required
                                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                                    @foreach (['pcs', 'unit', 'kg', 'gram', 'liter', 'ml', 'box', 'lusin', 'karton', 'roll', 'meter'] as $u)
                                        <option value="{{ $u }}" @selected(old('unit', $product->unit) === $u)>{{ $u }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>
                        {{-- Ganti bagian checkbox is_active yang lama dengan ini --}}
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            {{-- Hidden input ini penting! Mengirim nilai 0 saat checkbox tidak dicentang --}}
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                @checked(old('is_active', $product->is_active))
                                class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer">Produk
                                Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-5">Harga & Stok Minimum</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Harga
                                Beli (Rp)</label>
                            <input type="number" name="purchase_price"
                                value="{{ old('purchase_price', $product->purchase_price) }}" min="0"
                                class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Harga
                                Jual (Rp)</label>
                            <input type="number" name="selling_price"
                                value="{{ old('selling_price', $product->selling_price) }}" min="0"
                                class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Stok
                                Minimum</label>
                            <input type="number" name="minimum_stock"
                                value="{{ old('minimum_stock', $product->minimum_stock) }}" min="0"
                                class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                            <p class="text-xs text-gray-400 mt-1">Stok saat ini: <strong>{{ $product->stock }}
                                    {{ $product->unit }}</strong> (ubah stok via transaksi)</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-sm font-semibold text-gray-700">Atribut Produk</h3>
                        <button type="button" onclick="addAttr()"
                            class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 16 16">
                                <path d="M8 3v10M3 8h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Tambah
                        </button>
                    </div>
                    <div id="attr-list" class="space-y-3">
                        @foreach ($product->attributes as $idx => $attr)
                            <div class="flex gap-2 items-center" id="attr-row-{{ $idx }}">
                                <input type="text" name="attributes[{{ $idx }}][name]"
                                    value="{{ $attr->name }}" placeholder="Nama atribut"
                                    class="flex-1 h-9 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-400">
                                <input type="text" name="attributes[{{ $idx }}][value]"
                                    value="{{ $attr->value }}" placeholder="Nilai"
                                    class="flex-1 h-9 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-400">
                                <button type="button" onclick="removeAttr({{ $idx }})"
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 flex items-center justify-center flex-shrink-0 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 16 16">
                                        <path d="M3 8h10" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <p id="attr-empty"
                        class="{{ $product->attributes->count() ? 'hidden' : '' }} text-xs text-gray-400 text-center py-4">
                        Belum ada atribut.
                    </p>
                </div>
            </div>

            <div class="space-y-5">
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-5">Gambar Produk</h3>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-green-400 transition cursor-pointer"
                        onclick="document.getElementById('img-input').click()">
                        @if ($product->image)
                            <div id="img-preview-wrap" class="mb-3">
                                <img id="img-preview" src="{{ asset('storage/' . $product->image) }}"
                                    class="w-full h-40 object-contain rounded-lg">
                            </div>
                            <p class="text-xs text-gray-400">Klik untuk mengganti gambar</p>
                        @else
                            <div id="img-preview-wrap" class="hidden mb-4">
                                <img id="img-preview" src="" class="w-full h-40 object-contain rounded-lg">
                            </div>
                            <div id="img-placeholder">
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="2"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor" />
                                        <path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Upload gambar</p>
                            </div>
                        @endif
                        <input type="file" id="img-input" name="image_file" accept="image/*" class="hidden"
                            onchange="previewImg(this)">
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-3">
                    <button type="submit" class="w-full h-10 text-sm font-semibold text-white rounded-xl transition"
                        style="background:#1D9E75" onmouseover="this.style.background='#0F6E56'"
                        onmouseout="this.style.background='#1D9E75'">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="block w-full h-10 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>
    
@endsection

@push('scripts')
    <script>
        let attrCount = {{ $product->attributes->count() }};

        function addAttr() {
            document.getElementById('attr-empty').classList.add('hidden');
            const i = attrCount++;
            const row = document.createElement('div');
            row.className = 'flex gap-2 items-center';
            row.id = 'attr-row-' + i;
            row.innerHTML = `
            <input type="text" name="attributes[${i}][name]" placeholder="Nama atribut"
                class="flex-1 h-9 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-400">
            <input type="text" name="attributes[${i}][value]" placeholder="Nilai"
                class="flex-1 h-9 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-400">
            <button type="button" onclick="removeAttr(${i})"
                class="w-8 h-8 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 flex items-center justify-center flex-shrink-0 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 16 16">
                    <path d="M3 8h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>`;
            document.getElementById('attr-list').appendChild(row);
        }

        function removeAttr(i) {
            document.getElementById('attr-row-' + i)?.remove();
            if (!document.querySelector('#attr-list > div')) {
                document.getElementById('attr-empty').classList.remove('hidden');
            }
        }

        function previewImg(input) {
            if (input.files && input.files[0]) {
                const r = new FileReader();
                r.onload = e => {
                    document.getElementById('img-preview').src = e.target.result;
                    document.getElementById('img-preview-wrap').classList.remove('hidden');
                    const ph = document.getElementById('img-placeholder');
                    if (ph) ph.classList.add('hidden');
                };
                r.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
