{{-- resources/views/staff/stock/show.blade.php --}}
@extends('layouts.app1')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('breadcrumb', 'Staff Gudang / Konfirmasi Stok / Detail')

@section('content')
<div class="max-w-2xl space-y-5">

    <a href="{{ route('staff.stock.index') }}"
       class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
            <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali ke Daftar Konfirmasi
    </a>

    {{-- Card Detail --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

        {{-- Header Card --}}
        <div class="px-6 py-5 border-b border-gray-50
            {{ $transaction->type === 'in' ? 'bg-green-50' : 'bg-red-50' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                        {{ $transaction->type === 'in' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        @if($transaction->type === 'in')
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold {{ $transaction->type === 'in' ? 'text-green-600' : 'text-red-600' }} uppercase tracking-wide">
                            {{ $transaction->type === 'in' ? 'Barang Masuk' : 'Barang Keluar' }}
                        </p>
                        <p class="font-mono font-semibold text-gray-800">{{ $transaction->reference_no ?? 'Tanpa Referensi' }}</p>
                    </div>
                </div>
                <span class="text-sm font-semibold px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                    Menunggu Konfirmasi
                </span>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-6 space-y-5">

            {{-- Info Produk --}}
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                <div class="w-12 h-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if($transaction->product?->image)
                        <img src="{{ asset('storage/'.$transaction->product->image) }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/><path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $transaction->product->name ?? '—' }}</p>
                    <p class="text-xs font-mono text-gray-400">{{ $transaction->product->sku ?? '' }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $transaction->product->category->name ?? '' }}</p>
                </div>
            </div>

            {{-- Grid Detail --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jumlah</p>
                    <p class="text-2xl font-bold {{ $transaction->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction->type === 'in' ? '+' : '-' }}{{ number_format($transaction->quantity) }}
                        <span class="text-sm font-normal text-gray-500">{{ $transaction->product->unit ?? '' }}</span>
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Stok Saat Ini</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($transaction->stock_before) }}
                        <span class="text-sm font-normal text-gray-500">{{ $transaction->product->unit ?? '' }}</span>
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Stok Setelah Konfirmasi</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ number_format($transaction->stock_after) }}
                        <span class="text-sm font-normal text-gray-500">{{ $transaction->product->unit ?? '' }}</span>
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                    <p class="text-base font-semibold text-gray-800">{{ $transaction->date->format('d M Y') }}</p>
                </div>
            </div>

            {{-- Dicatat oleh --}}
            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Dicatat Oleh</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $transaction->user->name ?? '—' }}</p>
                    <p class="text-xs text-gray-400">{{ $transaction->user->role_label ?? '' }}</p>
                </div>
                <div class="ml-auto text-right">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Dibuat Pada</p>
                    <p class="text-xs text-gray-600">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            @if($transaction->notes)
            <div class="p-4 bg-blue-50 rounded-xl">
                <p class="text-xs font-semibold text-blue-400 uppercase tracking-wider mb-1.5">Catatan</p>
                <p class="text-sm text-blue-700 leading-relaxed">{{ $transaction->notes }}</p>
            </div>
            @endif

            {{-- Peringatan stok jika keluar --}}
            @if($transaction->type === 'out' && $transaction->stock_before < $transaction->quantity)
            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-xs font-semibold text-red-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Peringatan: Stok Tidak Mencukupi
                </p>
                <p class="text-xs text-red-500 mt-1">
                    Stok tersedia {{ $transaction->stock_before }} {{ $transaction->product->unit ?? '' }},
                    dibutuhkan {{ $transaction->quantity }} {{ $transaction->product->unit ?? '' }}.
                    Konfirmasi akan gagal.
                </p>
            </div>
            @endif
        </div>

        {{-- Footer Aksi --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center gap-3">
            <p class="text-xs text-gray-500 flex-1">
                Periksa kondisi fisik barang sebelum mengkonfirmasi transaksi ini.
            </p>
            <form method="POST" action="{{ route('staff.stock.confirm', $transaction->id) }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 h-9 px-5 text-sm font-semibold text-white rounded-xl transition"
                    style="background:#1D9E75"
                    onmouseover="this.style.background='#0F6E56'"
                    onmouseout="this.style.background='#1D9E75'">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Konfirmasi
                </button>
            </form>
            <button type="button" onclick="document.getElementById('reject-modal').classList.remove('hidden')"
                class="flex items-center gap-2 h-9 px-5 text-sm font-semibold text-red-600 border border-red-200 rounded-xl hover:bg-red-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Tolak
            </button>
        </div>
    </div>

</div>

{{-- Modal Tolak --}}
<div id="reject-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.4)">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-1">Tolak Transaksi</h3>
        <p class="text-sm text-gray-500 mb-4">Berikan alasan penolakan (opsional)</p>

        <form method="POST" action="{{ route('staff.stock.reject', $transaction->id) }}">
            @csrf
            <textarea name="reason" rows="3"
                placeholder="Contoh: Kondisi barang rusak, jumlah tidak sesuai, dll."
                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 resize-none mb-4"></textarea>
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 h-10 text-sm font-semibold text-white rounded-xl bg-red-600 hover:bg-red-700 transition">
                    Tolak Transaksi
                </button>
                <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')"
                    class="flex-1 h-10 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection