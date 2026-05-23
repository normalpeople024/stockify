<?php
// app/Http/Controllers/Admin/StockOpnameController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier'])->active();

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->search) {
            $query->search($request->search);
        }

        $products   = $query->paginate(20);
        $categories = \App\Models\Category::all();

        // Riwayat opname sebelumnya
        $history = StockTransaction::with(['product', 'user'])
            ->where('type', 'opname')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.stock.opname', compact('products', 'categories', 'history'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.actual_stock' => 'required|integer|min:0',
            'notes'              => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $actual  = (int) $item['actual_stock'];

                // Hanya catat jika ada selisih
                if ($product->stock === $actual) continue;

                $diff = $actual - $product->stock;

                StockTransaction::create([
                    'product_id'   => $product->id,
                    'user_id'      => Auth::id(),
                    'type'         => 'opname',
                    'quantity'     => abs($diff),
                    'stock_before' => $product->stock,
                    'stock_after'  => $actual,
                    'date'         => today(),
                    'status'       => 'confirmed', // opname langsung confirmed
                    'notes'        => $request->notes ?? 'Stock Opname',
                    'reference_no' => 'OPN-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                ]);

                // Update stok langsung
                $product->update(['stock' => $actual]);
            }
        });

        return redirect()->route('admin.stock.opname')
            ->with('success', 'Stock opname berhasil disimpan. Stok produk telah diperbarui.');
    }
}
