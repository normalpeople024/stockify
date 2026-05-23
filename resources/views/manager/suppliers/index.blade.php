{{-- resources/views/manager/suppliers/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Supplier')
@section('page-title', 'Daftar Supplier')
@section('breadcrumb', 'Manajer Gudang / Supplier')

@section('content')
<div class="space-y-4">
    <form method="GET" class="flex gap-2">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari supplier..."
                class="pl-9 pr-4 h-9 text-sm border border-gray-200 rounded-xl bg-white w-72 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
        </div>
        <button class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl">Cari</button>
    </form>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                    <th class="px-6 py-3.5 text-left font-semibold">Nama Supplier</th>
                    <th class="px-6 py-3.5 text-left font-semibold">Kontak</th>
                    <th class="px-6 py-3.5 text-left font-semibold">Alamat</th>
                    <th class="px-6 py-3.5 text-center font-semibold">Produk</th>
                    <th class="px-6 py-3.5 text-center font-semibold">Status</th>
                    <th class="px-6 py-3.5 text-center font-semibold">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
            @forelse($suppliers as $sup)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-800">{{ $sup->name }}</p>
                    <p class="text-xs text-gray-400">{{ $sup->contact_person ?? '' }}</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-xs text-gray-700">{{ $sup->phone ?? '—' }}</p>
                    <p class="text-xs text-gray-400">{{ $sup->email ?? '' }}</p>
                </td>
                <td class="px-6 py-4 text-gray-500 text-xs max-w-[180px] truncate">{{ $sup->address ?? '—' }}</td>
                <td class="px-6 py-4 text-center font-bold text-gray-700">{{ $sup->products_count }}</td>
                <td class="px-6 py-4 text-center">
                    @if($sup->is_active)
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">Aktif</span>
                    @else
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('manager.suppliers.show', $sup) }}"
                       class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition mx-auto">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada data supplier.</td></tr>
            @endforelse
            </tbody>
        </table>
        @if($suppliers->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $suppliers->links() }}</div>
        @endif
    </div>
</div>
@endsection