{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('layouts.app1')
@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('breadcrumb', 'Admin / Kategori / Edit')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Kembali ke Daftar Kategori
            </a>
        </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 resize-none">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="h-10 px-6 text-sm font-semibold text-white rounded-xl transition"
                    style="background:#1D9E75" onmouseover="this.style.background='#0F6E56'" onmouseout="this.style.background='#1D9E75'">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="h-10 px-6 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection