<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stock(Request $request)
    {
        $query = Product::with(['category', 'supplier']);
        if ($request->category_id) $query->where('category_id', $request->category_id);
        if ($request->status === 'low')   $query->lowStock();
        if ($request->status === 'empty') $query->where('stock', 0);

        $products   = $query->active()->paginate(20);
        $categories = Category::all();
        $summary = [
            'total_products'  => Product::active()->count(),
            'total_low_stock' => Product::lowStock()->count(),
            'total_empty'     => Product::where('stock', 0)->count(),
            'total_value'     => Product::active()->selectRaw('SUM(stock * purchase_price) as val')->value('val') ?? 0,
        ];

        return view('admin.reports.stock', compact('products', 'categories', 'summary'));
    }

    public function transactions(Request $request)
    {
        $query = StockTransaction::with(['product', 'user', 'confirmedByUser']);

        // Filter — gabungan dari transaksi stok + laporan transaksi
        if ($request->type)       $query->where('type', $request->type);
        if ($request->status)     $query->where('status', $request->status);
        if ($request->product_id) $query->where('product_id', $request->product_id);
        if ($request->date_from)  $query->whereDate('date', '>=', $request->date_from);
        if ($request->date_to)    $query->whereDate('date', '<=', $request->date_to);

        $transactions = $query->latest()->paginate(20);
        $products     = Product::active()->get(); // untuk filter dropdown

        $summary = [
            'total_in'      => StockTransaction::in()->confirmed()->sum('quantity'),
            'total_out'     => StockTransaction::out()->confirmed()->sum('quantity'),
            'total_pending' => StockTransaction::pending()->count(),
            'total_rejected' => StockTransaction::where('status', 'rejected')->count(),
        ];

        return view('admin.reports.transactions', compact('transactions', 'products', 'summary'));
    }

    public function activity(Request $request)
    {
        $query = ActivityLog::with('user');
        if ($request->user_id)   $query->where('user_id', $request->user_id);
        if ($request->action)    $query->where('action', $request->action);
        if ($request->module)    $query->where('module', $request->module);
        if ($request->date_from) $query->whereDate('created_at', '>=', $request->date_from);
        if ($request->date_to)   $query->whereDate('created_at', '<=', $request->date_to);

        $logs  = $query->latest()->paginate(25);
        $users = User::all();

        return view('admin.reports.activity', compact('logs', 'users'));
    }
}
