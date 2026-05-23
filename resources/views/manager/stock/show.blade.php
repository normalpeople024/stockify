{{-- resources/views/manager/stock/show.blade.php --}}
@extends('layouts.app1')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('breadcrumb', 'Manajer Gudang / Stok / Detail')

@section('content')
    <div class="max-w-2xl space-y-5">

        <a href="{{ route('manager.reports.transactions') }}"
            class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            Kembali ke Laporan Transaksi
        </a>

        <div class="bg-white rounded-2xl border border-gray-100 p-6">

            {{-- Status Badge --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">No. Referensi</p>
                    <p class="font-mono font-semibold text-gray-700 text-lg">{{ $transaction->reference_no ?? '—' }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @if ($transaction->type === 'in')
                        <span
                            class="inline-flex items-center gap-1.5 text-sm font-semibold px-3 py-1.5 rounded-full bg-green-50 text-green-700 border border-green-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Barang Masuk
                        </span>
                    @elseif($transaction->type === 'out')
                        <span
                            class="inline-flex items-center gap-1.5 text-sm font-semibold px-3 py-1.5 rounded-full bg-red-50 text-red-700 border border-red-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Barang Keluar
                        </span>
                    @else
                        <span
                            class="text-sm font-semibold px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">Stock
                            Opname</span>
                    @endif

                    @php
                        $sc = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'confirmed' => 'bg-green-50 text-green-700 border-green-200',
                            'rejected' => 'bg-red-50 text-red-600 border-red-200',
                        ];
                        $sl = ['pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'rejected' => 'Ditolak'];
                    @endphp
                    <span
                        class="text-sm font-semibold px-3 py-1.5 rounded-full border {{ $sc[$transaction->status] ?? '' }}">
                        {{ $sl[$transaction->status] ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- Detail Grid --}}
            <div class="grid grid-cols-2 gap-5 pb-5 border-b border-gray-50">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Produk</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $transaction->product->name ?? '—' }}</p>
                    <p class="text-xs font-mono text-gray-400">{{ $transaction->product->sku ?? '' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Jumlah</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($transaction->quantity) }}
                        <span class="text-sm font-normal text-gray-500">{{ $transaction->product->unit ?? '' }}</span>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Stok Sebelum</p>
                    <p class="text-sm font-semibold text-gray-700">{{ number_format($transaction->stock_before) }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Stok Sesudah</p>
                    <p class="text-sm font-semibold text-gray-700">{{ number_format($transaction->stock_after) }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Tanggal</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $transaction->date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Dicatat Oleh</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $transaction->user->name ?? '—' }}</p>
                    <p class="text-xs text-gray-400">{{ $transaction->user->role_label ?? '' }}</p>
                </div>
                @if ($transaction->notes)
                    <div class="col-span-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Catatan</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $transaction->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Ganti bagian footer aksi di manager/stock/show.blade.php --}}
            {{-- Tambahkan setelah grid detail, sebelum penutup </div> card --}}

            {{-- Riwayat Proses --}}
            <div class="border border-gray-100 rounded-xl overflow-hidden">
                <div class="px-4 py-2 bg-gray-50 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Riwayat Proses</p>
                </div>

                {{-- Yang mencatat --}}
                <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-50">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-sm font-semibold text-gray-700">{{ $transaction->user->name ?? '—' }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 font-medium">
                                {{ $transaction->user->role_label ?? '' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">Mencatat transaksi</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $transaction->created_at->format('H:i') }}</p>
                    </div>
                </div>

                {{-- Yang konfirmasi/tolak --}}
                @if ($transaction->status !== 'pending' && $transaction->confirmedByUser)
                    <div class="flex items-center gap-3 px-4 py-3">
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0
            {{ $transaction->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ strtoupper(substr($transaction->confirmedByUser->name ?? 'U', 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="text-sm font-semibold text-gray-700">
                                    {{ $transaction->confirmedByUser->name ?? '—' }}
                                </p>
                                <span
                                    class="text-xs px-2 py-0.5 rounded-full font-medium
                    {{ $transaction->status === 'confirmed' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $transaction->confirmedByUser->role_label ?? '' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $transaction->status === 'confirmed' ? '✓ Mengkonfirmasi transaksi' : '✕ Menolak transaksi' }}
                            </p>
                        </div>
                        @if ($transaction->confirmed_at)
                            <div class="text-right flex-shrink-0">
                                <p class="text-xs text-gray-500">{{ $transaction->confirmed_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $transaction->confirmed_at->format('H:i') }}</p>
                            </div>
                        @endif
                    </div>
                @elseif($transaction->status === 'pending')
                    <div class="flex items-center gap-3 px-4 py-3">
                        <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-amber-700">Menunggu Konfirmasi Staff</p>
                            <p class="text-xs text-gray-400">Belum ada staff yang memproses transaksi ini</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Info status --}}
            @if ($transaction->status === 'pending')
                <div class="flex items-center gap-3 p-4 bg-amber-50 rounded-xl">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                    <p class="text-sm text-amber-700">
                        Transaksi sedang <strong>menunggu konfirmasi</strong> dari Staff Gudang.
                        Stok belum berubah.
                    </p>
                </div>
            @elseif($transaction->status === 'confirmed')
                <div class="flex items-center gap-3 p-4 bg-green-50 rounded-xl">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                    <p class="text-sm text-green-700">
                        Transaksi telah <strong>dikonfirmasi</strong>. Stok sudah diperbarui.
                    </p>
                </div>
            @elseif($transaction->status === 'rejected')
                <div class="flex items-center gap-3 p-4 bg-red-50 rounded-xl">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                        <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    <p class="text-sm text-red-700">
                        Transaksi <strong>ditolak</strong>.
                        @if ($transaction->notes)
                            Alasan: <em>{{ $transaction->notes }}</em>
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
