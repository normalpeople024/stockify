{{-- resources/views/admin/reports/activity.blade.php --}}
@extends('layouts.app1')
@section('title', 'Laporan Aktivitas')
@section('page-title', 'Laporan Aktivitas Pengguna')
@section('breadcrumb', 'Admin / Laporan / Aktivitas Pengguna')

@section('content')
<div class="space-y-5">

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1">Pengguna</label>
                <select name="user_id" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Pengguna</option>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}" @selected(request('user_id')==$u->id)>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1">Aksi</label>
                <select name="action" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
                    <option value="">Semua Aksi</option>
                    @foreach(['login','logout','create','update','delete','confirm','reject'] as $act)
                    <option value="{{ $act }}" @selected(request('action')===$act)>{{ ucfirst($act) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none focus:border-green-400">
            </div>
            <div class="flex items-end">
                <button class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">Filter</button>
            </div>
            @if(request()->hasAny(['user_id','action','module','date_from','date_to']))
            <div class="flex items-end">
                <a href="{{ route('admin.reports.activity') }}" class="h-9 px-4 text-sm font-medium border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 flex items-center">Reset</a>
            </div>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
            <h3 class="text-sm font-semibold text-gray-700">Log Aktivitas</h3>
            <span class="text-xs text-gray-400">{{ $logs->total() }} aktivitas</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="px-5 py-3 text-left font-semibold">Pengguna</th>
                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                        <th class="px-5 py-3 text-center font-semibold">Modul</th>
                        <th class="px-5 py-3 text-left font-semibold">Keterangan</th>
                        <th class="px-5 py-3 text-left font-semibold">IP Address</th>
                        <th class="px-5 py-3 text-center font-semibold">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($log->user->name ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-700">{{ $log->user->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-400">{{ $log->user->role_label ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $log->action_color }}">
                            {{ $log->action_label }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-gray-100 text-gray-600">
                            {{ ucfirst($log->module) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-xs text-gray-600 max-w-[200px] truncate">
                        {{ $log->description }}
                    </td>
                    <td class="px-5 py-3.5 font-mono text-xs text-gray-400">{{ $log->ip_address ?? '—' }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <p class="text-xs text-gray-600 whitespace-nowrap">{{ $log->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada aktivitas tercatat.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $logs->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection