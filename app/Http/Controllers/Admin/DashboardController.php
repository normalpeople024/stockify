<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stat cards
        $totalProducts      = Product::active()->count();
        $lowStockCount      = Product::lowStock()->count();
        $lowStockProducts   = Product::with('category')->lowStock()->active()->get();
        $todayIn            = StockTransaction::in()->confirmed()->whereDate('date', today())->sum('quantity');
        $todayOut           = StockTransaction::out()->confirmed()->whereDate('date', today())->sum('quantity');
        $totalUsers         = User::count();
        $pendingCount       = StockTransaction::pending()->count();

        // Transaksi terbaru
        $recentTransactions = StockTransaction::with(['product', 'user'])->latest()->limit(8)->get();

        // Grafik stok per kategori
        $stockByCategory = Category::withCount('products')
            ->with(['products' => fn($q) => $q->active()])
            ->get()
            ->map(fn($cat) => [
                'name'  => $cat->name,
                'stock' => $cat->products->sum('stock'),
                'count' => $cat->products->count(),
            ])
            ->filter(fn($c) => $c['count'] > 0)
            ->values();

        // Grafik transaksi 7 hari terakhir
        $transactionChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'date'  => $date->format('d M'),
                'in'    => StockTransaction::in()->confirmed()->whereDate('date', $date)->sum('quantity'),
                'out'   => StockTransaction::out()->confirmed()->whereDate('date', $date)->sum('quantity'),
            ];
        });

        // Transaksi masuk vs keluar bulan ini
        $monthIn  = StockTransaction::in()->confirmed()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('quantity');
        $monthOut = StockTransaction::out()->confirmed()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('quantity');

        // Aktivitas pengguna terbaru
        $recentActivity = ActivityLog::with('user')->latest()->limit(8)->get();

        return view('admin.dashboard.index', compact(
            'totalProducts',
            'lowStockCount',
            'lowStockProducts',
            'todayIn',
            'todayOut',
            'totalUsers',
            'pendingCount',
            'recentTransactions',
            'stockByCategory',
            'transactionChart',
            'monthIn',
            'monthOut',
            'recentActivity'
        ));
    }
}
