{{-- resources/views/admin/settings/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Aplikasi')
@section('breadcrumb', 'Admin / Pengaturan')

@section('content')
<div class="max-w-3xl space-y-5">

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

        {{-- Identitas Aplikasi --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-5 pb-3 border-b border-gray-50">
                Identitas Aplikasi
            </h3>
            <div class="space-y-4">

                {{-- Logo --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Logo Aplikasi</label>
                    <div class="flex items-center gap-5">
                        <div class="w-20 h-20 rounded-2xl bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if(!empty($settings['app_logo']))
                                <img src="{{ asset('storage/'.$settings['app_logo']) }}" class="w-full h-full object-contain p-2" id="logo-preview">
                            @else
                                <div id="logo-placeholder" class="text-center">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/><path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                </div>
                                <img src="" class="w-full h-full object-contain p-2 hidden" id="logo-preview">
                            @endif
                        </div>
                        <div class="space-y-2">
                            <label for="logo-input"
                                class="inline-flex items-center gap-2 h-9 px-4 text-sm font-medium border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 cursor-pointer transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Upload Logo
                            </label>
                            <input type="file" id="logo-input" name="logo_file" accept="image/*" class="hidden" onchange="previewLogo(this)">
                            <p class="text-xs text-gray-400">PNG, JPG, WEBP. Maks 1MB. Rekomendasi: 200×200px</p>
                            {{-- 
                            @if(!empty($settings['app_logo']))
                            <a href="{{ route('admin.settings.delete-logo') }}"
                               onclick="return confirm('Hapus logo?')"
                               class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus logo</a>
                            @endif
                             --}}
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Nama Aplikasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'Stockify' }}" required
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Deskripsi Aplikasi
                    </label>
                    <input type="text" name="app_description" value="{{ $settings['app_description'] ?? '' }}"
                        placeholder="Sistem Manajemen Stok Gudang"
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                </div>
            </div>
        </div>

        {{-- Informasi Perusahaan --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-5 pb-3 border-b border-gray-50">
                Informasi Perusahaan
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Perusahaan</label>
                    <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}"
                        placeholder="PT. Nama Perusahaan"
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">No. Telepon</label>
                        <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}"
                            placeholder="021-1234567"
                            class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email Perusahaan</label>
                        <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}"
                            placeholder="info@perusahaan.com"
                            class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Alamat Perusahaan</label>
                    <textarea name="company_address" rows="2"
                        placeholder="Jl. Contoh No. 1, Kota, Provinsi"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 resize-none">{{ $settings['company_address'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Preferensi Sistem --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-5 pb-3 border-b border-gray-50">
                Preferensi Sistem
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Simbol Mata Uang</label>
                    <input type="text" name="currency" value="{{ $settings['currency'] ?? 'Rp' }}"
                        class="w-32 h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                    <p class="text-xs text-gray-400 mt-1">Simbol yang ditampilkan sebelum angka harga</p>
                </div>
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                    <input type="hidden" name="low_stock_alert" value="0">
                    <input type="checkbox" name="low_stock_alert" id="low_stock_alert" value="1"
                        @checked(($settings['low_stock_alert'] ?? '1') === '1')
                        class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="low_stock_alert" class="cursor-pointer">
                        <p class="text-sm font-medium text-gray-700">Aktifkan peringatan stok menipis</p>
                        <p class="text-xs text-gray-400">Tampilkan notifikasi di sidebar ketika stok produk mencapai minimum</p>
                    </label>
                </div>
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex gap-3">
            <button type="submit"
                class="h-10 px-6 text-sm font-semibold text-white rounded-xl transition"
                style="background:#1D9E75"
                onmouseover="this.style.background='#0F6E56'"
                onmouseout="this.style.background='#1D9E75'">
                Simpan Pengaturan
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview     = document.getElementById('logo-preview');
            const placeholder = document.getElementById('logo-placeholder');
            preview.src       = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush