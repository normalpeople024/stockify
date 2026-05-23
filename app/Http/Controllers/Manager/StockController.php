<?php
// app/Http/Controllers/Manager/StockController.php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Services\StockTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function __construct(private StockTransactionService $service) {}

    public function index(Request $request)
    {
        $transactions = $this->service->getAll(
            $request->only(['type', 'status', 'product_id', 'date_from', 'date_to'])
        );
        $products = Product::active()->get();
        return view('manager.stock.index', compact('transactions', 'products'));
    }

    public function createIn()
    {
        $products = Product::with('category')->active()->get();
        return view('manager.stock.create-in', compact('products'));
    }

    public function storeIn(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|min:1',
            'date'         => 'required|date',
            'notes'        => 'nullable|string',
            'reference_no' => 'nullable|string|unique:stock_transactions,reference_no',
        ]);

        $this->service->createIn($validated);

        return redirect()->route('manager.stock.index')
            ->with('success', 'Barang masuk berhasil dicatat. Menunggu konfirmasi staff.');
    }

    public function createOut()
    {
        $products = Product::with('category')->active()->where('stock', '>', 0)->get();
        return view('manager.stock.create-out', compact('products'));
    }

    public function storeOut(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|min:1',
            'date'         => 'required|date',
            'notes'        => 'nullable|string',
            'reference_no' => 'nullable|string|unique:stock_transactions,reference_no',
        ]);

        try {
            $this->service->createOut($validated);
            return redirect()->route('manager.stock.index')
                ->with('success', 'Barang keluar berhasil dicatat. Menunggu konfirmasi staff.');
        } catch (\Exception $e) {
            return back()->withErrors(['quantity' => $e->getMessage()])->withInput();
        }
    }

    // ── Stock Opname ──────────────────────────────────
    public function opname(Request $request)
    {
        $query = Product::with(['category'])->active();

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->search) {
            $query->search($request->search);
        }

        $products   = $query->paginate(20);
        $categories = Category::all();

        $history = StockTransaction::with(['product', 'user'])
            ->where('type', 'opname')
            ->latest()
            ->limit(10)
            ->get();

        return view('manager.stock.opname', compact('products', 'categories', 'history'));
    }

    public function storeOpname(Request $request)
    {
        $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'required|exists:products,id',
            'items.*.actual_stock' => 'required|integer|min:0',
            'notes'               => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $actual  = (int) $item['actual_stock'];

                // Hanya proses jika ada selisih
                if ($product->stock === $actual) continue;

                StockTransaction::create([
                    'product_id'   => $product->id,
                    'user_id'      => Auth::id(),
                    'type'         => 'opname',
                    'quantity'     => abs($actual - $product->stock),
                    'stock_before' => $product->stock,
                    'stock_after'  => $actual,
                    'date'         => today(),
                    'status'       => 'confirmed', // opname langsung confirmed
                    'notes'        => $request->notes ?? 'Stock Opname oleh Manager',
                    'reference_no' => 'OPN-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                ]);

                // Update stok langsung
                $product->update(['stock' => $actual]);
            }
        });

        return redirect()->route('manager.stock.index')
            ->with('success', 'Stock opname berhasil disimpan. Stok produk telah diperbarui.');
    }

    public function show(int $id)
    {
        $transaction = $this->service->find($id);
        return view('manager.stock.show', compact('transaction'));
    }
}
