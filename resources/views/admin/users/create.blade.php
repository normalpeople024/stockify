{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.app1')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')
@section('breadcrumb', 'Admin / Pengguna / Tambah')

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
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
        @csrf

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Contoh: Budi Santoso"
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('name') border-red-400 @enderror">
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    placeholder="email@perusahaan.com"
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('email') border-red-400 @enderror">
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role" required
                    class="w-full h-10 px-4 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-400 @error('role') border-red-400 @enderror">
                    <option value="">— Pilih Role —</option>
                    <option value="admin"   @selected(old('role')==='admin')>Admin</option>
                    <option value="manager" @selected(old('role')==='manager')>Manajer Gudang</option>
                    <option value="staff"   @selected(old('role')==='staff')>Staff Gudang</option>
                </select>
                @error('role')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

                {{-- Deskripsi role --}}
                <div id="role-desc" class="mt-2 hidden">
                    <div id="desc-admin" class="hidden p-3 bg-purple-50 rounded-xl text-xs text-purple-700">
                        <strong>Admin:</strong> Akses penuh ke seluruh fitur termasuk manajemen pengguna, laporan, dan pengaturan sistem.
                    </div>
                    <div id="desc-manager" class="hidden p-3 bg-blue-50 rounded-xl text-xs text-blue-700">
                        <strong>Manajer Gudang:</strong> Mengelola stok, barang masuk/keluar, dan melihat laporan gudang.
                    </div>
                    <div id="desc-staff" class="hidden p-3 bg-gray-50 rounded-xl text-xs text-gray-600">
                        <strong>Staff Gudang:</strong> Mengkonfirmasi penerimaan dan pengeluaran barang sesuai instruksi manajer.
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
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
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        placeholder="Ulangi password"
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

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="h-10 px-6 text-sm font-semibold text-white rounded-xl transition"
                    style="background:#1D9E75"
                    onmouseover="this.style.background='#0F6E56'"
                    onmouseout="this.style.background='#1D9E75'">
                    Simpan
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
// Toggle password visibility
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

// Tampilkan deskripsi role
document.querySelector('select[name=role]').addEventListener('change', function () {
    const val = this.value;
    document.getElementById('role-desc').classList.toggle('hidden', !val);
    ['admin','manager','staff'].forEach(r => {
        document.getElementById('desc-' + r).classList.toggle('hidden', r !== val);
    });
});

// Trigger jika old value ada
const oldRole = '{{ old("role") }}';
if (oldRole) {
    document.querySelector('select[name=role]').value = oldRole;
    document.querySelector('select[name=role]').dispatchEvent(new Event('change'));
}
</script>
@endpush