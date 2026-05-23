{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')
@section('breadcrumb', 'Beranda')

@section('content')
<div class="space-y-6">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        @php
        $stats = [
            ['label'=>'Total Produk',    'value'=>$totalProducts,  'sub'=>'produk aktif',     'color'=>'blue',  'icon'=>'M20 7l-8-4-8 4m16 0v10l-8 4m-8-4V7m8 4l8-4M4 7l8 4'],
            ['label'=>'Stok Menipis',    'value'=>$lowStockCount,  'sub'=>'perlu restok',     'color'=>'amber', 'icon'=>'M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z'],
            ['label'=>'Masuk Hari Ini',  'value'=>$todayIn,        'sub'=>'unit dikonfirmasi','color'=>'green', 'icon'=>'M5 10l7-7m0 0l7 7m-7-7v18'],
            ['label'=>'Keluar Hari Ini', 'value'=>$todayOut,       'sub'=>'unit dikirim',     'color'=>'red',   'icon'=>'M19 14l-7 7m0 0l-7-7m7 7V3'],
        ];
        $cmap = ['blue'=>'bg-blue-50 text-blue-600','amber'=>'bg-amber-50 text-amber-600','green'=>'bg-green-50 text-green-600','red'=>'bg-red-50 text-red-600'];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-xl {{ $cmap[$s['color']] }} flex items-center justify-center mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="{{ $s['icon'] }}" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($s['value']) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ $s['label'] }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $s['sub'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Info bar: bulan ini + pending --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Masuk Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($monthIn) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Keluar Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($monthOut) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Menunggu Konfirmasi</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($pendingCount) }}</p>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- Grafik Transaksi 7 Hari --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-sm font-semibold text-gray-700">Transaksi 7 Hari Terakhir</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Barang masuk vs keluar (sudah dikonfirmasi)</p>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-500"></span>Masuk</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-400"></span>Keluar</span>
                </div>
            </div>
            <div class="relative" style="height:200px">
                <canvas id="transactionChart"></canvas>
            </div>
        </div>

        {{-- Grafik Stok per Kategori --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-5">Stok per Kategori</h3>
            <div class="relative" style="height:200px">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        {{-- Transaksi Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">Transaksi Terbaru</h3>
                <a href="{{ route('admin.reports.transactions') }}" class="text-xs font-medium text-green-600 hover:text-green-700">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                            <th class="px-5 py-3 text-left font-semibold">Produk</th>
                            <th class="px-5 py-3 text-center font-semibold">Tipe</th>
                            <th class="px-5 py-3 text-right font-semibold">Qty</th>
                            <th class="px-5 py-3 text-center font-semibold">Status</th>
                            <th class="px-5 py-3 text-center font-semibold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-5 py-3 font-medium text-gray-700 max-w-[160px] truncate">{{ $trx->product->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-center">
                            @if($trx->type==='in')
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-50 text-green-700">↓ Masuk</span>
                            @elseif($trx->type==='out')
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-red-50 text-red-700">↑ Keluar</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-50 text-blue-700">Opname</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right font-bold text-gray-700">{{ $trx->quantity }}</td>
                        <td class="px-5 py-3 text-center">
                            @php $sc=['pending'=>'bg-amber-50 text-amber-700','confirmed'=>'bg-green-50 text-green-700','rejected'=>'bg-red-50 text-red-600']; $sl=['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','rejected'=>'Ditolak']; @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $sc[$trx->status]??'' }}">{{ $sl[$trx->status]??'-' }}</span>
                        </td>
                        <td class="px-5 py-3 text-center text-xs text-gray-500">{{ $trx->date->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada transaksi</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Aktivitas Pengguna Terbaru --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">Aktivitas Pengguna</h3>
                <a href="{{ route('admin.reports.activity') }}" class="text-xs font-medium text-green-600 hover:text-green-700">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                @forelse($recentActivity as $log)
                <div class="flex items-start gap-3 px-5 py-3 hover:bg-gray-50/50 transition">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">
                        {{ strtoupper(substr($log->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-xs font-semibold text-gray-700">{{ $log->user->name ?? 'Unknown' }}</p>
                            <span class="text-xs font-semibold px-1.5 py-0.5 rounded-md {{ $log->action_color }}">
                                {{ $log->action_label }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $log->description }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="px-5 py-8 text-center text-gray-400 text-sm">Belum ada aktivitas</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Stok Menipis --}}
    @if($lowStockProducts->count() > 0)
    <div class="bg-white rounded-2xl border border-amber-100 overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-amber-50 bg-amber-50">
            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24"><path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            <h3 class="text-sm font-semibold text-amber-700">Produk Stok Menipis ({{ $lowStockProducts->count() }} produk)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="px-5 py-3 text-left font-semibold">Produk</th>
                        <th class="px-5 py-3 text-left font-semibold">Kategori</th>
                        <th class="px-5 py-3 text-center font-semibold">Stok</th>
                        <th class="px-5 py-3 text-center font-semibold">Minimum</th>
                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @foreach($lowStockProducts as $p)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-3 font-semibold text-gray-800">{{ $p->name }}</td>
                    <td class="px-5 py-3 text-xs text-gray-500">{{ $p->category->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-center font-bold text-red-600">{{ $p->stock }}</td>
                    <td class="px-5 py-3 text-center text-gray-500">{{ $p->minimum_stock }}</td>
                    <td class="px-5 py-3 text-center">
                        <a href="{{ route('admin.products.show', $p) }}"
                           class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                            Detail
                        </a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
// ── Grafik Transaksi 7 Hari ──────────────────
const txData = @json($transactionChart);
new Chart(document.getElementById('transactionChart'), {
    type: 'bar',
    data: {
        labels: txData.map(d => d.date),
        datasets: [
            {
                label: 'Masuk',
                data: txData.map(d => d.in),
                backgroundColor: 'rgba(34,197,94,0.7)',
                borderRadius: 6,
                borderSkipped: false,
            },
            {
                label: 'Keluar',
                data: txData.map(d => d.out),
                backgroundColor: 'rgba(248,113,113,0.7)',
                borderRadius: 6,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 } } },
            y: {
                grid: { color: 'rgba(0,0,0,0.04)' },
                ticks: { font: { size: 11 }, stepSize: 1 },
                beginAtZero: true,
            }
        }
    }
});

// ── Grafik Stok per Kategori ─────────────────
const catData = @json($stockByCategory);
const colors  = ['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6','#06B6D4','#F97316','#EC4899'];
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: catData.map(c => c.name),
        datasets: [{
            data: catData.map(c => c.stock),
            backgroundColor: colors.slice(0, catData.length),
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { font: { size: 11 }, padding: 12, usePointStyle: true }
            }
        },
        cutout: '65%',
    }
});
</script>
@endpush