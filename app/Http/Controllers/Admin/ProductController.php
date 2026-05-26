<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index(Request $request)
    {
        $products   = $this->service->getAll(
            $request->only(['search', 'category_id', 'supplier_id', 'low_stock'])
        );
        $categories = Category::all();
        $suppliers  = Supplier::active()->get();

        return view('admin.products.index', compact('products', 'categories', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::active()->get();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'supplier_id'        => 'nullable|exists:suppliers,id',
            'sku'                => 'nullable|string|unique:products,sku',
            'description'        => 'nullable|string',
            'purchase_price'     => 'required|numeric|min:0',
            'selling_price'      => 'required|numeric|min:0',
            'stock'              => 'required|integer|min:0',
            'minimum_stock'      => 'required|integer|min:0',
            'unit'               => 'required|string|max:20',
            'image_file'         => 'nullable|image|max:2048',
            'attributes'         => 'nullable|array',
            'attributes.*.name'  => 'required_with:attributes|string',
            'attributes.*.value' => 'required_with:attributes|string',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_file'] = $request->file('image_file');
        }

        $this->service->create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $product = $this->service->find($id);
        $product->load('stockTransactions.user');
        return view('admin.products.show', compact('product'));
    }

    public function edit(int $id)
    {
        $product    = $this->service->find($id);
        $categories = Category::all();
        $suppliers  = Supplier::active()->get();
        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'nullable|exists:suppliers,id',
            'sku'            => 'nullable|string|unique:products,sku,' . $id,
            'description'    => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'unit'           => 'required|string|max:20',
            'image_file'     => 'nullable|image|max:2048',
            'attributes'     => 'nullable|array',
            // Tambahkan is_active ke validasi
            'is_active'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_file'] = $request->file('image_file');
        }

        // Pastikan is_active selalu ada, default false jika tidak terkirim
        $validated['is_active'] = $request->boolean('is_active');

        $this->service->update($id, $validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $result = $this->service->delete($id);

        if ($result === false) {
            // Produk punya transaksi, hanya dinonaktifkan
            return redirect()->route('admin.products.index')
                ->with('warning', 'Produk tidak bisa dihapus karena memiliki riwayat transaksi. Produk telah dinonaktifkan.');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
