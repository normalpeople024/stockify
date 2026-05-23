<?php
// app/Services/StockTransactionService.php

namespace App\Services;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Repositories\StockTransactionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockTransactionService
{
    public function __construct(private StockTransactionRepository $repo) {}

    public function getAll(array $filters = [])
    {
        return $this->repo->all($filters);
    }

    public function find(int $id): StockTransaction
    {
        return $this->repo->find($id);
    }

    public function createIn(array $data): StockTransaction
    {
        return DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);

            $data['user_id']      = Auth::id();
            $data['type']         = StockTransaction::TYPE_IN;
            $data['status']       = StockTransaction::STATUS_PENDING;
            $data['stock_before'] = $product->stock;
            $data['stock_after']  = $product->stock + $data['quantity'];
            $data['reference_no'] = $data['reference_no'] ?? StockTransaction::generateRef('in');

            return $this->repo->create($data);
        });
    }

    public function createOut(array $data): StockTransaction
    {
        return DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);

            if ($product->stock < $data['quantity']) {
                throw new \Exception("Stok tidak mencukupi. Stok tersedia: {$product->stock}");
            }

            $data['user_id']      = Auth::id();
            $data['type']         = StockTransaction::TYPE_OUT;
            $data['status']       = StockTransaction::STATUS_PENDING;
            $data['stock_before'] = $product->stock;
            $data['stock_after']  = $product->stock - $data['quantity'];
            $data['reference_no'] = $data['reference_no'] ?? StockTransaction::generateRef('out');

            return $this->repo->create($data);
        });
    }

    public function confirm(int $id): StockTransaction
    {
        return DB::transaction(function () use ($id) {
            $trx     = $this->repo->find($id);
            $product = $trx->product;

            if ($trx->status !== StockTransaction::STATUS_PENDING) {
                throw new \Exception('Transaksi sudah diproses sebelumnya.');
            }

            if ($trx->type === StockTransaction::TYPE_IN) {
                $product->increment('stock', $trx->quantity);
            } elseif ($trx->type === StockTransaction::TYPE_OUT) {
                if ($product->stock < $trx->quantity) {
                    throw new \Exception('Stok tidak mencukupi untuk dikonfirmasi.');
                }
                $product->decrement('stock', $trx->quantity);
            }

            // Simpan siapa yang konfirmasi di kolom notes tambahan
            $updated = $this->repo->update($id, [
                'status'       => StockTransaction::STATUS_CONFIRMED,
                'confirmed_by' => Auth::id(),  // ← simpan user yang konfirmasi
                'confirmed_at' => now(),
            ]);

            return $updated;
        });
    }

    public function reject(int $id, string $reason = ''): StockTransaction
    {
        $trx = $this->repo->find($id);

        if ($trx->status !== StockTransaction::STATUS_PENDING) {
            throw new \Exception('Transaksi sudah diproses sebelumnya.');
        }

        return $this->repo->update($id, [
            'status'       => StockTransaction::STATUS_REJECTED,
            'notes'        => $reason ?: $trx->notes,
            'confirmed_by' => Auth::id(),  // ← simpan user yang menolak
            'confirmed_at' => now(),
        ]);
    }

    public function getDashboardSummary(): array
    {
        return [
            'today_in'      => $this->repo->todayIn(),
            'today_out'     => $this->repo->todayOut(),
            'pending_count' => $this->repo->pendingCount(),
            'recent'        => $this->repo->recentActivity(8),
        ];
    }
}
