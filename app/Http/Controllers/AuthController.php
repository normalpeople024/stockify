<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AppSetting;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route($this->dashboardRoute());
        }

        $settings = AppSetting::getMany([
            'app_name',
            'app_description',
            'app_logo',
            'company_name',
            'company_address',
            'company_phone',
            'company_email',
        ]);

        return view('auth.login', compact('settings'));
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();
        }

        $request->session()->regenerate();

        $user = Auth::user();
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun Anda tidak aktif. Hubungi administrator.']);
        }

        return redirect()->intended(route($this->dashboardRoute()));
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            \App\Services\ActivityLogService::log(
                action: 'logout',
                module: 'auth',
                description: 'Pengguna keluar dari sistem',
                properties: [
                    'user_id'    => $user->id,
                    'user_name'  => $user->name,
                    'email'      => $user->email,
                    'ip_address' => $request->ip(),
                ]
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function dashboardRoute(): string
    {
        return match (Auth::user()?->role) {
            'admin'   => 'admin.dashboard',
            'manager' => 'manager.dashboard',
            'staff'   => 'staff.dashboard',
            default   => 'login',
        };
    }
}
