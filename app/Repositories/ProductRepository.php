<?php
// app/Repositories/ProductRepository.php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = Product::with(['category', 'supplier']);

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (!empty($filters['supplier_id'])) {
            $query->where('supplier_id', $filters['supplier_id']);
        }
        if (!empty($filters['low_stock'])) {
            $query->lowStock();
        }

        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }

    public function find(int $id): Product
    {
        return Product::with(['category', 'supplier', 'attributes'])->findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->find($id);
        $product->update($data);
        return $product->fresh();
    }

    public function delete(int $id): bool
    {
        return Product::findOrFail($id)->delete();
    }

    public function getLowStock(): Collection
    {
        return Product::with('category')->lowStock()->active()->get();
    }

    public function totalProducts(): int
    {
        return Product::active()->count();
    }

    public function totalStockValue(): float
    {
        return (float) Product::active()
            ->sum(DB::raw('stock * purchase_price'));
    }
}
