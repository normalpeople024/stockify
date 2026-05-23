<?php
// app/Http/Controllers/Manager/DashboardController.php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockProducts  = Product::with('category')->lowStock()->active()->get();
        $lowStockCount     = $lowStockProducts->count();
        $todayIn           = StockTransaction::in()->confirmed()->whereDate('date', today())->sum('quantity');
        $todayOut          = StockTransaction::out()->confirmed()->whereDate('date', today())->sum('quantity');
        $pendingCount      = StockTransaction::pending()->count();
        $recentTransactions = StockTransaction::with(['product', 'user'])
            ->latest()->limit(8)->get();

        return view('manager.dashboard.index', compact(
            'lowStockProducts',
            'lowStockCount',
            'todayIn',
            'todayOut',
            'pendingCount',
            'recentTransactions'
        ));
    }
}
