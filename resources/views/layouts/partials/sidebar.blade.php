{{-- resources/views/layouts/partials/sidebar-menu.blade.php --}}
@php
$role    = auth()->user()->role;
$current = request()->route()?->getName() ?? '';

function isActive(string $prefix, string $current): bool {
    return str_starts_with($current, $prefix);
}

function navLink(string $href, string $label, string $svgPath, bool $active): string {
    $base  = 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150';
    $cls   = $active
        ? "$base text-white nav-active"
        : "$base text-gray-500 hover:bg-gray-50 hover:text-gray-800";
    $style = $active
        ? 'style="background: linear-gradient(135deg, #1D9E75, #0F6E56); box-shadow: 0 2px 12px rgba(29,158,117,0.35);"'
        : '';
    $icon  = "<svg class=\"w-4 h-4 flex-shrink-0\" fill=\"none\" viewBox=\"0 0 24 24\">
        <path d=\"{$svgPath}\" stroke=\"currentColor\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
    </svg>";
    return "<a href=\"{$href}\" class=\"{$cls}\" {$style} onclick=\"closeSidebar()\">{$icon}<span>{$label}</span></a>";
}
@endphp


@if($role === 'admin')

{!! navLink(route('admin.dashboard'), 'Dashboard',
'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
isActive('admin.dashboard', $current)) !!}

<p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-3 pt-5 pb-1.5">Katalog</p>

{!! navLink(route('admin.products.index'), 'Produk',
'M20 7l-8-4-8 4m16 0v10l-8 4m-8-4V7m8 4l8-4M4 7l8 4',
isActive('admin.products', $current)) !!}

{!! navLink(route('admin.categories.index'), 'Kategori',
'M4 6h16M4 10h16M4 14h10M4 18h6',
isActive('admin.categories', $current)) !!}

{!! navLink(route('admin.suppliers.index'), 'Supplier',
'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75',
isActive('admin.suppliers', $current)) !!}

<p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-3 pt-5 pb-1.5">Stok</p>

{!! navLink(route('admin.stock.history'), 'Riwayat Stok',
'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
$current === 'admin.stock.history') !!}

{!! navLink(route('admin.stock.opname'), 'Stock Opname',
'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
$current === 'admin.stock.opname') !!}

<p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-3 pt-5 pb-1.5">Laporan</p>

{!! navLink(route('admin.reports.stock'), 'Laporan Stok',
'M9 17v-2m3 2v-4m3 4v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z',
$current === 'admin.reports.stock') !!}

{!! navLink(route('admin.reports.transactions'), 'Laporan Transaksi',
'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
$current === 'admin.reports.transactions') !!}

{!! navLink(route('admin.reports.activity'), 'Aktivitas Pengguna',
'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
$current === 'admin.reports.activity') !!}

<p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-3 pt-5 pb-1.5">Sistem</p>

{!! navLink(route('admin.users.index'), 'Pengguna',
'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
isActive('admin.users', $current)) !!}

{!! navLink(route('admin.settings.index'), 'Pengaturan',
'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
$current === 'admin.settings.index') !!}

@elseif($role === 'manager')
// ... tetap sama seperti sebelumnya

@elseif($role === 'manager')

{!! navLink(route('manager.dashboard'), 'Dashboard',
'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
isActive('manager.dashboard', $current)) !!}

<p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-3 pt-5 pb-1.5">Stok</p>

{!! navLink(route('manager.stock.create-in'), 'Barang Masuk',
'M5 10l7-7m0 0l7 7m-7-7v18',
$current === 'manager.stock.create-in') !!}

{!! navLink(route('manager.stock.create-out'), 'Barang Keluar',
'M19 14l-7 7m0 0l-7-7m7 7V3',
$current === 'manager.stock.create-out') !!}

{!! navLink(route('manager.stock.opname'), 'Stock Opname',
'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
$current === 'manager.stock.opname') !!}

<p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-3 pt-5 pb-1.5">Data</p>

{!! navLink(route('manager.products.index'), 'Produk',
'M20 7l-8-4-8 4m16 0v10l-8 4m-8-4V7m8 4l8-4M4 7l8 4',
isActive('manager.products', $current)) !!}

{!! navLink(route('manager.suppliers.index'), 'Supplier',
'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75',
isActive('manager.suppliers', $current)) !!}

<p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-3 pt-5 pb-1.5">Laporan</p>

{!! navLink(route('manager.reports.stock'), 'Laporan stok',
'M9 17v-2m3 2v-4m3 4v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z',
$current === 'manager.reports.stock') !!}

{!! navLink(route('manager.reports.transactions'), 'Laporan transaksi',
'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
isActive('manager.reports.transactions', $current)) !!}

@elseif($role === 'staff')

{!! navLink(route('staff.dashboard'), 'Dashboard',
'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
isActive('staff.dashboard', $current)) !!}

<p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest px-3 pt-5 pb-1.5">Tugas</p>

{!! navLink(route('staff.stock.index'), 'Konfirmasi Stok',
'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
isActive('staff.stock', $current)) !!}

@endif