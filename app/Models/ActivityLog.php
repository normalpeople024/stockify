<?php
// app/Models/ActivityLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'properties',
    ];

    protected $casts = ['properties' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'login'   => 'Login',
            'logout'  => 'Logout',
            'create'  => 'Tambah',
            'update'  => 'Ubah',
            'delete'  => 'Hapus',
            'confirm' => 'Konfirmasi',
            'reject'  => 'Tolak',
            default   => ucfirst($this->action),
        };
    }

    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'login'          => 'bg-blue-50 text-blue-700',
            'logout'         => 'bg-gray-100 text-gray-600',
            'create'         => 'bg-green-50 text-green-700',
            'update'         => 'bg-amber-50 text-amber-700',
            'delete'         => 'bg-red-50 text-red-700',
            'confirm'        => 'bg-green-50 text-green-700',
            'reject'         => 'bg-red-50 text-red-700',
            default          => 'bg-gray-100 text-gray-600',
        };
    }
}
