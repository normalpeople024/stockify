<?php
// app/Repositories/StockTransactionRepository.php

namespace App\Repositories;

use App\Models\StockTransaction;
use Illuminate\Pagination\LengthAwarePaginator;

class StockTransactionRepository
{
    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = StockTransaction::with(['product', 'user']);

        if (!empty($filters['type']))       $query->where('type', $filters['type']);
        if (!empty($filters['status']))     $query->where('status', $filters['status']);
        if (!empty($filters['product_id'])) $query->where('product_id', $filters['product_id']);
        if (!empty($filters['date_from']))  $query->whereDate('date', '>=', $filters['date_from']);
        if (!empty($filters['date_to']))    $query->whereDate('date', '<=', $filters['date_to']);

        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }

    public function find(int $id): StockTransaction
    {
        return StockTransaction::with(['product', 'user'])->findOrFail($id);
    }

    public function create(array $data): StockTransaction
    {
        return StockTransaction::create($data);
    }

    public function update(int $id, array $data): StockTransaction
    {
        $trx = $this->find($id);
        $trx->update($data);
        return $trx->fresh();
    }

    public function todayIn(): int
    {
        return StockTransaction::in()->confirmed()->whereDate('date', today())->sum('quantity');
    }

    public function todayOut(): int
    {
        return StockTransaction::out()->confirmed()->whereDate('date', today())->sum('quantity');
    }

    public function pendingCount(): int
    {
        return StockTransaction::pending()->count();
    }

    public function recentActivity(int $limit = 10)
    {
        return StockTransaction::with(['product', 'user'])->latest()->limit($limit)->get();
    }
}
