{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app1')
@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('breadcrumb', 'Admin / Pengguna')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <form method="GET" class="flex gap-2">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.5" />
                    <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                    class="pl-9 pr-4 h-9 text-sm border border-gray-200 rounded-xl bg-white w-64 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
            </div>
            <select name="role" class="h-9 text-sm border border-gray-200 rounded-xl px-3 bg-white focus:outline-none">
                <option value="">Semua Role</option>
                <option value="admin" @selected(request('role')==='admin' )>Admin</option>
                <option value="manager" @selected(request('role')==='manager' )>Manajer Gudang</option>
                <option value="staff" @selected(request('role')==='staff' )>Staff Gudang</option>
            </select>
            <button class="h-9 px-4 text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl">Filter</button>
        </form>
        <a href="{{ route('admin.users.create') }}"
            class="flex items-center gap-2 h-9 px-4 text-sm font-semibold text-white rounded-xl transition"
            style="background:#1D9E75" onmouseover="this.style.background='#0F6E56'" onmouseout="this.style.background='#1D9E75'">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14" stroke="white" stroke-width="2" stroke-linecap="round" />
            </svg>
            Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-400 uppercase border-b border-gray-100">
                    <th class="px-6 py-3.5 text-left font-semibold">Pengguna</th>
                    <th class="px-6 py-3.5 text-left font-semibold">Email</th>
                    <th class="px-6 py-3.5 text-center font-semibold">Role</th>
                    <th class="px-6 py-3.5 text-center font-semibold">Status</th>
                    <th class="px-6 py-3.5 text-left font-semibold">Dibuat</th>
                    <th class="px-6 py-3.5 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-sm">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-center">
                        @php
                        $rc = ['admin'=>'bg-purple-50 text-purple-700','manager'=>'bg-blue-50 text-blue-700','staff'=>'bg-gray-100 text-gray-600'];
                        @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $rc[$user->role] ?? '' }}">
                            {{ $user->role_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($user->is_active)
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">Tidak ada pengguna ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection