<?php
// app/Http/Controllers/Admin/StockController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Services\StockTransactionService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function __construct(private StockTransactionService $service) {}

    public function index(Request $request)
    {
        $query = StockTransaction::with(['product', 'user']);

        if ($request->type)       $query->where('type', $request->type);
        if ($request->status)     $query->where('status', $request->status);
        if ($request->product_id) $query->where('product_id', $request->product_id);
        if ($request->date_from)  $query->whereDate('date', '>=', $request->date_from);
        if ($request->date_to)    $query->whereDate('date', '<=', $request->date_to);

        $transactions = $query->latest()->paginate(15);
        $products     = Product::active()->get();

        return view('admin.stock.index', compact('transactions', 'products'));
    }

    public function history(Request $request)
    {
        $query = StockTransaction::with(['product', 'user'])->confirmed();

        if ($request->type)      $query->where('type', $request->type);
        if ($request->date_from) $query->whereDate('date', '>=', $request->date_from);
        if ($request->date_to)   $query->whereDate('date', '<=', $request->date_to);

        $transactions = $query->latest()->paginate(15);
        return view('admin.stock.history', compact('transactions'));
    }

    public function show(int $id)
    {
        $transaction = StockTransaction::with(['product.category', 'user'])
            ->findOrFail($id);

        // Cari siapa yang mengkonfirmasi/menolak dari activity log
        $confirmedBy = \App\Models\ActivityLog::with('user')
            ->where('module', 'stock')
            ->whereIn('action', ['confirm', 'reject'])
            ->whereJsonContains('properties->transaction_id', $id)
            ->latest()
            ->first();

        return view('admin.stock.show', compact('transaction', 'confirmedBy'));
    }
}
