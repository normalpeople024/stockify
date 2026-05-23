{{-- resources/views/admin/suppliers/create.blade.php --}}
@extends('layouts.app1')
@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier')
@section('breadcrumb', 'Admin / Supplier / Tambah')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
            <a href="{{ route('admin.suppliers.index') }}"
                class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Kembali ke Daftar Suppliers
            </a>
        </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.suppliers.store') }}" class="space-y-5">
        @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Nama Supplier <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="Contoh: PT Sumber Elektronik"
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Nama Kontak
                    </label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                        placeholder="Nama PIC supplier"
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        No. Telepon
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        placeholder="Contoh: 021-1234567"
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                </div>

                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="email@supplier.com"
                        class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Alamat
                    </label>
                    <textarea name="address" rows="3"
                        placeholder="Alamat lengkap supplier..."
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 resize-none">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="h-10 px-6 text-sm font-semibold text-white rounded-xl transition"
                    style="background:#1D9E75"
                    onmouseover="this.style.background='#0F6E56'"
                    onmouseout="this.style.background='#1D9E75'">
                    Simpan
                </button>
                <a href="{{ route('admin.suppliers.index') }}"
                   class="h-10 px-6 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection