<?php
// app/Http/Controllers/Staff/StockController.php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Services\StockTransactionService;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function __construct(private StockTransactionService $service) {}

    public function index(Request $request)
    {
        $query = StockTransaction::with(['product', 'user'])
            ->where('status', 'pending');

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(15);

        // Hitung ringkasan
        $pendingInCount  = StockTransaction::where('type', 'in')->where('status', 'pending')->count();
        $pendingOutCount = StockTransaction::where('type', 'out')->where('status', 'pending')->count();

        return view('staff.stock.index', compact(
            'transactions',
            'pendingInCount',
            'pendingOutCount'
        ));
    }

    public function show(int $id)
    {
        $transaction = $this->service->find($id);
        return view('staff.stock.show', compact('transaction'));
    }

    public function confirm(int $id)
    {
        try {
            $this->service->confirm($id);
            return back()->with('success', 'Transaksi berhasil dikonfirmasi. Stok telah diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request, int $id)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);

        try {
            $this->service->reject($id, $request->reason ?? '');
            return back()->with('success', 'Transaksi berhasil ditolak.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
