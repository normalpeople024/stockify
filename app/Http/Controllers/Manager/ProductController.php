<?php
// app/Http/Controllers/Manager/ProductController.php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index(Request $request)
    {
        $products   = $this->service->getAll(
            $request->only(['search', 'category_id', 'low_stock'])
        );
        $categories = Category::all();

        return view('manager.products.index', compact('products', 'categories'));
    }

    public function show(int $id)
    {
        $product = $this->service->find($id);
        $product->load('stockTransactions.user');

        return view('manager.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::active()->get();

        return view('manager.products.create', compact('categories', 'suppliers'));
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
            'image_file'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'attributes'         => 'nullable|array',
            'attributes.*.name'  => 'required_with:attributes|string',
            'attributes.*.value' => 'required_with:attributes|string',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_file'] = $request->file('image_file');
        }

        $this->service->create($validated);

        return redirect()->route('manager.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
}
