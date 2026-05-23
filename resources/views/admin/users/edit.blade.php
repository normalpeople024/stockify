{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app1')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')
@section('breadcrumb', 'Admin / Pengguna / Edit')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Kembali ke Daftar Pengguna
            </a>
        </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
        @csrf @method('PUT')

            {{-- Avatar inisial --}}
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-700">{{ $user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('name') border-red-400 @enderror">
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('email') border-red-400 @enderror">
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role" required
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                    <option value="admin"   @selected(old('role', $user->role)==='admin')>Admin</option>
                    <option value="manager" @selected(old('role', $user->role)==='manager')>Manajer Gudang</option>
                    <option value="staff"   @selected(old('role', $user->role)==='staff')>Staff Gudang</option>
                </select>
                @if($user->id === auth()->id())
                <p class="text-xs text-amber-600 mt-1.5 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 16 16"><path d="M8 6v4M8 11.5v.5M6.29 2.57L1.14 11a2 2 0 001.71 3h10.3a2 2 0 001.71-3L9.71 2.57a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                    Anda sedang mengedit akun sendiri
                </p>
                @endif
            </div>

            {{-- Password baru (opsional) --}}
            <div class="border border-dashed border-gray-200 rounded-xl p-4 space-y-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Ganti Password
                    <span class="font-normal text-gray-400 normal-case">(kosongkan jika tidak ingin diubah)</span>
                </p>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            placeholder="Minimal 6 karakter"
                            class="w-full h-10 px-4 pr-10 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('password') border-red-400 @enderror">
                        <button type="button" onclick="togglePass('password','eye1')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye1" class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                                <ellipse cx="10" cy="10" rx="8" ry="5" stroke="currentColor" stroke-width="1.25"/>
                                <circle cx="10" cy="10" r="2" stroke="currentColor" stroke-width="1.25"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Ulangi password baru"
                            class="w-full h-10 px-4 pr-10 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400">
                        <button type="button" onclick="togglePass('password_confirmation','eye2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye2" class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                                <ellipse cx="10" cy="10" rx="8" ry="5" stroke="currentColor" stroke-width="1.25"/>
                                <circle cx="10" cy="10" r="2" stroke="currentColor" stroke-width="1.25"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Status aktif --}}
            @if($user->id !== auth()->id())
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    @checked(old('is_active', $user->is_active))
                    class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer">
                    Pengguna Aktif
                </label>
            </div>
            @endif

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="h-10 px-6 text-sm font-semibold text-white rounded-xl transition"
                    style="background:#1D9E75"
                    onmouseover="this.style.background='#0F6E56'"
                    onmouseout="this.style.background='#1D9E75'">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="h-10 px-6 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path d="M3 3l14 14M8.5 7.5A3.5 3.5 0 0114 13M5.5 5.5C4 7 3 8.5 3 10s3 6 7 6 5.5-2 7-4" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<ellipse cx="10" cy="10" rx="8" ry="5" stroke="currentColor" stroke-width="1.25"/><circle cx="10" cy="10" r="2" stroke="currentColor" stroke-width="1.25"/>`;
    }
}
</script>
@endpush