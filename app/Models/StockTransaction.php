<?php
// app/Models/StockTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'user_id',
        'confirmed_by',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'date',
        'status',
        'notes',
        'reference_no',
        'confirmed_at',
    ];

    protected $casts = [
        'date'         => 'date',
        'confirmed_at' => 'datetime',  // ← tambah
    ];

    const TYPE_IN     = 'in';
    const TYPE_OUT    = 'out';
    const TYPE_OPNAME = 'opname';

    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REJECTED  = 'rejected';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'in'     => 'Barang Masuk',
            'out'    => 'Barang Keluar',
            'opname' => 'Stock Opname',
            default  => '-',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'rejected'  => 'Ditolak',
            default     => '-',
        };
    }

    public function scopeIn($query)
    {
        return $query->where('type', self::TYPE_IN);
    }
    public function scopeOut($query)
    {
        return $query->where('type', self::TYPE_OUT);
    }
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
    public function confirmedByUser()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public static function generateRef(string $type): string
    {
        $prefix = match ($type) {
            'in'     => 'IN',
            'out'    => 'OUT',
            'opname' => 'OPN',
            default  => 'TRX',
        };
        return $prefix . '-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }
}
