<?php
// app/Http/Controllers/Staff/DashboardController.php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Transaksi pending yang perlu dikonfirmasi staff
        $pendingIn = StockTransaction::with('product')
            ->where('type', 'in')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingOut = StockTransaction::with('product')
            ->where('type', 'out')
            ->where('status', 'pending')
            ->latest()
            ->get();

        // Hitung pending (untuk summary bar di view)
        $pendingInCount  = $pendingIn->count();
        $pendingOutCount = $pendingOut->count();

        // Jumlah yang dikonfirmasi hari ini (siapapun yang konfirmasi)
        // karena staff mengkonfirmasi, bukan membuat transaksi
        $myTodayConfirmed = StockTransaction::where('status', 'confirmed')
            ->whereDate('updated_at', today())
            ->count();

        // Aktivitas terbaru = semua transaksi (bukan filter by user_id)
        // karena staff tugasnya mengkonfirmasi transaksi dari manager
        $myActivity = StockTransaction::with(['product', 'user'])
            ->latest()
            ->limit(8)
            ->get();

        return view('staff.dashboard.index', compact(
            'pendingIn',
            'pendingOut',
            'pendingInCount',   // ← tambahan, dibutuhkan summary bar
            'pendingOutCount',  // ← tambahan, dibutuhkan summary bar
            'myTodayConfirmed',
            'myActivity'
        ));
    }
}
