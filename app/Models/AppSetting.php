<?php
// app/Models/AppSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    protected $fillable = ['key', 'value'];

    // Ambil nilai setting
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    // Simpan nilai setting
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting_{$key}");
    }

    // Ambil banyak setting sekaligus
    public static function getMany(array $keys): array
    {
        return collect($keys)->mapWithKeys(fn($key) => [
            $key => static::get($key)
        ])->toArray();
    }
}
