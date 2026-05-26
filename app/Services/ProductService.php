<?php
// app/Services/ProductService.php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function __construct(private ProductRepository $repo) {}

    public function getAll(array $filters = [])
    {
        return $this->repo->all($filters);
    }

    public function find(int $id): Product
    {
        return $this->repo->find($id);
    }

    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $data['sku'] = $data['sku'] ?? Product::generateSku();

            if (isset($data['image_file'])) {
                $data['image'] = $data['image_file']->store('products', 'public');
                unset($data['image_file']);
            }

            $attributes = $data['attributes'] ?? [];
            unset($data['attributes']);

            $product = $this->repo->create($data);

            foreach ($attributes as $attr) {
                if (!empty($attr['name']) && !empty($attr['value'])) {
                    $product->attributes()->create($attr);
                }
            }

            return $product;
        });
    }

    public function update(int $id, array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->repo->find($id);

            if (isset($data['image_file'])) {
                if ($product->image) Storage::disk('public')->delete($product->image);
                $data['image'] = $data['image_file']->store('products', 'public');
                unset($data['image_file']);
            }

            $attributes = $data['attributes'] ?? null;
            unset($data['attributes']);

            // is_active tetap ada di $data dan akan diupdate
            $updated = $this->repo->update($id, $data);

            if ($attributes !== null) {
                $updated->attributes()->delete();
                foreach ($attributes as $attr) {
                    if (!empty($attr['name']) && !empty($attr['value'])) {
                        $updated->attributes()->create($attr);
                    }
                }
            }

            return $updated;
        });
    }
    public function delete(int $id): bool
    {
        $product = $this->repo->find($id);

        // Cek apakah produk punya transaksi stok
        $hasTransactions = $product->stockTransactions()->exists();

        if ($hasTransactions) {
            // Jika punya transaksi, nonaktifkan saja (jangan hapus)
            $product->update(['is_active' => false]);
            return false; // return false = nonaktif, bukan dihapus
        }

        // Jika tidak punya transaksi, hapus gambar lalu hapus produk
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $this->repo->delete($id);
    }

    public function getLowStock()
    {
        return $this->repo->getLowStock();
    }
}
