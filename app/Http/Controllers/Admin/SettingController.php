<?php
// app/Http/Controllers/Admin/SettingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = AppSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name'        => 'required|string|max:100',
            'app_description' => 'nullable|string|max:255',
            'company_name'    => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
            'company_phone'   => 'nullable|string|max:20',
            'company_email'   => 'nullable|email',
            'currency'        => 'nullable|string|max:10',
            'logo_file'       => 'nullable|image|mimes:png,jpg,webp|max:1024',
            'favicon_file'    => 'nullable|image|mimes:png,ico|max:256',
            'low_stock_alert' => 'boolean',
        ]);

        // Simpan logo
        if ($request->hasFile('logo_file')) {
            $old = AppSetting::get('app_logo');
            if ($old) Storage::disk('public')->delete($old);
            AppSetting::set('app_logo', $request->file('logo_file')->store('settings', 'public'));
        }

        // Simpan favicon
        if ($request->hasFile('favicon_file')) {
            $old = AppSetting::get('app_favicon');
            if ($old) Storage::disk('public')->delete($old);
            AppSetting::set('app_favicon', $request->file('favicon_file')->store('settings', 'public'));
        }

        // Simpan semua setting teks
        $keys = ['app_name', 'app_description', 'company_name', 'company_address', 'company_phone', 'company_email', 'currency'];
        foreach ($keys as $key) {
            AppSetting::set($key, $request->input($key, ''));
        }

        AppSetting::set('low_stock_alert', $request->boolean('low_stock_alert') ? '1' : '0');

        // Bersihkan semua cache setting
        Cache::flush();

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function deleteLogo()
    {
        $logo = AppSetting::get('app_logo');
        if ($logo) Storage::disk('public')->delete($logo);
        AppSetting::set('app_logo', null);
        Cache::flush();
        return back()->with('success', 'Logo berhasil dihapus.');
    }
}
